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
		<!--<?php //echo public_image_navigation($current_exam_subject, $current_image); ?>
		<br />-->
		<?php echo public_histogram_navigation($current_histogram_subject); ?>
  </div>

  <div id="page">
		<h1>Klips-Plugin Beta</h1>
<p>Findest du es cooler die Evaluationen direkt in Klips einzusehen? Dann sei ein Beta-Tester für mein experimentelles Plugin!</p>
<p>Desweiteren, hättest du Lust einen kleinen Beitrag zu leisten und mit dem Notenspiegel-Sammeln zu helfen? Das geht mit dem Plugin ganz schnell und einfach!</p>

<p>Bei Interesse, schreib einfach an <a href="mailto:wpbgutachter@gmail.com?Subject=Plugin" target="_top">wpbgutachter(at)gmail.com</a></p>
<br />
<p>Evaluationen einsehen:</p>
<img src="images/klips_plugin1.PNG" style="width:650;height:500;">
<img src="images/klips_plugin2.PNG" style="width:650px;height:500px;">
<img src="images/klips_plugin3.PNG" style="width:650px;height:500px;">
<img src="images/klips_plugin4.PNG" style="width:650px;height:500px;">
<br /><br />
<p>Notenspiegel zuschicken:</p>
<img src="images/klips_plugin5.PNG" style="width:650px;height:500px;">

  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>