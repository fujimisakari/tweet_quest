<div id="contents">

	<?php echo $this->element('side_navi'); ?>

	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>

		<fieldset id="statusBlock">
			<legend class="ml10 pl10 pr10">おしらせ</legend>
			<div class="mt20"></div>
			<p>■ たたかい を もうしこんできているユーザー</p>
				<?php if(count($recTweetArr) != 0){ ?>
					<?php foreach($recTweetArr as $row){ ?>
					<table>
						<tr>
							<td class="size50"><img src="<?php echo $row['TweetBox']['sender_image_url']; ?>" alt="thumbnail" /></td>
							<td ><?php echo $row['TweetBox']['sender']; ?><br /><br /><?php echo preg_replace("/http:\/\/p.tl\/33Ke/", "", $row['TweetBox']['msg']); ?></td>
							<td class="size110">
								<ul>
									<li><a href="<?php echo $html->url("/members/battle"); ?><?php echo "?id={$row['TweetBox']['id']}"?>">→ たたかう</a></li>
									<li><a href="<?php echo $html->url("/members/cancel/rec/"); ?><?php echo "{$row['TweetBox']['id']}/" ?>">→ きょひする</a></li>
								</ul>
							</td>
						</tr>
					</table>
					<?php } ?>
				<?php } else { ?>
					<p class="ml25 mt15">げんざい たたかい の もうしこみ は ありません。</p></td>
				<?php } ?>

			<div class="mb30"></div>

			<p>■ たたかい を もうしこんでいるユーザー</p>
			<table>
				<?php if(count($senTweetArr) != 0){ ?>
					<?php foreach($senTweetArr as $row){ ?>
					<table>
						<tr>
							<td class="size50"><img src="<?php echo $row['TweetBox']['receiver_image_url']; ?>" alt="thumbnail" /></td>
							<td><?php echo preg_replace("/http:\/\/p.tl\/33Ke/", "", $row['TweetBox']['msg']); ?></td>
							<td class="size110">
								<?php if($row['TweetBox']['result_flag'] == 1){ ?>
									<a href="<?php echo $html->url("/members/battle_result/"); ?><?php echo "{$row['TweetBox']['id']}/"?>">→ けっか</a>
								<?php } else { ?>
									<a href="<?php echo $html->url("/members/cancel/sen/"); ?><?php echo "{$row['TweetBox']['id']}/"?>">→ やめる</a>
								<?php } ?>
							</td>
						</tr>
					</talbe>
					<?php } ?>
				<?php } else { ?>
				<p class="ml25 mt15">げんざい たたかい を もうしこんでいません。</p></td>
				<?php } ?>
			</table>
		<!-- #statusBlock --></fieldset>

	<!-- #contentsMain --></div>
<!-- #contents --></div>