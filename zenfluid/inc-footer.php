<?php
	// force UTF-8 Ø
?>
<?php if (getOption('zenfluid_showfooter')) { ?>
	<div class="footer border colour">
<?php } else { ?>
	<div class="sidebarfooter border colour">
<?php } ?>
		<?php echo gettext('ZenFluid theme designed by '); ?> Jim Brown&nbsp;|&nbsp;
		<?php printZenphotoLink(); echo "\n"; ?>
	</div>
<?php zp_apply_filter('theme_body_close'); ?>
