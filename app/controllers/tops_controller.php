<?php

class TopsController extends AppController {
	var $name = 'Tops';
	var $uses = array('T_user');
	var $components = array('Auth');
	var $layout = "base";

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index');
		$this->Auth->allow('desc');
	}

	public function index(){
		$auth = $this->Session->read('Auth');
		if(isset($auth['T_user']['t_id'])) {
			$this->set('status', 1);
		} else {
			if($this->passCheck()){
				$this->redirect('/members/');
			}
			$this->set('status', 0);
		}
	}

	public function desc(){
	}

}

?>