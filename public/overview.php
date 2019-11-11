<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php include_once("../includes/analyticstracking.php") ?>
<script src="javascripts/sorttable.js"></script>

<?php $layout_context = "public"; ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_comment(true); ?>
<div id="main" class="clearfix">
  <div id="navigation">
		<?php echo public_navigation($current_subject, $current_course); ?>
		<br />
		<!--<?php // echo public_image_navigation($current_exam_subject, $current_image); ?>
		<br />-->
		<?php echo public_histogram_navigation($current_histogram_subject); ?>
  </div>

  <div id="page">
<h1>Übersicht Wahlpflichtblöcke</h1>
<p><input type="text" id="searchTableInput" onkeyup="searchTable()" placeholder="Kurssuche"></p>
<p>
		<table class="sortable">
			<thead>
			<tr>
				<th>Kursname</th>
				<th class="sorttable_grade">Gesamtnote</th>
				<th>Stimmen</th>
				<th>Kommentare</th>
				<th>Semesterbegleitend</th>
				<th>Schlüsselqualifikationskurs</th>
			</tr>
			</thead>
			<tbody>
				<?php populate_table();	?>
			</tbody>
		</table>
</p>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>