<?php

class T_user extends AppModel {
	var $name = 'T_user';
	var $hasMany = array("TweetBox", "Character");

	/*
	 * うまい具合にメンバーの登録・更新ができる関数
	 */
	public function update($t_data){
		$t_user = $this->find('first', array('conditions' => array('t_id' => $t_data['t_id'])));
		if($t_user) {
			$t_data['id'] = $t_user['T_user']['id'];
		}
		$this->create();
		$this->save(Array("T_user" => $t_data));
	}
}

?>