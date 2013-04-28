<?php

class Character extends AppModel {
	var $name = 'Character';
	var $hasMany = array("Character_history");

	public $validate = array(
		'name' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'エラー: なまえ は かならずにゅうりょくしてください。'
				),
				array( 'rule' => VALID_NAME,
					   'message' => 'エラー: なまえは ひら カナ はんかくえいすうじ のみつかえます。'
				)
		),
		'image_url' => array(
				array( 'rule' => 'notEmpty',
					   'message' => 'エラー: イメージ は かならずにゅうりょくしてください。'
				)
		),
		'hitpoint' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'エラー: たいりょく は かならずにゅうりょくしてください。'
				),
				array( 'rule' => 'numeric',
					   'required' => true,
					   'message' => 'エラー: すうじ を にゅうりょくしてください。'
				)
		),
		'attack' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'エラー: こうげき は かならずにゅうりょくしてください。'
				),
				array( 'rule' => 'numeric',
					   'required' => true,
					   'message' => 'エラー: すうじ を にゅうりょくしてください。'
				)
		),
		'defense' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'エラー: ぼうぎょ は かならずにゅうりょくしてください。'
				),
				array( 'rule' => 'numeric',
					   'required' => true,
					   'message' => 'エラー: すうじ を にゅうりょくしてください。'
				)
		),
		'speed' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'エラー: すばやさ は かならずにゅうりょくしてください。'
				),
				array( 'rule' => 'numeric',
					   'required' => true,
					   'message' => 'エラー: すうじ を にゅうりょくしてください。'
				)
		),
		'lucky' => array(
				array( 'rule' => 'notEmpty',
					   'last' => true,
					   'message' => 'エラー: うん は かならずにゅうりょくしてください。'
				),
				array( 'rule' => 'numeric',
					   'required' => true,
					   'message' => 'エラー: すうじ を にゅうりょくしてください。'
				)
		),
		'critical_hit' => array(
				array( 'rule' => VALID_NAME,
					   'allowEmpty' => true,
					   'message' => 'エラー: ひっさつわざ は ひら カナ はんかくえいすうじ のみつかえます。'
				)
		),
	);

}

?>