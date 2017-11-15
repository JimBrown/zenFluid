<?php
  // force UTF-8 Ø
  if (!defined('WEBPATH') || !class_exists("CMS")) die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<?php if (getOption('zenfluid_makeneat')) makeNeatStart(); ?>
  <head>
    <?php include("inc-head.php");?>
  </head>

  <body>

    <?php include("inc-header.php");?>

    <?php $commentCount = function_exists('printCommentForm') ? getCommentCount() : 0;
    echo CommentsJS($commentCount);?>
    <div class="stage" <?php echo $stageStyle;?>>
      <div class="title border colour" <?php echo $titleStyle;?>>
        <?php printPageTitle();?>
      </div>
      <div class="content border colour">
        <div class=page <?php echo $commentStyle;?>>
          <div class="pagetext">
            <?php printPageContent();?>
          </div>
        </div>
      </div>
      <div class="imagebuttons" <?php echo $buttonStyle;?>>
        <?php if (function_exists('getHitcounter')) { ?>
          <div class="button border colour">
            <?php echo gettext("Views: ") . getHitcounter();?>
          </div>
        <?php }
        if (function_exists('printCommentForm') && ($_zp_current_page->getCommentsAllowed() || $commentCount)) { 
          if ($commentCount == 0) {
            $comments = gettext('No Comments');
          } else {
            $comments = sprintf(ngettext('%u Comment', '%u Comments', $commentCount), $commentCount);
          } ?>
          <div class="button border colour">
            <a href="#readComment"><?php echo $comments; ?></a>
          </div>
          <div class="button border colour">
            <a href="#addComment">Add Comment</a>
          </div>
        <?php }
        if (function_exists('printLikeButton')) { ?>
          <div class="button fb-button border colour">
            <?php printLikeButton(); ?>
          </div>
        <?php } ?>
      </div>
      <div class="clearing" ></div>
      <?php if (function_exists('printCommentForm') && ($_zp_current_page->getCommentsAllowed() || $commentCount)) { ?>
        <a id="readComment"></a>
        <div class="content border colour">
          <div class="commentbox" <?php echo $commentStyle;?>>
            <?php printCommentForm(true, '<a id="addComment"></a>', false); ?>
          </div>
        </div>
      <?php } ?>
      <?php if(getTags()) {?>
        <div class="albumbuttons" <?php echo $buttonStyle;?>>
          <div class="button border colour">
            <?php printTags('links', gettext('Tags: '), 'taglist', ', ');?>
          </div>
        </div>
        <div class="clearing" ></div>
      <?php } ?>
    </div>

    <?php include("inc-footer.php");?>
    
  </body>
<?php if (getOption('zenfluid_makeneat')) makeNeatEnd(); ?>
</html>