<div id="tweetBlock">
	<p>■ たたかいをもうしこむ</p>
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
	<?php
		if(isset($account_error)){
			echo "<p class=\"mt10 ml10\">".$account_error."</p>";
		}
	?>
	<form method="post" action="" id="tweet">
		<table>
			<tr><th>ツイッターアカウント:</th></tr>
			<tr>
				<td>
					<?php
						if(isset($name)){
							echo $form->text('TweetBox.receiver', array('value' => $name, 'class' => 'size250'));
						} else {
							echo $form->text('TweetBox.receiver', array('class' => 'size250'));
						}
					 ?>
				</td>
			</tr>
			<tr><th>ツイートメッセージ:</th></tr>
			<tr>
				<td>
					<?php
						if(isset($msg)){
							echo $form->textarea('TweetBox.msg' ,array('value' => $msg, 'div' => false, 'class' => 'size450'));
						} else {
							echo $form->textarea('TweetBox.msg' ,array('div' => false, 'class' => 'size450'));
						}
					 ?>
				</td>
			</tr>
		</table>
		<ul>
			<li><p class="right"><?php echo $form->input('TweetBox.public_flag', array('type' => 'checkbox',
																	  'div' => false,
																	  'class' => 'ml10',
																	  'label' => 'ツイッターに こうかい する')); ?>
			</p></li>
			<li><p class="right mr80"><a href="javascript:void(0)" onclick="return jsTweet(<?php echo "'{$html->url('/members/tweet/send/')}', 'noid', 'null'" ?>)">→ そうしん する</a></p></li>
		</ul>
	</form>
<!-- #tweetBlock --></div>
