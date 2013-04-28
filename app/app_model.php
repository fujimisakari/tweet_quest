<?php

class AppModel extends Model {

	/**
	 * 一行データの取得
	 */
	public function getRowData($field, $val) {
		$ret = $this->find('first', array('conditions' => array($field => $val)));
		return $ret;
	}
}

?>