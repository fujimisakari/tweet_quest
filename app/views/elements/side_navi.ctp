<div id="contentsNavi">
	<fieldset id="profileBlock">
		<legend class="ml30 pl10 pr10">ユーザー</legend>
		<div class="mt15"></div>
		<ul>
			<li><img src="<?php echo $html->url($userArr['original_image_url']); ?>" alt="thumbnail" /></li>
			<li class="ml5 mt15"><p class="center"><?php echo $userArr['name'] ?></p></li>
		</ul>
		<p>ユーザーせんれき :</p></br>
		<p>
			<span class="ml20"><?php echo $battle_count ?>&nbsp;せん</span>
			<span class="ml10"><?php echo $win_count ?>&nbsp;しょう</span>
			<span class="ml10"><?php echo $loose_count ?>&nbsp;はい</span>
		</p>
	<!-- #profileBlock --></fieldset>

	<div class="mt10"></div>

	<fieldset id="sideHistoryBlock">
		<legend class="ml10 pl10 pr10">キャラクターせんれき</legend>
		<div class="mt15"></div>
		<?php if(count($historyData) != 0){ ?>
		<table>
			<?php foreach($historyData as $row){ ?>
			<tr><td colspan="2"><hr /></td></tr>
			<tr>
				<td colspan="2"><p class="center mt5"><?php echo $row['name']; ?></p></td>
			</tr>
			<tr>
				<th>たたかい</th>
				<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['battle']; ?>&nbsp;せん</td>
			</tr>
			<tr>
				<th>かち</th>
				<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['win']; ?>&nbsp;しょう</td>
			</tr>
			<tr>
				<th>まけ</th>
				<td>
					:&nbsp;&nbsp;&nbsp;<?php echo $row['lose'] ?>&nbsp;はい
					<div class="mt15"></div>
				</td>
			</tr>
			<?php } ?>
			<tr><td colspan="2"><hr /></td></tr>
		</table>
		<?php } else { ?>
		<p class="center mt5">キャラクターが<br />とうろくされてません</p>
		<?php } ?>
		
	<!-- #sideHistoryBlock --></fieldset>

<!-- #contentsNavi --></div>
