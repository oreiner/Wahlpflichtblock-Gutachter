<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php
if (isset($_POST['submit'])) {
	// Process the form
	
	$id = $current_course["id"];
	$course_name = mysql_prep($_POST["course_name"]);
	$Fach = mysql_prep($_POST["Fach"]);
	$Gesamtnote = (float) $_POST["Gesamtnote"];
	$Auftreten = (float) $_POST["Auftreten"];
	$Didaktik = (float) $_POST["Didaktik"];
	$Klinische_Relevanz = (float) $_POST["Klinische_Relevanz"];
	$Organisation = (float) $_POST["Organisation"];
	$stimmen = (int) $_POST["Stimmen"];
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];

	// validations
	
	//new validation needed - id in correct format, non duplicate
	
	$required_fields = array("id","course_name","Fach","Gesamtnote","Auftreten","Didaktik","Klinische_Relevanz","Organisation","position", "visible");
	validate_presences($required_fields);
	
	$fields_with_max_lengths = array("course_name" => 128);
	validate_max_lengths($fields_with_max_lengths);
	
	$fields_with_decimal_numbers = array("Gesamtnote","Auftreten","Didaktik","Klinische_Relevanz","Organisation");
	validate_grade_format($fields_with_decimal_numbers); //check greater than 1.00 and smaller than 6.00
	
	
	if (!empty($errors)) {
		$_SESSION["errors"] = $errors;
		redirect_to("new_course.php");
	}
	
	$query  = "INSERT INTO courses (";
	$query .= "  id, course_name, Fach, Gesamtnote, Auftreten, Didaktik, Klinische_Relevanz, Organisation, stimmen, position, visible";
	$query .= ") VALUES (";
	$query .= "  '{$id}', '{$course_name}', '{$Fach}', {$Gesamtnote}, {$Auftreten}, {$Didaktik}, {$Klinische_Relevanz},  {$Organisation}, {$stimmen},{$position}, {$visible}";
	$query .= ")";
	$result = mysqli_query($connection, $query);

	if ($result) {
		// Success
		$_SESSION["message"] = "course created.";
		redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "course creation failed. " . mysqli_error($connection);
		redirect_to("new_course.php");
	}
	
} else {
	// This is probably a GET request
	redirect_to("new_course.php");
}

?>


<?php
	if (isset($connection)) { mysqli_close($connection); }
?>
