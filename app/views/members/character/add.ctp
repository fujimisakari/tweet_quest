<div id="contents">

	<?php echo $this->element('side_navi'); ?>

	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>
		<fieldset id="characterBlock">
			<?php if(isset($this->params['data']['Character']['id'])){ ?>
				<legend class="ml10 pl10 pr10">キャラクターへんしゅう</legend>
			<?php } else { ?>
				<legend class="ml10 pl10 pr10">キャラクターとうろく</legend>
			<?php } ?>
			<div class="mt15"></div>
			<form method="post" action="" id="form1">
			<table id="outer">
				<tr><td colspan="2">
					<p>■ 150 から パラメーター を ふりわけてください</p>
					<?php echo $form->error('Character.name', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.hitpoint', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.attack', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.defense', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.speed', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.lucky', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.image_url', array('class' => 'mt10 mb10')); ?>
					<?php echo $form->error('Character.critical_hit', array('class' => 'mt10 mb10')); ?>
					</td>
				</tr>
				<tr>
					<td class="size300 center">
						<div class="mt35"></div>
						<div id="IMG_VIEW">
							<?php if(isset($this->params['data']['Character']['image_url'])){ ?>
								<img border="0" src="<?php echo $html->url($this->params['data']['Character']['image_url']); ?>" alt="イメージ が ありませんでした"/>
							<?php } else { ?>
								<img border="0" src="" alt="イメージ"/>
							<?php } ?>
						</div>
						<?php echo $form->hidden('Character.image_url'); ?>
					</td>
					<td>
						<table class="inner">
							<tr>
								<td colspan="2">
									<div class="mt20"></div>
									<span id="totalparam" class="ml35"></span> / 150<div class="mb10"></div></td>
							</tr>
							<tr>
								<th class="size180">なまえ</th>
								<td>:&nbsp;&nbsp<?php echo $form->text('Character.name', array('size' => "10")); ?></td>
							</tr>
							<tr>
								<th>たいりょく</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.hitpoint', array('onChange' => "jsTotalParam('CharacterHitpoint')",
																								  'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>こうげき</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.attack', array('onChange' => "jsTotalParam('CharacterAttack')",
																								'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>ぼうぎょ</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.defense', array('onChange' => "jsTotalParam('CharacterDefense')",
																								 'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>すばやさ</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.speed', array('onChange' => "jsTotalParam('CharacterSpeed')",
																							   'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>うん</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.lucky', array('onChange' => "jsTotalParam('CharacterLucky')",
																							   'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>ひっさつ<br />わざ</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.critical_hit', array('size' => "10")); ?></td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="main_flag" >
									<?php echo $form->input('Character.main_flag', array('type' => 'checkbox',
																					   'div' => false,
																					   'label' => 'たいせんキャラにする',
																					   'checked' => '')); ?>
									</div>
								</td>
							</tr>
						</table>
					 </td>
				</tr>
				<tr>
					<td><span class="ml30"><?php echo $form->text('searchImage'); ?></span></td>
				</tr>
				<tr>
					<td>
						<div class="mt15"></div>
						<span class="ml35 pt10"><a onclick="OnLoad()">→ イメージをけんさく</a></span>
					</td>
				</tr>
				<tr class="bottom_line">
					<td colspan="2">
						<div class="mt15"></div>
						<?php if(isset($this->params['data']['Character']['id'])){ ?>
							<a href="javascript:void(0)" class="ml210" onclick="return jsPost(<?php echo "'{$html->url('character/process/')}', 'noid', 'null'" ?>)">→ へんしゅうする</a>
						<?php } else { ?>
							<a href="javascript:void(0)" class="ml210" onclick="return jsPost(<?php echo "'{$html->url('character/process/')}', 'noid', 'null'" ?>)">→ とうろくする</a>
						<?php } ?>
					</td>
				</tr>
			</table>
			<?php
				if(isset($this->params['data']['Character']['id'])){
					echo $form->hidden('Character.id');
				}
			?>
			<div class="mb20"></div>
			<hr />
			</form>
			<div id="imgList" class="mt25"></div>
		<!-- #characterBlock --></fieldset>

	<!-- #contentsMain --></div>
<!-- #contents --></div>
