<div id="contents">
	<form method="post" action="" id="form1" name="form1">
		<table id="fight">
			<tr>
				<td>
					<?php
						foreach($receiverArr['Character'] as $row){
							if($row['main_flag'] == 1){
					?>
					<div align="center">
						<table class="inner">
							<tr>
								<td colspan="2"><p class="center pt10"><?php echo "{$row['name']}"; ?></p></td>
							</tr>
							<tr>
								<th>たいりょく</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>こうげき</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>ぼうぎょ</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>すばやさ</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>うん</th>
								<td><p class="pb10">:&nbsp;&nbsp; </p></td>
							</tr>
						</table>
					</div>
					<img src="<?php echo $html->url($row['image_url']); ?>" alt="イメージ がありません" />
					<?php echo $form->hidden("Receiver.character_id", array('value' => $row['id'])); ?>
					<?php
							}
						}
					?>
				</td>
				<td id="vs">
					<ul>
						<li class="mb30">vs</li>
						<li class="mb10"><a href="javascript:void(0)" onclick="return jsPost(<?php echo "'{$html->url('battle/result/')}', 'noid', 'null'" ?>)">→ はじめる</a></li>
						<li><a href="<?php echo $html->url("/members/"); ?>">→ もどる&nbsp;</a></li>
					</ul>
				</td>
				<td>
					<?php
						foreach($senderArr['Character'] as $row){
							if($row['id'] == $senCharacterId){
					?>
					<div align="center">
						<table class="inner">
							<tr>
								<td colspan="2"><p class="center pt10"><?php echo "{$row['name']}"; ?></p></td>
							</tr>
							<tr>
								<th>たいりょく</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>こうげき</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>ぼうぎょ</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>すばやさ</th>
								<td><p>:&nbsp;&nbsp; </p></td>
							</tr>
							<tr>
								<th>うん</th>
								<td><p class="pb10">:&nbsp;&nbsp; </p></td>
							</tr>
						</table>
					</div>
					<img src="<?php echo $html->url($row['image_url']); ?>" alt="イメージ がありません" />
					<?php echo $form->hidden("Sender.character_id", array('value' => $row['id'])); ?>
					<?php
							}
						}
					?>
				</td>
			</tr>
		</table>
		<?php echo $form->hidden('tweetboxId', array('value' => $tweetboxId)); ?>
		<?php echo $form->hidden('Sender.user_id', array('value' => $senderArr['T_user']['id'])); ?>
		<?php echo $form->hidden('Sender.user_name', array('value' => $senderArr['T_user']['name'])); ?>
	</form>
	<div id="msgArea"></div>
<!-- #contents --></div>