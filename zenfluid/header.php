<?php
	// force UTF-8 Ø
?>

		<?php zp_apply_filter('theme_body_open');
		if (getOption('zenfluid_showheader')) { ?>
			<div id="header">
				<div id="headertitle">
					<a href="<?php echo getGalleryIndexURL(); ?>"><?php printGalleryTitle();?></a>
					<div id="headersubtitle">
						<?php printGalleryDesc();echo "\n";?>
					</div>
				</div>
			</div>
		<?php }
?>
