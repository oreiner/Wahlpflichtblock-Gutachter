<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php 
	
	$safe_course_id = mysql_prep($_GET['course']);
	$course_comments = find_comments_for_course($safe_course_id);
	while($comment = mysqli_fetch_assoc($course_comments)) {
		echo htmlentities($comment["content"]);
		echo "commentspace";
	}
?>

<?php
  // 5. Close database connection
	if (isset($connection)) {
	  mysqli_close($connection);
	}
?>
