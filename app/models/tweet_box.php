<?php

class TweetBox extends AppModel {
	var $name = 'TweetBox';

	public $validate = array(
		'receiver' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'アカウント は かならずにゅうりょくしてください。'
				),
				array( 'rule' => array('custom', '/^[a-z\d_]+$/i'),
					   'required' => true,
					   'message' => 'アカウント は はんかくえいすうじ のみつかえます。'
				),
				array( 'rule' => array('valCheack'),
					   'required' => true,
					   'message' => 'アカウント に @ はひつようありません。'
				)
		),
		'msg' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'メッセージ は かならずにゅうりょくしてください。'
				),
				array( 'rule' => VALID_NAME,
					   'message' => 'メッセージ は ひら カナ はんかくえいすうじ のみつかえます。'
				)
		),
	);

	function beforeSave(){
		if(isset($this->data['TweetBox']['msg'])){
			$this->data['TweetBox']['msg'] = sprintf("@%s %s", $this->data['TweetBox']['receiver'], $this->data['TweetBox']['msg']);
		}
		return true;
	}

	function valCheack($data){
		if(preg_match('/@/', $data['receiver'])){
			return false;
		} else {
			return true;
		}
	}

 	function strCheack($data){
		$pattern = '/^(?:\xE3\x81[\x81-\xBF]|\xE3\x82[\x80-\x93]|\xE3\x82[\xA1-\xBF]|\xE3\x83[\x80-\xB6]|[0-9]|[a-zA-Z]|_|ー|-|‐|―|゛|゜|。)+$/';
		if(preg_match($pattern, $data['msg'])){
			return true;
		} else {
			return false;
		}
	}

	// 対戦を申し込んできているユーザー一覧
	function getRecTweetArr($auth){
		$recTweetArr = $this->find('all', array(
										 'conditions' => array('receiver' => $auth['T_user']['name'],
															   'enable_flag' => 1,
															   'del_flag' => 0,
											 ),
											'order' => 'TweetBox.created desc',
									  ));
		return $recTweetArr;
	}

	// 対戦を申し込みしているユーザー一覧
	function getSenTweetArr($auth){
		$senTweetArr = $this->find('all', array(
										 'conditions' => array('sender' => $auth['T_user']['name'],
															   'del_flag' => 0,
											 ),
											'order' => 'TweetBox.created desc',
									  ));
		return $senTweetArr;
	}

}

?>
