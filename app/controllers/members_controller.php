<?php
App::import('Vendor', 'oauth', array('file' => 'OAuth/oauth_consumer.php'));
class MembersController extends AppController {

	var $name = 'Members';
	var $uses = array('T_user', 'Passport', 'Character', 'TweetBox', 'History', 'Result_log', 'Character_history',);
	var $components = array('Auth', 'Cookie', 'Session');
	var $layout = "base";
	var $expires = "4 weeks"; // パスポートの有効期限

	var $paginate = array(
			'Character' => array(
				'conditions' => array(
					"Character.del_flag" => 0,
				),
				'order' => 'Character.updated desc',
				'limit' => 6,
			),
			'History' => array(
				'order' => 'History.created desc',
				'limit' => 6,
			)
		);

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login', 'twitter', 'twitter_callback');
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user']) || $this->passCheck()){
			if(!isset($auth['T_user'])){
				$auth = $this->Auth->user();
			}
			$this->set('userArr', $auth['T_user']);
			$pHistoryArr = $this->Character->find('all', array('conditions' => array('t_user_id' => $auth['T_user']['id'],
																					 'del_flag' => 0)));

			// ユーザー戦歴を取得
			$battle_count = $this->History->find('count', array('conditions' => array('t_user_id' => $auth['T_user']['id'])));
			$win_count = $this->History->find('count', array('conditions' => array('t_user_id' => $auth['T_user']['id'],
																				   'win_flag' => 1)));
			$loose_count = $this->History->find('count', array('conditions' => array('t_user_id' => $auth['T_user']['id'],
																					 'win_flag' => 0)));

