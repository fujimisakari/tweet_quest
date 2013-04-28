<div id="contents">

	<?php echo $this->element('side_navi'); ?>

	<div id="contentsMain">
		<?php echo $this->element('main_menu'); ?>

		<fieldset id="statusBlock">
			<legend class="ml10 pl10 pr10">たいせんユーザー</legend>
			<div class="mt20"></div>
			<?php if($usersArr){ ?>
			<table>
				<?php foreach($usersArr as $row){ ?>
					<tr>
						<td class="size50"><img src="<?php echo $row['image_url']; ?>" alt="thumbnail" /></td>
						<td><?php echo $row['name']; ?></td>
						<td class="size110">
							<ul>
								<li><a class="fancyview" href="<?php echo $html->url("/members/tweet/regist"); ?><?php echo "?ac={$row['name']}"?>">→ たたかう</a></li>
							</ul>
						</td>
					</tr>
				<?php } ?>
			</table>
			<?php } else { ?>
			<p>たいせんしたユーザー は いません。</p>
			<?php } ?>
		<!-- #statusBlock --></fieldset>

	<!-- #contentsMain --></div>
<!-- #contents --></div>