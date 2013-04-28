<div id="contents">

	<?php echo $this->element('side_navi'); ?>

	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>
		<fieldset id="characterBlock">
			<legend class="ml10 pl10 pr10">キャラクターリスト</legend>
			<div class="mt20"></div>
			<p class="right mt15 mr20"><a href="<?php echo $html->url("/members/character/add"); ?>">→ あらたにとうろくする</a></p>
			<?php if(count($dataArr) != 0){ ?>
			<p class="ml15 mt15"><?php echo $paginator->counter(array('format'=>'&lt; %count% けんちゅう %start%～%end% けんひょうじ &gt;')); ?></p>
			<table id="outer">
				<?php foreach($dataArr as $row){ ?>
					<tr><td colspan="2"><div class="mt25"></div><hr width="114%" /></td></tr>
					<tr>
						<td colspan="2">
							<div class="mt10"></div>
							<p class="center"><a href="<?php echo $html->url("/members/character/edit/"); ?><?php echo $row['Character']['id'] ?>/"><?php echo $row['Character']['name'] ?></a></p>
						</td>
					</tr>
					<tr>
						<td class="size300 center">
							<div class="mt15"></div>
							<a href="<?php echo $html->url("/members/character/edit/"); ?><?php echo $row['Character']['id'] ?>/"><img src="<?php echo $html->url($row['Character']['image_url']); ?>" alt="イメージ がありません" /></a>
						</td>
						<td rowspan="2">
							<table class="inner ml30 mt10">
								<?php if($row['Character']['main_flag'] == 1){ ?>
								<tr>
									<td colspan="2"><p class="center">☆ たいせんキャラ ☆</p></td>
								</tr>
								<?php } ?>
								<tr>
									<th>たいりょく</th>
									<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['Character']['hitpoint'] ?></td>
								</tr>
								<tr>
									<th>こうげき</th>
									<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['Character']['attack'] ?></td>
								</tr>
								<tr>
									<th>ぼうぎょ</th>
									<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['Character']['defense'] ?></td>
								</tr>
								<tr>
									<th>すばやさ</th>
									<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['Character']['speed'] ?></td>
								</tr>
								<tr>
									<th>うん</th>
									<td>:&nbsp;&nbsp;&nbsp;<?php echo $row['Character']['lucky'] ?></td>
								</tr>
								<tr>
									<td colspan="2"><p class="left mt20">&lt; ひっさつわざ &gt;</p></td>
								</tr>
								<tr>
									<td colspan="2"><p class="center"><?php echo $row['Character']['critical_hit'] ?></p></td>
								</tr>
							</table>
						 </td>
					</tr>
				<?php } ?>
					<tr><td colspan="2"><div class="mt25"></div><hr width="114%" /></td></tr>
			</table>
			<?php } else { ?>
				<p class="mt20">とうろくしている キャラクター は いません</p>
			<?php } ?>
			<p class="center">
				<?php echo $paginator->numbers(array('separator' => ' ',
													'before' => $paginator->prev('まえ') . " << ",
													'after' => " >> " . $paginator->next('つぎ'),));?>
			</p>
		<!-- #characterBlock --></fieldset>

	<!-- #contentsMain --></div>
<!-- #contents --></div>