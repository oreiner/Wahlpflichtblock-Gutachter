<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
//if (isset($_POST['submit'])) {
	// Process the form
	  //if (empty($errors)) {
		// Perform Create

		// make sure you add the course_id! 
// be sure to escape the content mysql_prep
// currently GET (create_comment.php)
		$course_id = mysql_prep($_GET["course"]);
		$comment_id = mysql_prep($_GET["comment_id"]);
$notes= mysql_prep($_GET["notes"]);
$source = mysql_prep($_GET["source"]);
		
		
		
		global $connection;
		$comment = find_comment_by_id($comment_id);
		//$comment_date = $comment[""];
		
		$query  = "INSERT INTO reports (course_id, user_name, source, content, notes) VALUES ";
		$query .= "(";
		$query .= "'{$course_id}', '{$comment["user_name"]}', '{$source}', '{$comment["content"]}', '{$notes}'";
		$query .= ")";
		$result = mysqli_query($connection, $query);
		
		if ($result) {
		  // Success
		  $_SESSION["message"] = "Danke für deine Hinweis.";
		} else {
		  // Failure
		  $_SESSION["message"] = "Leider könnte die Meldung nicht geschickt werden. Versuch nochmal" . mysqli_error($connection);
		}
		redirect_to("index.php?course={$course_id}");
	  //}
//} else {
		// This is probably a GET request
		//redirect_to("index.php?course={$course_id}");
//}

?>


<?php
	if (isset($connection)) { mysqli_close($connection); }
?>