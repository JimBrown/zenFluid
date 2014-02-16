<?php
	// force UTF-8 Ø
?>
<div id="sidebar">
	<div id="menu">
		<div id="headertitle">
			<a href="<?php echo getGalleryIndexURL(); ?>"><?php printGalleryTitle();?></a>
		</div>
		<div id="subtitle">
			<?php printFormattedGalleryDesc(getGalleryDesc());?>
		</div>
	</div>
	<?php if (getOption('zenfluid_menuupper')) {?>
		<div style="text-transform: uppercase;">
	<?php }
	if (getOption('Allow_search')) { ?>
		<div id="menu">
			<?php printSearchForm(NULL, "search", NULL, gettext("Search gallery")); ?>
		</div>
	<?php } ?>
	<div id="menu">
		<?php if (extensionEnabled('print_album_menu')) {
			printAlbumMenu("list",NULL,"","menu-active","submenu","menu-active","<p>Home</p>");
		} else {
			echo("The ZenFluid theme requires that the print_album_menu plugin be enabled.");
		} ?>
	</div>
	<?php if (extensionEnabled('zenpage')) {
		if (getNumPages(true)) { ?>
			<div id="menu">
				<?php printPageMenu("list","","menu-active","submenu","menu-active");?>
			</div>
		<?php }
		if (getNumNews(true)) { ?>
			<div id="menu">
				<?php printAllNewsCategories(gettext("All news"), TRUE, "", "menu-active", true, "submenu", "menu-active"); ?>
			</div>
		<?php }
	} else { ?>
		<div id="menu">
			<?php echo("The ZenFluid theme requires that the zenpage plugin be enabled.");?>
		</div>
	<?php }
	if (function_exists('printContactForm') || function_exists('printUserLogin_out')) { ?>
		<div id="menu">
			<ul>
				<?php if (function_exists('printContactForm')) {
					if (!commentFormUseCaptcha()) setOption("contactform_captcha",0,false); ?>
					<li>
						<?php printCustomPageURL('Contact us', 'contact', '', ''); ?>
					</li>
				<?php }
				if(function_exists('printUserLogin_out')) {?>
					<li>
						<?php printUserLogin_out();?>
					</li>
					<?php if (!zp_loggedin()) {?>
						<li>
							<?php printCustomPageURL('Register', 'register', '', '');?>
						</li>
					<?php }
				} ?>
			</ul>
		</div>
	<?php }
	if (getOption('zenfluid_menuupper')) {?>
		</div>
	<?php }
	if (!zp_loggedin(ADMIN_RIGHTS) && function_exists('printGoogleAdSense')) { ?>
		<div id="menu" style="text-align: center">
			<?php printGoogleAdSense() ?>
		</div>
	<?php } ?>
</div>