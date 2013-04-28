<?php

class ArchivesController extends AppController {

	var $name = 'Archives';
	var $uses = array('T_user', 'Character', 'TweetBox', 'Result_log');
	var $layout = "base";

	public function index(){
		if(isset($this->params['url']['pu'])){
			$url_prams = $this->params['url']['pu'];
			$t_id = mb_substr($url_prams, 0, 32);
			$t_user_id = mb_substr($url_prams, 32);
			$tweetBoxArr = $this->TweetBox->find('first', array('conditions' => array('md5(TweetBox.id)' => $t_id,
																					  'md5(TweetBox.t_user_id)' => $t_user_id)));
			if(!empty($tweetBoxArr)){
				$resultData = $this->Result_log->find('first', array('conditions' => array('tweet_boxes_id' => $tweetBoxArr['TweetBox']['id'])));
				// グレー画像イメージPATHを取得
				$rec_file_name = explode("/", $resultData['Result_log']['rec_image_url']);
				$sen_file_name = explode("/", $resultData['Result_log']['sen_image_url']);
				$rec_gray_img = sprintf("/download/character_img/%s/gray_%s", $rec_file_name[count($rec_file_name)-2], end($rec_file_name));
				$sen_gray_img = sprintf("/download/character_img/%s/gray_%s", $sen_file_name[count($sen_file_name)-2], end($sen_file_name));
				$this->set('back_url', $this->referer());
				$this->set('rec_gray_img', $rec_gray_img);
				$this->set('sen_gray_img', $sen_gray_img);
				$this->set('resultData', $resultData['Result_log']);
				$this->render('/archives/result_log');
			} else {
				$this->redirect('/');
			}
		} else {
			$this->redirect('/');
		}
	}
}

?>
