<div id="tweetBlock">
	<p>■ けっかをつぶやく</p>
	<div class="mt20"></div>
	<?php echo $form->error('TweetBox.msg', array('class' => 'mt10 mb10 ml10')); ?>
	<form method="post" action="" id="tweet">
		<table>
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
			<li><p class="right mr80"><a href="javascript:void(0)" onclick="return jsTweet(<?php echo "'{$html->url('/members/tweet/send/')}', 'noid', 'null'" ?>)">→ ツイート する</a></p></li>
		</ul>
		<?php echo $form->hidden('TweetBox.id', array('value' => $id)); ?>
		<?php echo $form->hidden('TweetBox.t_user_id', array('value' => $t_user_id)); ?>
	</form>
<!-- #tweetBlock --></div>
