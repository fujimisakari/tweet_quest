<?php echo '<?xml version="1.0" encoding="utf-8"?>'; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ja" lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-style-type" content="text/css; charset=utf-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<title>Tweet Quest</title>
<meta name="description" content="" />
<meta name="keywords" content="*,*" />
<?php echo $html->css(array('reset', 'structure', 'style', 'textdecorations.css', 'jquery.fancybox.css', 'tweet')); ?>
<?php echo $html->script(array('jquery', 'common', 'jquery.fancybox.pack.js')); ?>
<?php
	//アクションごとにJSがあれば読み込む
	$ownJs = strtolower($this->name."_".$this->action);
	if (is_file(JS."{$ownJs}.js")) {
		echo $html->script($ownJs)."\n";
	}
?>
<?php
if($this->action == 'battle' && (isset($this->params['pass'][0]) && $this->params['pass'][0] == 'result') || $this->action == 'battle_result' || $this->name == 'Archives'){
	echo $html->script('battle')."\n";
}
?>
<?php
	// ボコキャラ登録、編集時に読み込む
	if($this->action == 'character' && ($this->params['pass'][0] == 'add' || $this->params['pass'][0] == 'edit' || $this->params['pass'][0] == 'process')){
?>
		<script src="https://www.google.com/jsapi?key=ABQIAAAAnX-lu43RX84BTgU_t8SMIhTKfdQE55q6BffBGq2IYayfF9wcthT0sSxXUS0I644z08j2-uF-VbeeMA" type="text/javascript"></script>
		<script type="text/javascript">
			google.load( 'search', '1' );
		</script>
		<?php echo $html->script('imageupload'); ?>
<?php } ?>
</head>
<body>
<?php if($this->action == 'tweet'){ ?>
	<?php echo $content_for_layout; ?>
<?php } else { ?>
	<div id="wrapper">
		<?php echo $content_for_layout; ?>
	<!-- #wraper --></div>
<?php } ?>
</body>

</html>

