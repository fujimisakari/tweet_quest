<div id="contents">
	<form method="post" action="" id="form1">
		<table id="fight">
			<tr>
				<td>
					<div align="center">
						<table class="inner recdata">
							 <tr>
								<td colspan="2"><p class="center pt10"><?php echo $receiver['name']; ?></p></td>
							</tr>
							<tr>
								<th><p>たいりょく</p></th>
								<td><p>:&nbsp;&nbsp; <span id="rhp"><?php echo $receiver['hitpoint']; ?></span></p></td>
							</tr>
							<tr>
								<th><p>こうげき</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $receiver['attack']; ?></p></td>
							</tr>
							<tr>
								<th><p>ぼうぎょ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $receiver['defense']; ?></p></td>
							</tr>
							<tr>
								<th><p>すばやさ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $receiver['speed']; ?></p></td>
							</tr>
							<tr>
								<th><p>うん</p></th>
								<td><p class="pb10">:&nbsp;&nbsp; <?php echo $receiver['lucky']; ?></p></td>
							</tr>
						</table>
					</div>
					<div id="rec_result" style="display:none;"><p class="center mb20"></p></div>
					<div id="rec_img_block" style=""><img id="rec_img" name="rec_img" border="0" src="<?php echo $html->url($receiver['image_url']); ?>" alt="イメージ がありません" /></div>
					<div id="rec_gray_img_block" style="display:none;"><img src="<?php echo $html->url($rec_gray_img); ?>" alt="イメージ がありません" /></div>
				</td>
				<td id="vs">
					<ul>
						<li class="mb30">vs</li>
						<li class="after_msg mb10" style="display:none;"><a class="fancyview" href="<?php echo $html->url("/members/tweet?ac="); ?><?php echo "{$sender_name}"; ?>">→ さいせんをもうしこむ</a></li>
						<li class="after_msg mb10" style="display:none;"><a class="fancyview_result" href="<?php echo $html->url("/members/tweet/regist?ti="); ?><?php echo "{$tweet_id}&hi="; ?><?php echo "{$history_id}"; ?>">→ けっかをツイート</a></li>
						<li class="after_msg" style="display:none;"><a href="<?php echo $html->url("/members/"); ?>">→ もどる</a></li>
					</ul>
				</td>
				<td>
					<div align="center">
						<table class="inner sendata">
							<tr>
								<td colspan="2"><p class="center pt10"><?php echo $sender['name']; ?></p></td>
							</tr>
							<tr>
								<th><p>たいりょく</p></th>
								<td><p>:&nbsp;&nbsp; <span id="shp"><?php echo $sender['hitpoint']; ?></span></p></td>
							</tr>
							<tr>
								<th><p>こうげき</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $sender['attack']; ?></p></td>
							</tr>
							<tr>
								<th><p>ぼうぎょ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $sender['defense']; ?></p></td>
							</tr>
							<tr>
								<th><p>すばやさ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $sender['speed']; ?></p></td>
							</tr>
							<tr>
								<th><p>うん</p></th>
								<td><p class="pb10">:&nbsp;&nbsp; <?php echo $sender['lucky']; ?></p></td>
							</tr>
						</table>
					</div>
					<div id="sen_result" style="display:none;"><p class="center mb20"></p></div>
					<div id="sen_img_block" style=""><img id="sen_img" name="sen_img" src="<?php echo $html->url($sender['image_url']); ?>" alt="イメージ がありません" /></div>
					<div id="sen_gray_img_block" style="display:none;"><img src="<?php echo $html->url($sen_gray_img); ?>" alt="イメージ がありません" /></div>
				</td>
			</tr>
		</table>
	</form>
	<div id="msgArea"><p id="result_log"></p></div>
	<input type="hidden" id="log" value="<?php echo $log; ?>" />
<!-- #contents --></div>
