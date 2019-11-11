<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>
<?php include_once("../includes/analyticstracking.php"); ?>

<?php
$course_id = mysql_prep($_POST["id"]);
if (isset($_POST['submit'])) {
	// Process the form
	  // validations
	  $required_fields = array("Fachsemester", "WPBsemester");
	  validate_presences($required_fields);

	  $fields_with_max_lengths = array("user_name" => 30, "content" => 8000);
	  validate_max_lengths($fields_with_max_lengths);
	  
	  if (empty($errors)) {
		// Perform Create

		// make sure you add the course_id!
		//$course_id = mysql_prep($_POST["id"]); This now needs to come before the if, or the redirect doesn't work
		$_POST["user_name"] !== "" ? $user_name = mysql_prep($_POST["user_name"]) : $user_name = "Anonymus";
		$source = $_POST["source"]; 
$position = 1;
		$content = htmlentities(mysql_prep($_POST["content"]));
		if($content == ""){
			$visible = 1;
			$content = "\[Nur Notenvergabe\]";
		} else {
			$visible = 0;	
		}
		$Fachsemester = $_POST["Fachsemester"];
		$WPBsemester = $_POST["WPBsemester"];
date_default_timezone_set('Europe/Berlin');
		$comment_date = date("Y-m-d H:i:s");
		
	  
		$query  = "INSERT INTO comments (";
		$query .= " course_id, user_name, Fachsemester, WPBsemester, content, comment_date, position, visible";
		$query .= ") VALUES (";
		$query .= " '{$course_id}', '{$user_name}', '{$Fachsemester}', '{$WPBsemester}','{$content}', '{$comment_date}', {$position}, {$visible} ";
		$query .= ")";
		$result = mysqli_query($connection, $query);
		$comment_id = mysqli_insert_id($connection);

		$Didaktik_Note = $_POST["Didaktik_Note"];
		$Auftreten_Note = $_POST["Auftreten_Note"];
		$Klinische_Relevanz_Note = $_POST["Klinische_Relevanz_Note"];
		$Organisation_Note = $_POST["Organisation_Note"];
		if($Didaktik_Note && $Auftreten_Note && $Klinische_Relevanz_Note && $Organisation_Note){
			$Gesamtnote = number_format(($Didaktik_Note + $Auftreten_Note + $Klinische_Relevanz_Note + $Organisation_Note) / 4, 2, ".", "");
			$notes = "Ja";

			$query  = "INSERT INTO grades (";
			$query .= " comment_id, course_id, Gesamtnote, Didaktik, Auftreten, Klinische_Relevanz, Organisation";
			$query .= ") VALUES (";
			$query .= " {$comment_id}, '{$course_id}', {$Gesamtnote}, {$Didaktik_Note}, {$Auftreten_Note}, {$Klinische_Relevanz_Note}, {$Organisation_Note} ";
			$query .= ")";
			$result = mysqli_query($connection, $query);
		} else { $notes = "Nein"; }		
		if ($result) {
		  // Success
		  $_SESSION["message"] = "Danke für deinen Kommentar.";

		  //create report 
		  redirect_to("www.google.com");
		  redirect_to("create_report.php?course={$course_id}&comment_id={$comment_id}&source={$source}&notes={$notes}");
		//redirect_to("index.php?course={$course_id}");
		} else {
		  // Failure
		  redirect_to("www.google.com");
		  $_SESSION["message"] = "comment creation failed."; //." ".mysqli_error($connection);
		  redirect_to("index.php?course={$course_id}");
		}
	  } else {
		  redirect_to("www.google.com");
		  $_SESSION["message"] = print_r($errors);
		  redirect_to("index.php?course={$course_id}");
	  }
} else {
		// This is probably a GET request
		redirect_to("www.google.com");
		redirect_to("index.php?course={$course_id}");

}
?>


<?php
	if (isset($connection)) { mysqli_close($connection); }
?>