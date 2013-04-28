<div id="contents">

	<?php echo $this->element('side_navi'); ?>

	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>

		<fieldset id="historyBlock">
			<legend class="ml10 pl10 pr10">せんれき</legend>
			<div class="mt20"></div>

			<?php if(count($dataArr) != 0){ ?>
			<p class="ml15 mt30"><?php echo $paginator->counter(array('format'=>'&lt; %count% けんちゅう %start%～%end% けんひょうじ &gt;')); ?></p>
			<table>
				<?php foreach($dataArr as $row){ ?>
					<tr>
					<td class="size160"><p class="mt45 center"><?php echo date('Y/m/d', strtotime($row['History']['created'])); ?></p></td>
						<td>
							<table class="inner">
								<tr>
									<td><p class="mb5"><?php echo $row['History']['rec_character_name']; ?></p></td>
								</tr>
								<tr>
									<td class="center">vs</td>
								</tr>
								<tr>
									<td><p class="mt5"><?php echo $row['History']['sen_character_name']; ?></p></td>
								</tr>
								<tr>
									<td>
										<p class="right mt15 mr20 mb5">
											<a href="<?php echo $html->url("/members/battle_result/"); ?><?php echo "{$row['History']['tweet_box_id']}/"?>archive/">→ たたかいをみる</a>
											<a class="ml20 fancyview_result" href="<?php echo $html->url("/members/tweet/regist?ti="); ?><?php echo "{$row['History']['tweet_box_id']}&amp;hi="?><?php echo "{$row['History']['id']}"?>" >→ けっかをツイート</a>
										</p>
									</td>
								</tr>
							</table>
						</td>
						<td class="size40"><p class="mt45">
							<?php
								if($row['History']['win_flag'] == 1){
									echo "○";
								} else {
									echo "×";
								}
							?>
						</p></td>
					</tr>
				<?php } ?>
			</table>
			<?php } else { ?>
			<p class="mt20">せんれき は ありません</p>
			<?php } ?>
			<p class="center">
				<?php echo $paginator->numbers(array('separator' => ' ',
													'before' => $paginator->prev('まえ') . " << ",
													'after' => " >> " . $paginator->next('つぎ'),));?>
			</p>
		<!-- #historyBlock --></fieldset>

	<!-- #contentsMain --></div>
<!-- #contents --></div>