			// キャラクター戦歴を取得
			$historyData = array();
			$i = 0;
			foreach($pHistoryArr as $row){
				$battle = 0;
				$win = 0;
				$lose = 0;
				foreach($row['Character_history'] as $ph_row){
					if($ph_row['win_flag'] == 1 ){
						$win += 1;
					} else {
						$lose += 1;
					}
					$battle += 1;
				}
				$historyData[$i]['name'] = $row['Character']['name'];
				$historyData[$i]['battle'] = $battle;
				$historyData[$i]['win'] = $win;
				$historyData[$i]['lose'] = $lose;
				++$i;
			}
			$this->set('battle_count', $battle_count);
			$this->set('win_count', $win_count);
			$this->set('loose_count', $loose_count);
			$this->set('historyData', $historyData);
			$this->set('userArr', $auth['T_user']);
		}
	}

	public function login(){
		$auth = $this->Session->read('Auth');
		// 認証する
		if(isset($auth['T_user']['t_id'])) {
			$this->redirect('/members/');
		} else {
			if(!empty($this->data)){
				if($this->data['T_user']['remember_me'] == 1){
					$this->Cookie->write('remember_me', 1, false, "+{$this->expires}");
				} else {
					$this->Cookie->write('remember_me', 0, false, "+{$this->expires}");
				}
				$this->redirect('/members/twitter/');
			} else {
				$this->redirect('/members/');
			}
		}
	}

	public function logout(){
		$auth = $this->Session->read('Auth');
		if($auth['T_user']['t_id']) {
			$this->passportDelete($auth);
			$this->Auth->logout();
			$this->redirect('/');
		} else {
			$this->redirect('/');
		}
	}

	public function index(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			$dataArr = $this->T_user->getRowData('t_id', $auth['T_user']['t_id']);
			// 対戦を申し込んできているユーザー一覧
			$recTweetArr = $this->TweetBox->getRecTweetArr($auth);
			// 対戦を申し込みしているユーザー一覧
			$senTweetArr = $this->TweetBox->getSenTweetArr($auth);
			$this->set('dataArr', $dataArr);
			$this->set('senTweetArr', $senTweetArr);
			$this->set('recTweetArr', $recTweetArr);
		} else {
			$this->redirect('/');
		}
	}

	public function character_list(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			$conditions = array('t_user_id' => $auth['T_user']['id']);
			$dataArr = $this->paginate('Character', $conditions);
			$this->set('dataArr', $dataArr);
			$this->render('character/index');
		} else {
			$this->redirect('/');
		}
	}

	public function user_list(){
		$sql1 = <<<EOD
			SELECT
				receiver,
				sender,
				receiver_image_url
			FROM
				tweet_boxes
			WHERE
				sender = ?
			GROUP BY receiver
			ORDER BY receiver
EOD;
		$sql2 = <<<EOD
			SELECT
				receiver,
				sender,
				sender_image_url
			FROM
				tweet_boxes
			WHERE
				receiver = ?
			GROUP BY sender
			ORDER BY receiver
EOD;
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			$receiverArr = $this->TweetBox->query($sql1, array($auth['T_user']['name'])); // 自分が戦いを挑んだことのあるユーザー
			$senderArr = $this->TweetBox->query($sql2, array($auth['T_user']['name'])); // 自分が戦いを挑どまれたことのあるユーザー
			// 自分が戦いを挑どまれたことのあるユーザー情報から自分が戦いを挑んだことのあるユーザー情報をなくした差分をとる
			$usersdiff = array_diff_assoc($senderArr, $receiverArr);
			// 差分をマージする
			$usersArr = '';
			foreach($receiverArr as $row){
				$usersArr[] = array('name' => $row['tweet_boxes']['receiver'],
									'image_url' => $row['tweet_boxes']['receiver_image_url']);
			}
			foreach($usersdiff	as $row){
				$usersArr[] = array('name' => $row['tweet_boxes']['sender'],
									'image_url' => $row['tweet_boxes']['sender_image_url']);
			}
			$this->set('usersArr', $usersArr);
		} else {
			$this->redirect('/');
		}
	}

	public function history_list(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			$conditions = array('History.t_user_id' => $auth['T_user']['id']);
			$dataArr = $this->paginate('History', $conditions);
			$this->set('dataArr', $dataArr);
		} else {
			$this->redirect('/');
		}
	}

	public function tweet($mode = 'regist'){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			if(isset($this->params['pass']['0'])){
				$mode = $this->params['pass']['0'];
			}
			switch($mode){
				case 'regist':
					if(isset($this->params['url']['ac'])){
						$name = $this->params['url']['ac'];
						$msg = sprintf('%s がたたかいをもうしこんでます。', $auth['T_user']['name']);
						$this->set('msg', $msg);
						$this->set('name', $name);
					}
					if(isset($this->params['url']['ti']) && isset($this->params['url']['hi'])){
						$tweetBoxArr = $this->TweetBox->find('first', array('conditions' => array('TweetBox.id' => $this->params['url']['ti'])));
						$historyArr = $this->History->find('first', array('conditions' => array('History.id' => $this->params['url']['hi'])));
						$win_flag = $historyArr['History']['win_flag'] == 1 ?  "勝ち" : "負け" ;
						$msg = sprintf('%s@%s が %s@%s に%sました。', $historyArr['History']['rec_character_name'], $auth['T_user']['name'], $historyArr['History']['sen_character_name'], $historyArr['History']['sender_name'], $win_flag);
						$this->set('id', $tweetBoxArr['TweetBox']['id']);
						$this->set('t_user_id', $tweetBoxArr['TweetBox']['t_user_id']);
						$this->set('msg', $msg);
						$this->render('/members/tweet/public_tweet');
						break;
					}
					$this->render('/members/tweet/regist');
				break;
				case 'send':
					if(isset($this->data['TweetBox'])){
						$this->TweetBox->set($this->data['TweetBox']);
						$error = $this->validateErrors($this->TweetBox);
						// 結果のツイートでは、余分なバリデートチェックはしない
						if(!isset($this->data['TweetBox']['t_user_id'])){
							$characterArr = $this->Character->find('first',	 array('conditions' => array('Character.t_user_id' => $auth['T_user']['id'],
																									 'Character.main_flag' => 1)));
							if(!is_array($characterArr)){
								$error['tweet'] = "たいせんキャラ が せってい もしくは せんたく されてません。";
							}
							if($this->data['TweetBox']['receiver'] == $auth['T_user']['name']){
								$error['my_name'] = "じぶんあてに ツイート することはできません。";
							}
						} else {
							$error = "";
						}
						if($error){
							$this->set('errors', $error);
							$this->set('error_msg', "ツイートエラー:");
							if(isset($error['tweet'])){
								$this->set('character_error', $error['tweet']);
							}
							if(isset($error['my_name'])){
								$this->set('my_name_error', $error['my_name']);
							}
							$this->render('/members/tweet/regist');
						} else {
							$consumer = $this->createConsumer();
							$dataArr = $this->T_user->getRowData('t_id', $auth['T_user']['t_id']);
							// 結果のツイートでは、受信者チェックはしない
							if(!isset($this->data['TweetBox']['t_user_id'])){
								// 相手の情報を取得
								$jsonArr = $consumer->get($dataArr['T_user']['access_token_key'],
														  $dataArr['T_user']['access_token_secret'],
														  sprintf("http://api.twitter.com/1/users/show/%s.json", $this->data['TweetBox']['receiver'], array()));
								$twitterData = json_decode($jsonArr, true);
								// 存在しないアカウントだった場合
								if(isset($twitterData['error']) && $twitterData['error'] == 'Not found'){
									$this->set('account_error', "アカウント が そんざいしてません。");
									$this->render('/members/tweet/regist');
									break;
								}
							}
							if(isset($this->data['TweetBox']['t_user_id'])){
								// 結果をツイート
								$long_url = sprintf("http://tweet-quest.com/archives?pu=%s%s", md5($this->data['TweetBox']['id']), md5($this->data['TweetBox']['t_user_id']));
								$public_url = $this->getShortUrl($long_url);
								$tweetMsg = sprintf("%s %s", $this->data['TweetBox']['msg'], $public_url);
								$consumer->post($dataArr['T_user']['access_token_key'],
												$dataArr['T_user']['access_token_secret'],
												'http://api.twitter.com/1/statuses/update.json',
												array('status' => $tweetMsg));
								$this->TweetBox->id = $this->data['TweetBox']['id'];
								$this->TweetBox->saveField('shorturl', $public_url );
								$this->redirect('/members/tweet/public_comp');
							} else {
								// 戦いの申し込みツイート
								if($this->data['TweetBox']['public_flag'] == 1){
									$tweetMsg = sprintf("@%s %s %s", $this->data['TweetBox']['receiver'], $this->data['TweetBox']['msg'], "bit.ly/75imdg");
									$consumer->post($dataArr['T_user']['access_token_key'],
													$dataArr['T_user']['access_token_secret'],
													'http://api.twitter.com/1/statuses/update.json',
													array('status' => $tweetMsg));
								}
								// ツイートを保存
								$this->data['TweetBox']['msg'] = $this->data['TweetBox']['msg'];
								$this->data['TweetBox']['t_user_id'] = $auth['T_user']['t_id'];
								$this->data['TweetBox']['sender'] = $auth['T_user']['name'];
								$this->data['TweetBox']['sender_image_url'] = $auth['T_user']['profile_image_url'];
								$this->data['TweetBox']['sen_character_id'] = $characterArr['Character']['id'];
								$this->data['TweetBox']['receiver'] = $twitterData["screen_name"];
								$this->data['TweetBox']['receiver_image_url'] = $twitterData["profile_image_url"];
								$this->TweetBox->save($this->data['TweetBox']);
								$this->redirect('/members/tweet/comp');
							}
						}
					} else {
						$this->redirect('/');
					}
				break;
				case 'public_comp':
					$this->render('/members/tweet/public_comp');
				break;
				case 'comp':
					$this->render('/members/tweet/comp');
				break;
			}
		} else {
			$this->redirect('/');
		}
	}

	private function getShortUrl($long_url){
		$account_name = "fujimisakari";
		$api_key = "R_a80897fcb576c9bad1525e8caa7d6b6b";
		$req = sprintf("http://api.bit.ly/shorten?login=%s&apiKey=%s&version=2.0.1&longUrl=%s", $account_name, $api_key, $long_url);
		$contents = file_get_contents($req);
		if(isset($contents)) {
			$url = json_decode($contents, true);
		}
		return $url['results'][$long_url]['shortUrl'];
	}

	public function cancel(){
		$auth = $this->Session->read('Auth');
		$typeArr = array("sen" => array('sender', 'del_flag', 1),
						 "rec" => array('receiver', 'del_flag', 1));
		if(isset($auth['T_user'])) {
			if(isset($this->params['pass']['0']) && isset($this->params['pass']['1'])){
				$type = $this->params['pass']['0'];
				$tweetID = $this->params['pass']['1'];
				$row = $this->TweetBox->getRowData('id', $tweetID);
				if($row['TweetBox'][$typeArr[$type][0]] == $auth['T_user']['name']){
					$this->TweetBox->id = $tweetID;
					$this->TweetBox->saveField($typeArr[$type][1] , $typeArr[$type][2]);
					$this->redirect('/members');
				} else {
					$this->render('/members/error');
				}
			} else {
				$this->render('/members/error');
			}
		} else {
			$this->redirect('/');
		}
	}

	public function character(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			if(isset($this->params['pass']['0'])){
				$mode = $this->params['pass']['0'];
			}
			switch($mode){
				case 'add':
					$this->render('character/add');
					break;
				case 'edit':
					if(isset($this->params['pass']['1'])){
						$pid = $this->params['pass']['1'];
						$dataArr = $this->Character->getRowData('id', $pid);
						$userArr = $this->T_user->getRowData('t_id', $auth['T_user']['t_id']);
						$dataArr['T_user']['name'] = $userArr['T_user']['name'];
						$dataArr['T_user']['original_image_url'] = $userArr['T_user']['original_image_url'];
						if($dataArr['Character']['t_user_id'] == $auth['T_user']['id']){
							$this->set('dataArr', $dataArr);
							$this->set('editFrom', 1);
							$this->render('character/edit');
						} else {
							$this->render('/members/error');
						}
					} else {
						$this->redirect('/members');
					}
					break;
				case 'delete':
					if(!empty($this->data['Character'])){
						$this->Character->id = $this->data['Character']['id'];
						$this->Character->saveField('del_flag', '1');
						$this->redirect('/members/index/character');
					} else {
						$this->redirect('/members');
					}
					break;
				case 'process':
					if(!empty($this->data['Character'])){
						$this->Character->set($this->data['Character']);
						$error = $this->validateErrors($this->Character);
						if($error){
							$this->set('errors', $error);
							$this->render('character/add');
						} else {
							if(!isset($this->data['Character']['id'])){
								// 新規登録の場合は、一度仮登録する
								$this->data['Character']['t_user_id'] = $auth['T_user']['id'];
								$this->Character->save($this->data['Character']);
								$this->data['Character']['id'] = $this->Character->getLastInsertID();
								$is_regist = 1;
							}
							$tmp_file = '.'.$this->data['Character']['image_url'];
							$ext = explode('.', $this->data['Character']['image_url']);
							$file_name = sprintf("img_%s.%s", $this->data['Character']['id'], end($ext));
							$file_path = sprintf("./download/character_img/%s/%s", $auth['T_user']['name'], $file_name);
							copy($tmp_file, $file_path);
							$cmd = sprintf("/usr/bin/convert %s -type GrayScale ./download/character_img/%s/gray_%s", $file_path, $auth['T_user']['name'], $file_name);
							system($cmd);
							$url_path = sprintf("/download/character_img/%s/%s", $auth['T_user']['name'], $file_name);
							$this->data['Character']['image_url'] = $url_path;
							if($this->data['Character']['main_flag'] == 1){
								$this->Character->updateAll(array('main_flag' => 0), array('t_user_id' => $auth['T_user']['id']));
							}
							$this->Character->save($this->data['Character']);
							if(isset($is_regist)){
								$this->redirect('/members/character/comp/regist');
							} else {
								$this->redirect('/members/character/comp/edit');
							}
						}
					} else {
						$this->redirect('/');
					}
					break;
				case 'comp':
					if($this->params['pass'][1] == 'edit'){
						$this->set('msg', "へんしゅう");
					} else {
						$this->set('msg', "とうろく");
					}
					$this->render('character/comp');
					break;
			}
		} else {
			$this->redirect('/');
		}
	}

	public function battle(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			if(isset($this->params['pass']['0'])){
				$mode = $this->params['pass']['0'];
			} else {
				$mode = 'index';
			}
			switch($mode){
				case 'index':
					$characterArr = $this->Character->find('first',  array('conditions' => array('t_user_id' => $auth['T_user']['id'],
																							 'del_flag' => 0,
																							 'main_flag' => 1)));
					if(!is_array($characterArr)){
							$error['tweet'] = "たいせんキャラ が とうろく もしくは せんたく されてません。";
					}
					if(isset($error)){
						$this->set('error_msg', "ツイートエラー:");
						if(isset($error['tweet'])){
							$this->set('character_error', $error['tweet']);
						}
						$this->render('/members/error');
					} else {
						$id = $this->params['url']['id'];
						$row = $this->TweetBox->getRowData('id', $id);
						$receiverArr = $this->T_user->find('first', array('conditions' => array('name' => $row['TweetBox']['receiver'])));
						$senderArr = $this->T_user->find('first', array('conditions' => array('name' => $row['TweetBox']['sender'])));
						$this->set('senCharacterId', $row['TweetBox']['sen_character_id']);
						$this->set('receiverArr', $receiverArr);
						$this->set('senderArr', $senderArr);
						$this->set('tweetboxId', $id);
						$this->render('/members/battle/index');
					}
					break;
				case 'result':
					// 対戦結果がすでに登録されているリクエストは実行しない
					$tweetboxArr = $this->TweetBox->find('first', array('conditions' => array('id' => $this->params['data']['tweetboxId'])));
					if($tweetboxArr['TweetBox']['result_flag'] == 1){
						$this->redirect('/members');
					}
					$receiverArr = $this->Character->find('first', array('conditions' => array('id' => $this->params['data']['Receiver']['character_id'])));
					$senderArr = $this->Character->find('first', array('conditions' => array('id' => $this->params['data']['Sender']['character_id'])));
					$receiver = $receiverArr['Character'];
					$sender = $senderArr['Character'];

					// すばやさのパラメータ
					$recDefultSpeed = $receiver['speed'];
					$senDefultSpeed = $sender['speed'];
					$recCurrentSpeed = $receiver['speed'];
					$senCurrentSpeed = $sender['speed'];

 					// うんのパラメータ
					$recDefultLucky = $receiver['lucky'];
					$senDefultLucky = $sender['lucky'];
					$recCurrentLucky = $receiver['lucky'];
					$senCurrentLucky = $sender['lucky'];
					$recLuckyVal = 10;
					$senLuckyVal = 10;

					// 回避フラグ
					$recEscVal = 2;
					$senEscVal = 2;

					$log = "";
					while($receiver['hitpoint'] > 0 && $sender['hitpoint'] > 0){
						if($recCurrentSpeed > $senCurrentSpeed){
							$randEscFlag = rand(0, 5);
							// 攻撃
							if($recLuckyVal <= 0){
								// 会心の一撃
								$damage = 20 + rand(1, 15);
								$sender['hitpoint'] = $sender['hitpoint'] - (int)$damage ;
								// ログ発行
								if($receiver['critical_hit'] == ''){
									$log .= "||{$receiver['name']} の かいしんのいちげき がさくれつ<br /><br /><>";
								} else {
									$log .= "||{$receiver['name']} の {$receiver['critical_hit']} がさくれつ<br /><br /><>";
								}
								$log .= "sen|{$damage}|{$sender['name']} は {$damage}ダメージ を うけた<>";
								$recLuckyVal = 10;
								$recEscVal = 2;
							} elseif($senLuckyVal <= 7 && $senEscVal > 0 && $randEscFlag > 4){
								// かわす
								$damage = 0;
								$senEscVal = $senEscVal - 1;
								// ログ発行
								$log .= "||{$receiver['name']} が こうげきした<br /><br /><>";
								$log .= "sen|{$damage}|{$sender['name']} は こうげきをかわした<>";
							} else {
								// 通常の攻撃
								$damage = $this->attack($receiver['attack'], $sender['defense']);
								$damage = (int)$damage;
								if($damage < 1){
									$damage = 1;
								}
								$sender['hitpoint'] = $sender['hitpoint'] - $damage;
								// ログ発行
								$log .= "||{$receiver['name']} が こうげきした<br /><br /><>";
								$log .= "sen|{$damage}|{$sender['name']} は {$damage}ダメージ を うけた<>";
							}
							// 攻撃順を調整
							$recCurrentSpeed = $recCurrentSpeed - ($senDefultSpeed + rand(1, 20));
							if($senCurrentSpeed <= 0){
								$senCurrentSpeed = $senDefultSpeed;
							}
							// 会心の一撃の調整
							$recCurrentLucky = $recCurrentLucky - ($senDefultLucky + rand(1, 20));
							if($recCurrentLucky <= 0){
								$recCurrentLucky = $recDefultLucky;
								$senLuckyVal = $senLuckyVal - (1 + rand(0, 2));
							}
						} elseif($senCurrentSpeed > $recCurrentSpeed) {
							$randEscFlag = rand(0, 5);
							// 攻撃
							if($senLuckyVal <= 0){
								// 痛恨の一撃
								$damage = 20 + rand(1, 15);
								$receiver['hitpoint'] = $receiver['hitpoint'] - (int)$damage ;
								// ログ発行
								if($sender['critical_hit'] == ''){
									$log .= "||{$sender['name']} の つうこんのいちげき がさくれつ<br /><br /><>";
								} else {
									$log .= "||{$sender['name']} の {$sender['critical_hit']} がさくれつ<br /><br /><>";
								}
								// ログ発行
								$log .= "rec|{$damage}|{$receiver['name']} は {$damage}ダメージ を うけた<>";
								$senLuckyVal = 10;
								$senEscVal = 2;
							} elseif($recLuckyVal <= 7 && $recEscVal > 0 && $randEscFlag > 3){
								// かわす
								$damage = 0;
								$recEscVal = $recEscVal - 1;
								// ログ発行
								$log .= "||{$sender['name']} が こうげきした<br /><br /><>";
								$log .= "rec|{$damage}|{$receiver['name']} は こうげきをかわした<>";
							} else {
								$damage = $this->attack($sender['attack'], $receiver['defense']);
								$damage = (int)$damage;
								if($damage < 1){
									$damage = 1;
								}
								$receiver['hitpoint'] = $receiver['hitpoint'] - $damage;
								// ログ発行
								$log .= "||{$sender['name']} が こうげきした<br /><br /><>";
								$log .= "rec|{$damage}|{$receiver['name']} は {$damage}ダメージ を うけた<>";
							}
							// 攻撃順を調整
							$senCurrentSpeed = $senCurrentSpeed - ($recDefultSpeed + rand(1, 20));
							if($recCurrentSpeed <= 0){
								$recCurrentSpeed = $recDefultSpeed;
							}
							// 会心の一撃の調整
							$senCurrentLucky = $senCurrentLucky - ($recDefultLucky + rand(1, 20));
							if($senCurrentLucky <= 0){
								$senCurrentLucky = $senDefultLucky;
								$recLuckyVal = $recLuckyVal - (1 + rand(0, 2));
							}
						} else {
							// 攻撃順が重なったとき運で決める
							if($receiver['lucky'] > $sender['lucky']){
								$recCurrentSpeed = $recCurrentSpeed + 1;
							}elseif($sender['lucky'] > $receiver['lucky']){
								$senCurrentSpeed = $senCurrentSpeed + 1;
							}else{
								// 運で決着がつかなかった場合
								$i = rand(1, 2);
								if($i == 1){
									$recCurrentSpeed = $recCurrentSpeed + 1;
								} else {
									$senCurrentSpeed = $senCurrentSpeed + 1;
								}
							}
						}
					}
					// 戦歴情報を設定
					$historyArr['Recruiter']['tweet_box_id'] = $this->params['data']['tweetboxId'];
					// 受信者
					$historyArr['Recruiter']['t_user_id'] = $auth['T_user']['id'];
					$historyArr['Recruiter']['sender_name'] = $this->params['data']['Sender']['user_name'];
					$historyArr['Recruiter']['rec_character_name'] = $receiver['name'];
					$historyArr['Recruiter']['sen_character_name'] = $sender['name'];
					// 送信者
					$historyArr['Sender']['tweet_box_id'] = $this->params['data']['tweetboxId'];
					$historyArr['Sender']['t_user_id'] = $this->params['data']['Sender']['user_id'];
					$historyArr['Sender']['sender_name'] = $auth['T_user']['name'];
					$historyArr['Sender']['rec_character_name'] = $sender['name'];
					$historyArr['Sender']['sen_character_name'] = $receiver['name'];
					if($receiver['hitpoint'] < 1){
						$log .= "ret_rec||{$receiver['name']} は まけた<br />";
						$historyArr['Recruiter']['win_flag'] = 0;
						$historyArr['Sender']['win_flag'] = 1;
					} elseif( $sender['hitpoint'] < 1){
						$log .= "ret_sen||{$receiver['name']} は かった<br />";
						$historyArr['Recruiter']['win_flag'] = 1 ;
						$historyArr['Sender']['win_flag'] = 0 ;
					}
					$this->History->save($historyArr['Recruiter']);
					$lastHistryID = $this->History->getLastInsertID();
					$this->History->create();
					$this->History->save($historyArr['Sender']);

					// コンキャラの戦歴を設定
					// 受信者
					$pHistoryArr['Recruiter']['character_id'] = $this->params['data']['Receiver']['character_id'];
					$pHistoryArr['Recruiter']['t_user_id'] = $auth['T_user']['id'];
					$pHistoryArr['Recruiter']['win_flag'] = $historyArr['Recruiter']['win_flag'];
					// 送信者
					$pHistoryArr['Sender']['character_id'] = $this->params['data']['Sender']['character_id'];
					$pHistoryArr['Sender']['t_user_id'] = $this->params['data']['Sender']['user_id'];
					$pHistoryArr['Sender']['win_flag'] = $historyArr['Sender']['win_flag'];
					$this->Character_history->save($pHistoryArr['Recruiter']);
					$this->Character_history->create();
					$this->Character_history->save($pHistoryArr['Sender']);

					// 申し込み情報を対戦済にする
					$this->TweetBox->id = $this->params['data']['tweetboxId'];
					$this->TweetBox->saveField('enable_flag', 0 );
					$this->TweetBox->saveField('result_flag', 1 );

					// 対戦結果を登録する
					$this->registLog($this->params['data']['tweetboxId'], $log, $receiverArr['Character'], $senderArr['Character'] );

					// グレー画像イメージPATHを取得
					$rec_file_name = explode("/", $receiverArr['Character']['image_url']);
					$sen_file_name = explode("/", $senderArr['Character']['image_url']);
					$rec_gray_img = sprintf("/download/character_img/%s/gray_%s", $auth['T_user']['name'], end($rec_file_name));
					$sen_gray_img = sprintf("/download/character_img/%s/gray_%s", $this->params['data']['Sender']['user_name'], end($sen_file_name));

					$this->set('rec_gray_img', $rec_gray_img);
					$this->set('sen_gray_img', $sen_gray_img);
					$this->set('log', $log);
					$this->set('tweet_id', $this->params['data']['tweetboxId']);
					$this->set('history_id', $lastHistryID);
					$this->set('sender_name', $this->params['data']['Sender']['user_name']);
					$this->set('receiver', $receiverArr['Character']);
					$this->set('sender', $senderArr['Character']);
					$this->render('/members/battle/result');
					break;
			}
		} else {
			$this->redirect('/');
		}
	}

	private function attack($atk, $def){
		$RAND_NUM = rand(10, 30);
		$e = $atk - ($def / 2);
		if($e <= 0){
			$e = rand(6, 12);
		}
		$damage = $e * (10 + $RAND_NUM) / 256;
		if($damage > 13){
			$damage = 10 + rand(0, 4);
		}
		return $damage;
	}

	private function registLog($tweetboxId, $log, $receiverArr, $senderArr){
		$data['Result_log']['tweet_boxes_id'] = $tweetboxId;
		$data['Result_log']['log'] = $log;

		$data['Result_log']['rec_name']      = $receiverArr['name'];
		$data['Result_log']['rec_image_url'] = $receiverArr['image_url'];
		$data['Result_log']['rec_hitpoint' ] = $receiverArr['hitpoint'];
		$data['Result_log']['rec_attack']	 = $receiverArr['attack'];
		$data['Result_log']['rec_defense']	 = $receiverArr['defense'];
		$data['Result_log']['rec_speed']	 = $receiverArr['speed'];
		$data['Result_log']['rec_lucky']	 = $receiverArr['lucky'];

		$data['Result_log']['sen_name']      = $senderArr['name'];
		$data['Result_log']['sen_image_url'] = $senderArr['image_url'];
		$data['Result_log']['sen_hitpoint' ] = $senderArr['hitpoint'];
		$data['Result_log']['sen_attack']	 = $senderArr['attack'];
		$data['Result_log']['sen_defense']	 = $senderArr['defense'];
		$data['Result_log']['sen_speed']	 = $senderArr['speed'];
		$data['Result_log']['sen_lucky']	 = $senderArr['lucky'];
		$this->Result_log->save($data['Result_log']);
	}

	public function battle_result(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user'])) {
			if(isset($this->params['pass']['0'])){
				$tweetID = $this->params['pass']['0'];
				$tweetBoxArr = $this->TweetBox->find('first', array('conditions' => array('id' => $tweetID,
																						  'OR' => array('receiver' => $auth['T_user']['name'],
																										'sender' => $auth['T_user']['name']))));
				if(!empty($tweetBoxArr)){
					if(isset($this->params['pass']['1']) && $this->params['pass']['1'] == 'archive'){
						$this->set('archive_flag', 1);
					} else {
						$this->TweetBox->id = $tweetID;
						$this->TweetBox->saveField('del_flag', 1);
						$historyArr = $this->History->find('first', array('conditions' => array('History.tweet_box_id' => $tweetID,
																								'History.t_user_id' => $auth['T_user']['id'])));
						$this->set('history_id', $historyArr['History']['id']);
						$this->set('sender_name', $historyArr['History']['sender_name']);
						$this->set('tweet_id', $tweetID);
					}
					$resultData = $this->Result_log->find('first', array('conditions' => array('tweet_boxes_id' => $tweetID)));
					// グレー画像イメージPATHを取得
					$rec_file_name = explode("/", $resultData['Result_log']['rec_image_url']);
					$sen_file_name = explode("/", $resultData['Result_log']['sen_image_url']);
					$rec_gray_img = sprintf("/download/character_img/%s/gray_%s", $rec_file_name[count($rec_file_name)-2], end($rec_file_name));
					$sen_gray_img = sprintf("/download/character_img/%s/gray_%s", $sen_file_name[count($sen_file_name)-2], end($sen_file_name));
					$this->set('back_url', $this->referer());
					$this->set('rec_gray_img', $rec_gray_img);
					$this->set('sen_gray_img', $sen_gray_img);
					$this->set('resultData', $resultData['Result_log']);
					$this->render('/members/battle/result_log');
				} else {
					$this->redirect('/members');
				}
			} else {
				$this->render('/members/error');
			}
		} else {
			$this->redirect('/');
		}
	}

	public function twitter(){
		$consumer = $this->createConsumer();
		$requestToken = $consumer->getRequestToken('https://api.twitter.com/oauth/request_token', 'http://tweet-quest.com/members/twitter_callback');
		$this->Session->write('twitter_request_token', $requestToken);
		$this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
	}

	/*
	 * Twitterからのレスポンス
	 */
	public function twitter_callback(){
		$consumer = $this->createConsumer();
		$requestToken = $this->Session->read('twitter_request_token');
		$accessToken = $consumer->getAccessToken('https://api.twitter.com/oauth/access_token', $requestToken);
		if($accessToken != '') {

			// Twitter からユーザーデータを取得
			$json = $consumer->get($accessToken->key, $accessToken->secret, 'http://twitter.com/account/verify_credentials.json', array());
			$twitterData = json_decode($json, true);

			// Twitterアカウントのオリジナル画像を取得
			// $wgetCmd = sprintf("/usr/bin/wget -O ./download/twitter_img/%s.jpg http://api.twitter.com/1/users/profile_image?screen_name=%s&size=original", $twitterData["screen_name"], $twitterData["screen_name"]);
			// $convertCmd = sprintf("/usr/bin/convert ./download/twitter_img/%s.jpg -resize 180x180 ./download/twitter_img/%s.jpg", $twitterData["screen_name"], $twitterData["screen_name"]);
			// system($wgetCmd);
			// system($convertCmd);
			// $original_image_url = sprintf("/download/twitter_img/%s.jpg", $twitterData["screen_name"]);
			$this->T_user->update(
					Array(
						"t_id"				  => $twitterData["id_str"],
						"name"				  => $twitterData["screen_name"],
						"access_token_key"    => $accessToken->key,
						"access_token_secret" => $accessToken->secret,
						"statuses_count"	  => $twitterData["statuses_count"],
						"followers_count"	  => $twitterData["followers_count"],
						"friends_count"		  => $twitterData["friends_count"],
						"location"			  => $twitterData["location"],
						"profile_image_url"	  => $twitterData["profile_image_url"],
						"original_image_url"  => $twitterData["profile_image_url"],
						// "original_image_url"  => $original_image_url,
						"description"		  => $twitterData["description"],
						)
					);

			$user['T_user']["access_token_key"] = $accessToken->key;
			$user['T_user']["access_token_secret"] = $accessToken->secret;

			// ユーザーディレクトリを作成
			$dir = "./download/character_img/{$twitterData["screen_name"]}";
			if(!is_dir($dir)){
				mkdir($dir);
			}
			if ($this->Auth->login($user)) {
				$user = $this->Auth->user();
				$isRemember = $this->Cookie->Read('remember_me');
				if($isRemember == 1){
					$this->passportWrite($user);
				} else {
					$this->passportDelete($user);
				}
				$this->redirect('/members/');
			}
			$this->redirect('/');
		} else {
			$this->cakeError('error404');
		}
	}

	private function createConsumer(){
		return new OAuth_Consumer('dylLFBI6CgCrarJ4HIGoww', '62wg0gvutUjB3WooyHQxrIquZQ0TX7ESE7qfF7qA0');
	}

	private function getRequestToken(){
		$auth = $this->Session->read('Auth');
		$token = md5($auth['T_user']['created'] . $auth['T_user']['id'] . 'SixjDklLT5mRuDEgRZPGQxYxpy9kC7iI');
		return $token;
	}

	private function requestAuth(){
		$auth = $this->Session->read('Auth');
		$tokenAuth = $this->Session->read('tweetquest_request_token');
		$tokenTemp = $this->getRequestToken();
		if($tokenAuth == $tokenTemp) {
			return true;
		} else {
			return false;
		}
	}
}
?>
