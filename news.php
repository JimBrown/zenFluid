<?php
	// force UTF-8 Ø
	if (!defined('WEBPATH') || !class_exists('Zenpage')) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<?php printHeadTitle();?>
		<meta http-equiv="content-type" content="text/html; charset=<?php echo LOCAL_CHARSET; ?>" />
		<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/style.css" type="text/css" />
		<?php if (file_exists(__DIR__ . "/fonts/stylesheet.css")){?>
			<link rel="stylesheet" href="<?php echo $_zp_themeroot; ?>/fonts/stylesheet.css" type="text/css" />
		<?php } ?>
		<?php zp_apply_filter('theme_head'); ?>
	</head>

	<body>
		<?php zp_apply_filter('theme_body_open');?>

		<div id="container">
			<div id="contents">
				<div id="content">
					<?php if (is_NewsArticle()) { // single news article ?>
						<div id="newsnav">
							<?php if (getPrevNewsURL()) { ?>
								<div id="newsprevious">Previous:&nbsp
								<?php printPrevNewsLink(''); ?>
								</div>
							<?php }
							if (getNextNewsURL()) { ?>
								<div id="newsnext">Next:&nbsp
									<?php printNextNewsLink(''); ?>
								</div>
							<?php } ?>
							<div class="clearing" ></div>
						</div>
						<div id="newstitle">
							<?php printNewsTitle(); ?>
							<div id="newsdate">
								<?php printNewsDate(); ?>
							</div>
						</div>
						<div id="newscontent">
							<?php printNewsContent();?>
							<div id="buttons">
								<?php if (function_exists('getHitcounter')) { ?>
									<div id="hitcounter">
										<?php echo "Views: " . getHitcounter();?>
									</div>
								<?php }
								if (function_exists('printLikeButton')) {
									printLikeButton();
								}
								if(getTags()) {?>
									<div id="tags">
										<?php printTags('links', 'Tags: ', 'taglist', ', ');?>
									</div>
								<?php }
								if(getNewsCategories()) { ?>
								<div id="tags">
									<?php printNewsCategories(", ", gettext("Categories: "), "newscategories"); ?>
								</div>
								<?php } ?>
							</div>
							<div class="clearing" ></div>
							<?php if (function_exists('printCommentForm') && ($_zp_current_zenpage_news->getCommentsAllowed() || getCommentCount())) {
								printCommentForm();
							}?>
						</div>
					<?php } else {
						printNewsPageListWithNav(gettext('next »'), gettext('« prev'));
						while (next_news()):;  // news article loop ?>
							<div id="newstitle">
								<div id="newslink">
									<?php printNewsURL();?>
								</div>
								<div id="newsdate">
									<?php printNewsDate(); ?>
								</div>
							</div>
							<div id="newscontent">
								<?php printNewsContent();?>
								<div id="slidebuttons">
									<?php if (function_exists('getHitcounter')) { ?>
										<div id="hitcounter">
											<?php echo "Views: " . getHitcounter();?>
										</div>
									<?php }
									if (function_exists('printLikeButton')) {
										printLikeButton();
									}
									if(getTags()) {?>
										<div id="tags">
											<?php printTags('links', 'Tags: ', 'taglist', ', ');?>
										</div>
									<?php }
									if(getNewsCategories()) { ?>
									<div id="tags">
										<?php printNewsCategories(", ", gettext("Categories: "), "newscategories"); ?>
									</div>
									<?php } ?>
								</div>
								<div class="clearing" ></div>
							</div>
						<?php endwhile;
						printNewsPageListWithNav(gettext('next »'), gettext('« prev'), true, 'pagelist', true); ?>
					<?php }	?>
				</div>
			</div>
			<?php include("sidebar.php");?>
		</div>
		<?php include("footer.php");?>
	</body>
</html>