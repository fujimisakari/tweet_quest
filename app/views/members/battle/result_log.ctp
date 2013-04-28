<div id="contents">
	<form method="post" action="" id="form1">
		<table id="fight">
			<tr>
				<td>
					<div align="center">
						<table class="inner recdata">
							 <tr>
								<td colspan="2"><p class="center pt10"><?php echo $resultData['rec_name']; ?></p></td>
							</tr>
							<tr>
								<th><p>たいりょく</p></th>
								<td><p>:&nbsp;&nbsp; <span id="rhp"><?php echo $resultData['rec_hitpoint']; ?></span></p></td>
							</tr>
							<tr>
								<th><p>こうげき</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $resultData['rec_attack']; ?></p></td>
							</tr>
							<tr>
								<th><p>ぼうぎょ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $resultData['rec_defense']; ?></p></td>
							</tr>
							<tr>
								<th><p>すばやさ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $resultData['rec_speed']; ?></p></td>
							</tr>
							<tr>
								<th><p>うん</p></th>
								<td><p class="pb10">:&nbsp;&nbsp; <?php echo $resultData['rec_lucky']; ?></p></td>
							</tr>
						</table>
					</div>
					<div id="rec_result" style="display:none;"><p class="center mb20"></p></div>
					<div id="rec_img_block" style=""><img id="rec_img" name="rec_img" src="<?php echo $html->url($resultData['rec_image_url']); ?>" alt="イメージ がありません" /></div>
					<div id="rec_gray_img_block" style="display:none;"><img src="<?php echo $html->url($rec_gray_img); ?>" alt="イメージ がありません" /></div>
				</td>
				<td id="vs">
					<ul>
						<li class="mb30">vs</li>
						<?php if(isset($archive_flag)){ ?>
							<li class="after_msg" style="display:none;"><a href="<?php echo $html->url($back_url); ?>">→ もどる</a></li>
						<?php } else { ?>
							<li class="after_msg mb10" style="display:none;"><a class="fancyview" href="<?php echo $html->url("/members/tweet?ac="); ?><?php echo "{$sender_name}"; ?>">→ さいせんをもうしこむ</a></li>
							<li class="after_msg mb10" style="display:none;"><a class="fancyview_result" href="<?php echo $html->url("/members/tweet/regist?ti="); ?><?php echo "{$tweet_id}&hi="; ?><?php echo "{$history_id}"; ?>">→ けっかをツイート</a></li>
							<li class="after_msg" style="display:none;"><a href="<?php echo $html->url("/members/"); ?>">→ もどる</a></li>
						<?php } ?>
					</ul>
				</td>
				<td>
					<div align="center">
						<table class="inner sendata">
							<tr>
								<td colspan="2"><p class="center pt10"><?php echo $resultData['sen_name']; ?></p></td>
							</tr>
							<tr>
								<th><p>たいりょく</p></th>
								<td><p>:&nbsp;&nbsp; <span id="shp"><?php echo $resultData['sen_hitpoint']; ?></span></p></td>
							</tr>
							<tr>
								<th><p>こうげき</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $resultData['sen_attack']; ?></p></td>
							</tr>
							<tr>
								<th><p>ぼうぎょ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $resultData['sen_defense']; ?></p></td>
							</tr>
							<tr>
								<th><p>すばやさ</p></th>
								<td><p>:&nbsp;&nbsp; <?php echo $resultData['sen_speed']; ?></p></td>
							</tr>
							<tr>
								<th><p>うん</p></th>
								<td><p class="pb10">:&nbsp;&nbsp; <?php echo $resultData['sen_lucky']; ?></p></td>
							</tr>
						</table>
					</div>
					<div id="sen_result" style="display:none;"><p class="center mb20"></p></div>
					<div id="sen_img_block" style=""><img id="sen_img" name="sen_img" src="<?php echo $html->url($resultData['sen_image_url']); ?>" alt="イメージ がありません" /></div>
					<div id="sen_gray_img_block" style="display:none;"><img src="<?php echo $html->url($sen_gray_img); ?>" alt="イメージ がありません" /></div>
				</td>
			</tr>
		</table>
	</form>
	<div id="msgArea"><p id="result_log"></p></div>
	<input type="hidden" id="log" value="<?php echo $resultData['log']; ?>" />
<!-- #contents --></div>
