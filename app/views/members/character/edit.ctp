<div id="contents">

	<?php echo $this->element('side_navi'); ?>

	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>
		<fieldset id="characterBlock">
			<legend class="ml10 pl10 pr10">キャラクターへんしゅう</legend>
			<div class="mt15"></div>
			<form method="post" action="" id="form1">
			<table id="outer">
			<tr><td colspan="2"><p class="mt5">■ 150 からパラメーターをふりわけてください</p></td></tr>
				<tr>
					<td class="size300 center">
						<div class="mt35"></div>
						<div id="IMG_VIEW">
							<img border="0" src="<?php echo $html->url($dataArr['Character']['image_url']); ?>" alt="イメージ が ありませんでした"/>
						</div>
						<?php echo $form->hidden('Character.image_url', array('value' => $dataArr['Character']['image_url'])); ?>
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
								<td>:&nbsp;&nbsp<?php echo $form->text('Character.name', array('value' => $dataArr['Character']['name'],
																							 'size' => "10")); ?></td>
							</tr>
							<tr>
								<th>たいりょく</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.hitpoint', array('value' => $dataArr['Character']['hitpoint'],
																								  'onChange' => "jsTotalParam('CharacterHitpoint')",
																								  'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>こうげき</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.attack', array('value' => $dataArr['Character']['attack'],
																								'onChange' => "jsTotalParam('CharacterAttack')",
																								'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>ぼうぎょ</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.defense', array('value' => $dataArr['Character']['defense'],
																								 'onChange' => "jsTotalParam('CharacterDefense')",
																								 'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>すばやさ</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.speed', array('value' => $dataArr['Character']['speed'],
																							   'onChange' => "jsTotalParam('CharacterSpeed')",
																							   'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>うん</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.lucky', array('value' => $dataArr['Character']['lucky'],
																							   'onChange' => "jsTotalParam('CharacterLucky')",
																							   'size' => "3")); ?></td>
							</tr>
							<tr>
								<th>ひっさつ<br />わざ</th>
								<td>:&nbsp;&nbsp;<?php echo $form->text('Character.critical_hit', array('value' => $dataArr['Character']['critical_hit'],
																									  'size' => "10")); ?></td>
							</tr>
							<tr>
								<td colspan="2">
									<div id="main_flag" >
									<?php echo $form->input('Character.main_flag', array('type' => 'checkbox',
																					   'div' => false,
																					   'label' => 'たいせんキャラにする',
																					   'checked' => $dataArr['Character']['main_flag'])); ?>
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
					<td colspan="2" class="center">
						<div class="mt20"></div>
						<a href="javascript:void(0)" onclick="return jsPost(<?php echo "'{$html->url('character/process/')}', 'noid', 'null'" ?>)">→ へんしゅうする</a>
						<span class="ml20"></span>
						<a href="javascript:void(0)" onclick="return jsPost(<?php echo "'{$html->url('character/delete/')}', 'del', 'null'" ?>)">→ さくじょする</a>
					</td>
				</tr>
			</table>
			<?php echo $form->hidden('Character.id', array('value' => $dataArr['Character']['id'])); ?>
			</form>
			<div class="mb20"></div>
			<hr />
			</form>
			<div id="imgList" class="mt25"></div>
		<!-- #characterBlock --></fieldset>

	<!-- #contentsMain --></div>
<!-- #contents --></div>