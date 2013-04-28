<?php

class Passport extends AppModel {
	var $name = 'Passport';
	var $hasOne = array(
		'T_user' => array(
			'className' => 'T_user',
			'conditions' => 'T_user.id = Passport.t_user_id',
			'order' => '',
			'dependent' => false,
			'foreignKey' => ''
		)
	);
}

?>