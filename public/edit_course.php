<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_comment(); ?>
<?php
	if (!$current_course) {
		// course ID was missing or invalid or 
		// course couldn't be found in database
		redirect_to("manage_content.php");
	}
?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	// validations
	$required_fields = array("course_name","Fach","Gesamtnote","Auftreten","Didaktik","Klinische_Relevanz","Organisation", "Stimmen", "position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("course_name" => 128);
	validate_max_lengths($fields_with_max_lengths);
	
	$fields_with_decimal_numbers = array("Gesamtnote","Auftreten","Didaktik","Klinische_Relevanz","Organisation");
	validate_grade_format($fields_with_decimal_numbers); //check greater than 1.00 and smaller than 6.00
	
	if (empty($errors)) {
		
		// Perform Update

		$id = $current_course["id"];
		$course_name = mysql_prep($_POST["course_name"]);
		$Fach = mysql_prep($_POST["Fach"]);
		$Stimmen = (int) $_POST["Stimmen"];
		$position = (int) $_POST["position"];
		$visible = (int) $_POST["visible"];
		$Gesamtnote = (float) $_POST["Gesamtnote"];
		$Auftreten = (float) $_POST["Auftreten"];
		$Didaktik = (float) $_POST["Didaktik"];
		$Klinische_Relevanz = (float) $_POST["Klinische_Relevanz"];
		$Organisation = (float) $_POST["Organisation"];
	
		$query  = "UPDATE courses SET ";
		$query .= "course_name = '{$course_name}', ";
		$query .= "Fach = '{$Fach}', ";
		$query .= "Gesamtnote = {$Gesamtnote}, ";
		$query .= "Auftreten = {$Auftreten}, ";
		$query .= "Didaktik = {$Didaktik}, ";
		$query .= "Klinische_Relevanz = {$Klinische_Relevanz}, ";
		$query .= "Organisation = {$Organisation}, ";
		$query .= "Stimmen = {$Stimmen}, ";
		$query .= "position = {$position}, ";
		$query .= "visible = {$visible} ";
		$query .= "WHERE id = '{$id}' ";
		$query .= "LIMIT 1";
		$result = mysqli_query($connection, $query);

		if ($result && mysqli_affected_rows($connection) >= 0) {
			// Success
			$_SESSION["message"] = "course updated.";
			redirect_to("manage_content.php");
		} else {
			// Failure
			$message = "course update failed.";
		}
	
	}
} else {
	// This is probably a GET request
	
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
		<?php echo navigation($current_subject, $current_course, $current_comment); ?>
		<br />
		<a href="new_course.php">+ Add a course</a>
		<br />
		<?php echo image_navigation($current_exam_subject, $current_image); ?>
  </div>
  <div id="page">
		<?php // $message is just a variable, doesn't use the SESSION
			if (!empty($message)) {
				echo "<div class=\"message\">" . htmlentities($message) . "</div>";
			}
		?>
		<?php echo form_errors($errors); ?>
		
		<h2>Edit course: <?php echo htmlentities($current_course["course_name"]); ?></h2>
		<form action="edit_course.php?course=<?php echo urlencode($current_course["id"]); ?>" method="post">
			<p>Fach: 
			<select name="Fach">
				<?php
					$subject_set = find_all_subjects();
					while($subject = mysqli_fetch_assoc($subject_set)){
						$current_course_subject = find_subject_by_course($current_course["id"]);
						echo "<option value=\"{$subject["Fach"]}\"";
						if ($current_course_subject["Fach"] == $subject["Fach"]) {
							echo " selected";
						}
						echo ">{$subject["Fach"]}</option>";
					}
				?>
		    </select>			
			</p>
			<p>Kursname:  <input type="text" class="name" name="course_name" value="<?php echo htmlentities($current_course["course_name"]); ?>" /></p>
			
			<p>Gesamtnote: <input type="text" class="grade" name="Gesamtnote" value="<?php echo htmlentities($current_course["Gesamtnote"]); ?>" /></p>
			<p>Didaktik: <input type="text" class="grade" name="Didaktik" value="<?php echo htmlentities($current_course["Didaktik"]); ?>" /></p>
			<p>Auftreten: <input type="text" class="grade" name="Auftreten" value="<?php echo htmlentities($current_course["Auftreten"]); ?>" /></p>
			<p>Klinische Relevanz: <input type="text" class="grade" name="Klinische_Relevanz" value="<?php echo htmlentities($current_course["Klinische_Relevanz"]); ?>" /></p>
			<p>Organisation: <input type="text" class="grade" name="Organisation" value="<?php echo htmlentities($current_course["Organisation"]); ?>" /></p>
			<p>Stimmen: <input type="text" class="votes" name="Stimmen" value="<?php echo htmlentities($current_course["Stimmen"]); ?>" /></p>
			<p>Position:
		    <select name="position">
				<?php
					$course_set = find_all_courses();
					$course_count = mysqli_num_rows($course_set);
					for($count=1; $count <= $course_count; $count++) {
						echo "<option value=\"{$count}\"";
						if ($current_course["position"] == $count) {
							echo " selected";
						}
						echo ">{$count}</option>";
					}
				?>
		    </select>
		  </p>
		  <p>Visible:
		    <input type="radio" name="visible" value="0" <?php if ($current_course["visible"] == 0) { echo "checked"; } ?> /> No
		    &nbsp;
		    <input type="radio" name="visible" value="1" <?php if ($current_course["visible"] == 1) { echo "checked"; } ?>/> Yes
		  </p>
		  <input type="submit" name="submit" value="Edit course" />
		</form>
		<br />
		<a href="manage_content.php">Cancel</a>
		&nbsp;
		&nbsp;
		<a href="delete_course.php?course=<?php echo urlencode($current_course["id"]); ?>" onclick="return confirm('Are you sure?');">Delete course</a>
		
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
