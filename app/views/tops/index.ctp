<div id="contents">
	<div id="topTop">
		<img src="<?php echo $html->url('/img/top_title.jpg'); ?>" alt="TOPろご" />
	<!-- #topTop --></div>
	<div id="topBottom">
		<?php if($status == 1){ ?>
			げんざい ログインちゅう です。
			<ul>
				<li><a href="<?php echo $html->url("/members/"); ?>">→ マイページ</a></li>
				<li><a href="<?php echo $html->url("#"); ?>">→ せつめい</a></li>
			</ul>
		<?php } else { ?>
			ようこそ Tweet Quest へ
			<form method="post" action="" id="form1" name="form1">
				<ul>
					<li><a href="javascript:void(0)" onclick="return jsPost(<?php echo "'{$html->url('/members/login/')}', 'noid', 'null'" ?>)">→ ログインする</a></li>
					<li><?php echo $form->input('T_user.remember_me', array('type' => 'checkbox',
																			'div' => false,
																			'class' => 'ml10',
																			'label' => 'ログインをきおくする',
																			'checked' => "checked")); ?>
					</li>
					<li><a href="<?php echo "{$html->url('/desc/')}" ?>">→ せつめい</a></li>
				</ul>
			</form>
		<?php } ?>
	<!-- #topBottom --></div>
<!-- #contents --></div>
