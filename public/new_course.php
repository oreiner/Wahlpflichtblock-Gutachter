<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php include("../includes/layouts/header.php"); ?>
<?php find_selected_comment(); ?>

<div id="main">
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
		<?php $errors = errors(); ?>
		<?php echo form_errors($errors); ?>
		
		<h2>Create course</h2>
		<form action="create_course.php" method="post">
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
			<p>Kurs ID:  <input type="text" class="course_id" name="id" value="" /> Kopiere von Klips2. (format ist aNNNNNN, a ist der Buchstabe a, N ist eine Zahl) </p>
			<p>Kursname:  <input type="text" class="name" name="course_name" value="" /></p>
			<p>Gesamtnote: <input type="text" class="grade" name="Gesamtnote" value="" /></p>
			<p>Didaktik: <input type="text" class="grade" name="Didaktik" value="" /></p>
			<p>Auftreten: <input type="text" class="grade" name="Auftreten" value="" /></p>
			<p>Klinische Relevanz: <input type="text" class="grade" name="Klinische_Relevanz" value="" /></p>
			<p>Organisation: <input type="text" class="grade" name="Organisation" value="" /></p>
			<p>Stimmen: <input type="text" class="votes" name="Stimmen" value="" /></p>
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
		  <input type="submit" name="submit" value="Create course" />
		</form>
		<br />
		<a href="manage_content.php">Cancel</a>
	</div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
