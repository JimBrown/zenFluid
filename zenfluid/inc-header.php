<?php
	// force UTF-8 Ø
zp_apply_filter('theme_body_open');
$stageWidth = getOption('zenfluid_stagewidth');
$stagePosition = getOption('zenfluid_stageposition');
switch ($stagePosition) {
	case 'left' :
		$stageStyle = ($stageWidth > 0) ? 'style="max-width:' . $stageWidth . 'px;"' : '';
		$imageStyle = 'style="text-align: left;"';
		break;
	case 'center' :
		$stageStyle = ($stageWidth > 0) ? 'style="max-width:' . $stageWidth . 'px; margin-left: auto; margin-right: auto;"' : 'style="margin-left: auto; margin-right: auto;"';
		$imageStyle = 'style="text-align: center;"';
		break;
	case 'right' :
		$stageStyle = ($stageWidth > 0) ? 'style="max-width:' . $stageWidth . 'px; margin-left: auto;"' : 'style="margin-left: auto;"';
		$imageStyle = 'style="text-align: right;"';
		break;
}
if (getOption('zenfluid_showheader')) { ?>
	<div class="header border colour">
		<div class="headertitle">
			<a href="<?php echo getGalleryIndexURL(); ?>"><?php printGalleryTitle();?></a>
			<div class="headersubtitle">
				<?php printGalleryDesc();echo "\n";?>
			</div>
		</div>
	</div>
<?php }
?>
