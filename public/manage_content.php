<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include_once("../includes/analyticstracking.php") ?>
<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_comment(); ?>
<?php confirm_editor_logged_in() ?>

<?php
//Handler for the "Meldungen" Table 
if (isset($_POST['submit'])) {
  // Process the form
  $id = (int) $_POST["id"];
  $processed = (int) $_POST["processed"];

  // validations
  $required_fields = array("id", "processed");
  validate_presences($required_fields);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE reports SET ";
    $query .= "processed = '{$processed}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

  }
} 
?>

<div id="main" class="clearfix">
  <div id="navigation">
		<br />
		<a href="admin.php">&laquo; Main menu</a><br />
		<a href="manage_content.php"><h3> Meldungen</h3></a>
		<?php echo navigation($current_subject, $current_course, $current_comment); ?>
		<br />
		<a href="new_course.php">+ Add a course</a>
		<br />
		<?php echo image_navigation($current_exam_subject, $current_image); ?>
  </div>
  <div id="page">
		<?php echo message(); ?>
		<?php if ($current_course) { ?>
	    <h2>Manage course</h2>
			Kursname: <?php echo htmlentities($current_course["course_name"]); ?><br />
			<!-- Position: <//?php echo $current_course["position"]; ?><br /> -->
			Einsehbar: <?php echo $current_course["visible"] == 1 ? 'Ja' : 'Nein'; ?><br />
			<br />
			<a href="edit_course.php?course=<?php echo urlencode($current_course["id"]); ?>">Edit course</a>
			
			<div style="margin-top: 2em; border-top: 1px solid #000000;">
				<h3>comments in this course:</h3>
				<ul>
				<?php 
					$course_comments = find_comments_for_course($current_course["id"]);
					while($comment = mysqli_fetch_assoc($course_comments)) {
						echo "<li>";
						$safe_comment_id = urlencode($comment["id"]);
						echo "<a href=\"manage_content.php?comment={$safe_comment_id}\">";
						echo htmlentities($comment["user_name"]);
						echo "</a>";
						echo "</li>";
					}
				?>
				</ul>
				<br />
				+ <a href="new_comment.php?course=<?php echo urlencode($current_course["id"]); ?>">Add a new comment to this course</a>
			</div>

		<?php } elseif ($current_comment) { ?>
			<h2>Manage comment</h2>
			User name: <?php echo htmlentities($current_comment["user_name"]); ?><br />
			Date: <?php echo htmlentities($current_comment["comment_date"]); ?><br />
			Position: <?php echo $current_course["position"]; ?><br />
			Visible: <?php echo $current_comment["visible"] == 1 ? 'yes' : 'no'; ?><br />
			Content:<br />
			<div class="view-content">
				<?php echo htmlentities($current_comment["content"]); ?>
			</div>
			<br />
      <br />
      <a href="edit_comment.php?comment=<?php echo urlencode($current_comment['id']); ?>">Edit comment</a>
			
		<?php } elseif ($current_exam_subject){ ?>	
			<h2>Manage image</h2>
			<h3>Fach: <?php echo htmlentities(str_replace("_"," ",$current_exam_subject)); ?></h3><br />
			<?php 
				$image_set = format_images_for_subject("{$current_exam_subject}");
				foreach($image_set as $image){
			?>
			Image: <?php echo $image; ?><br />
			<a href="edit_image.php?image=<?php echo urlencode($current_image['id']); ?>">Edit Image</a><br />
					<img src="images/<?php echo $current_exam_subject . "/" . $image; ?>" class="grade">
		<br />
	 
		<?php 
				}
			} else { ?>
			<br />Please select a course.<br /><br /><br />
			<h3>Meldungen:</h3>
			<table class="reports_table">
				<thead>
					<th class="thin">Fach</th>
					<th class="thin">WPB</th>
<th class="thick">Inhalt</th>
<th class="thin">Notenvergabe</th>
					<th class="thin">Benutzername</th>
<th class="thin">Quelle</th>
					<th class="thin">Datum</th>
					<th class="thin">Behandelt?</th>
				</thead>
				<tbody>
					<tr>
						<?php 	
							$report_set = find_reports();
							while($report = mysqli_fetch_assoc($report_set)) {
								$course = find_course_by_id($report["course_id"]);
							?><tr>
								<td><?php echo $course["Fach"];?></td>
								<td><?php echo $course["course_name"];?></td>
<td><?php echo $report["content"];?></td>
<td><?php echo $report["notes"];?></td>
								<td><?php echo $report["user_name"];?></td>
<td><?php echo $report["source"];?></td>
								<td><?php echo $report["report_date"];?></td>
								<td><form action="manage_content.php" method="POST">
									<input type="hidden" name="id" value="<?php echo $report["id"] ?>" />
									<input type="radio" name="processed" value="0" <?php if ($report["processed"] == 0) { echo "checked"; }; ?>/> No 
									<input type="radio" name="processed" value="1" <?php if ($report["processed"] == 1) { echo "checked"; };?>/> Yes
									<input type="submit" name="submit" value="aktualisiere"/>
								</form></td>
							</tr>
							<?php
							}
						?>	
						
							
						
					</tr>
				</tbody>
			</table>
		<?php }?>
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>