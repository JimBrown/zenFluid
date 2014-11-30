<?php
	// force UTF-8 Ø
?>
<div id="sidebar">
	<?php if (!getOption('zenfluid_showheader')) { ?>
		<div id="menu">
			<div id="sidebartitle">
				<a href="<?php echo getGalleryIndexURL(); ?>"><?php printGalleryTitle();?></a>
			</div>
			<div id="sidebarsubtitle">
				<?php printFormattedGalleryDesc(getGalleryDesc());?>
			</div>
		</div>
	<?php }
	if (getOption('zenfluid_menuupper')) {?>
		<div style="text-transform: uppercase;">
	<?php }
	if (getOption('Allow_search')) { ?>
		<div id="menu">
			<?php printSearchForm(NULL, "search", NULL, gettext("Search gallery")); ?>
		</div>
	<?php } ?>
	<div id="menu">
		<?php if (getOption('zenfluid_menutitles')) echo '<div id="menutitle">' . gettext('Gallery') . '</div>'; ?>
		<?php if (extensionEnabled('print_album_menu')) {
			printAlbumMenu("list",NULL,"","menu-active","submenu","menu-active",gettext("Home<br />&nbsp;"));
		} else {
			echo gettext("The ZenFluid theme requires that the print_album_menu plugin be enabled.");
		} ?>
	</div>
	<?php if (extensionEnabled('zenpage')) {
		if (getNumPages(true)) { ?>
			<div id="menu">
				<?php if (getOption('zenfluid_menutitles')) echo '<div id="menutitle">' . gettext('Pages') . '</div>'; ?>
				<?php printPageMenu("list","","menu-active","submenu","menu-active");?>
			</div>
		<?php }
		if (getNumNews(true)) { ?>
			<div id="menu">
				<?php if (getOption('zenfluid_menutitles')) echo '<div id="menutitle">' . gettext('News') . '</div>'; ?>
				<?php printAllNewsCategories(gettext("All news"), TRUE, "", "menu-active", true, "submenu", "menu-active"); ?>
			</div>
		<?php }
	} else { ?>
		<div id="menu">
			<?php echo gettext("The ZenFluid theme requires that the zenpage plugin be enabled.");?>
		</div>
	<?php }
	if (function_exists('printContactForm') || function_exists('printUserLogin_out')) { ?>
		<div id="menu">
			<ul>
				<?php if (function_exists('printContactForm')) {
					if (!commentFormUseCaptcha()) setOption("contactform_captcha",0,false); ?>
					<li>
						<?php printCustomPageURL(gettext('Contact us'), 'contact', '', ''); ?>
					</li>
				<?php }
				if(function_exists('printUserLogin_out')) {
					if ($_zp_gallery_page != 'register.php') { ?>
						<li>
							<?php printUserLogin_out();?>
						</li>
					<?php }
					if (!zp_loggedin()) {?>
						<li>
							<?php printCustomPageURL(gettext('Register'), 'register', '', '');?>
						</li>
					<?php } else { ?>
						<li>
							<?php printLinkHTML(WEBPATH . '/' . ZENFOLDER . '/admin-users.php?page=users', gettext('Profile'), gettext('Your user profile'));?>
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
