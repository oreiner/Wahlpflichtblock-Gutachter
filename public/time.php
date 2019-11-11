<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include_once("../includes/analyticstracking.php") ?>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_comment(true); ?>
<div id="main" class="clearfix">
  <div id="navigation">
		<?php echo public_navigation($current_subject, $current_course); ?>
		<br />
		<?php echo public_image_navigation($current_exam_subject, $current_image); ?>
		<br />
		<?php echo public_histogram_navigation($current_histogram_subject); ?>
  </div>

  <div id="page"><?php
		echo "date: ".date("D M j G:i:s T Y")."  \n";
echo "time: ".time();?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>