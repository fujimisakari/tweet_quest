<div id="contents">
	<?php echo $this->element('side_navi'); ?>
	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>
		<fieldset id="characterBlock">
		<div class="mt20"></div>
		<?php echo $error_msg."<br />"; ?>
		<?php echo $form->error('TweetBox.receiver', array('class' => 'mt10 mb10 ml10')); ?>
		<?php echo $form->error('TweetBox.msg', array('class' => 'mt10 mb10 ml10')); ?>
		<?php
			if(isset($character_error)){
				echo "<p class=\"mt10 ml10\">".$character_error."</p>";
			}
		?>
		<?php
			if(isset($my_name_error)){
				echo "<p class=\"mt10 ml10\">".$my_name_error."</p>";
			}
		?>
		<!-- #characterBlock --></fieldset>
	<!-- #contentsMain --></div>
<!-- #contents --></div>
