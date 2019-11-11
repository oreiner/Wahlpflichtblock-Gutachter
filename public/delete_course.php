<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
	$current_course = find_course_by_id($_GET["course"]);
	if (!$current_course) {
		// course ID was missing or invalid or 
		// course couldn't be found in database
		redirect_to("manage_content.php");
	}
	
	$comments_set = find_comments_for_course($current_course["id"]);
	if (mysqli_num_rows($comments_set) > 0) {
		$_SESSION["message"] = "Can't delete a course with comments.";
		redirect_to("manage_content.php?course={$current_course["id"]}");
	}
	
	$id = $current_course["id"];
	$query = "DELETE FROM courses WHERE id = '{$id}' LIMIT 1";
	$result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) == 1) {
		// Success
		$_SESSION["message"] = "course deleted.";
		redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "course deletion failed.";
		redirect_to("manage_content.php?course={$id}");
	}
	
?>
