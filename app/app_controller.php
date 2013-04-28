<?php

class AppController extends Controller {
	var $uses = array('T_user', 'Passport');
	var $components = array('Cookie', 'Session');
	var $expires = "4 weeks"; // パスポートの有効期限

	function beforeFilter(){
		$this->Auth->userModel = 'T_user';
		$this->Auth->fields = array('username' => 'access_token_key',
									'password' => 'access_token_secret');
		$this->Auth->loginAction = '/members/';
	}

	function passCheck(){
		$cookiePassport = $this->Cookie->Read('passport');
		if($cookiePassport){
			//クッキーに記録したパスポートでログインしてみる
			$deadline = date('Y-m-d H:i:s', strtotime("-".$this->expires));
			//	比較演算子はキー側に（1.2betaからRCで仕様変更）
			$options = array('conditions' => array('Passport.passport' => $cookiePassport,
												   'Passport.updated >' => $deadline));
			$passport = $this->Passport->find("first", $options);
			if($passport){
				//該当するパスポートが見つかった
				$user['T_user']["access_token_key"] = $passport['T_user']['access_token_key'];
				$user['T_user']["access_token_secret"] = $passport['T_user']['access_token_secret'];
				if($this->Auth->login($user)){
					// ログインできたので、クッキーを更新してリダイレクトする
					$this->passportWrite($passport);
					return true;
				}
			}
		}
		return false;
	}

	function passportWrite($user){
		$passport = array();
		$passport['t_user_id'] = $user['T_user']['id'];
		$passport['passport'] = Security::generateAuthKey(); // 識別用にユニークなキーを生成
		if(isset($user['Passport']['id'])){
			$passport['id'] = $user['Passport']['id'];
		}
		$this->Passport->save($passport);
		$this->Cookie->write('passport', $passport['passport'], false, "+{$this->expires}");
	}

	function passportDelete($user){
		$this->Cookie->delete('passport');
		$condition = array("Passport.t_user_id" => $user['T_user']['id']);
		$this->Passport->deleteAll($condition);
	}

	/**
	 * ファイルアップロード
	 */
	function fileUpload() {
		$this->autoRender = false;
		$this->uses = null;
		Configure::write('debug', 0);

		$img_path = $this->params['form']['img_path'];
		$cmd = sprintf("/usr/bin/wget %s -P tmp -nc", $img_path);
		system($cmd);
		$split_path = explode('/', $img_path);
		$file = sprintf("/tmp/%s", end($split_path));
		$cmd2 = sprintf("convert tmp/%s -resize 280x280\> tmp/%s", end($split_path), end($split_path));
		system($cmd2);
		return $file;
	}
}

?>