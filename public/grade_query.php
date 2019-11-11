<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php 
/*
	$safe_course_id = mysql_prep($_GET['course']); 
	$course_grades = find_grades_for_course($safe_course_id);
	if($grade = mysqli_fetch_assoc($course_grades)) {
		echo htmlentities($grade["Gesamtnote"]);
		echo ",";
		echo htmlentities($grade["Auftreten"]);
		echo ",";
		echo htmlentities($grade["Didaktik"]);
		echo ",";
		echo htmlentities($grade["Interesse"]);
		echo ",";
		echo htmlentities($grade["Viel_Gelernt"]);	
	}
*/
	$safe_course_id = mysql_prep($_GET['course']); 
	$course_grades = find_grades_for_course($safe_course_id);


	if($grade = mysqli_fetch_assoc($course_grades)){

		echo $gesamtnote = htmlentities(number_format($grade["AVG(Gesamtnote)"], 2, ",", "."));
		echo "#";
		echo $didaktik = htmlentities(number_format($grade["AVG(Didaktik)"], 2, ",", "."));
		echo "#";
		echo $auftreten = htmlentities(number_format($grade["AVG(Auftreten)"], 2, ",", "."));
		echo "#";
		echo $klinische_Relevanz = htmlentities(number_format($grade["AVG(Klinische_Relevanz)"], 2, ",", "."));
		echo "#";
		echo $organisation = htmlentities(number_format($grade["AVG(Organisation)"], 2, ",", "."));
		echo "#";
		echo $stimmen = htmlentities(number_format($grade["COUNT(*)"], 0, ",", "."));
		echo "#";
echo find_semesterbegleitend_for_course($safe_course_id);

	}
?>

<?php
  // 5. Close database connection
	if (isset($connection)) {
	  mysqli_close($connection);
	}
?>