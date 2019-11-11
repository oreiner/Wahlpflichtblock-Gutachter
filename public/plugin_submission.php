<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include_once("../includes/analyticstracking.php"); ?>

<?php
echo $_POST['submit'];
if (isset($_POST['submit'])) {
	// Process the form
	  // validations
	  //$required_fields = array("Fachsemester", "WPBsemester");
	  //validate_presences($required_fields);

	  //$fields_with_max_lengths = array("user_name" => 30, "content" => 8000);
	  //validate_max_lengths($fields_with_max_lengths);
	  
	  if (empty($errors)) {
		
		$query  = "INSERT INTO exam_grades (";
		$query .= " Fach, Semester, Typ, sehr_gut_4_punkte, gut_3_punkte, befriedigend_2_punkte, ausreichend_1_punkt, nicht_ausreichend_0_punkte, nicht_erschienen, durchschnitt";
		$query .= ") VALUES (";
		$query .= "'{$_POST["Fach"]}','{$_POST["Semester"]}','{$_POST["Typ"]}',{$_POST["sehr_gut_4_punkte"]},{$_POST["gut_3_punkte"]},{$_POST["befriedigend_2_punkte"]},{$_POST["ausreichend_1_punkt"]},{$_POST["nicht_ausreichend_0_punkte"]},{$_POST["nicht_erschienen"]},{$_POST["durchschnitt"]} ";
		$query .= ")";
		$result = mysqli_query($connection, $query);
		$comment_id = mysqli_insert_id($connection);

		if ($result) {
		  // Success
echo "Danke für deine Mitarbeit";
		  $_SESSION["message"] = "Danke für deine Mitarbeit";
		} else {
		  // Failure
echo mysqli_error($connection);
		  $_SESSION["message"] = "comment creation failed."; //." ".mysqli_error($connection);
		}
	  } else {
		  $_SESSION["message"] = print_r($errors);
echo mysqli_error($connection);
	  }
} else {
		// This is probably a GET request
		$_SESSION["message"] = "error, no POST submit";
}
?>


<?php
	if (isset($connection)) { mysqli_close($connection); }
?>