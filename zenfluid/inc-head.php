<?php
	// force UTF-8 Ø
?>
<?php zp_apply_filter('theme_head'); ?>
<title><?php echo getBareGalleryTitle(); ?></title>
<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style/<?php echo getoption('zenfluid_theme'); ?>.css" type="text/css" />
<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
	<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
<?php } ?>
