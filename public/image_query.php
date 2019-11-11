<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php 
	$safe_exam_subject = mysql_prep($_GET['exam_subject']);
	$image_set = find_images_for_subject($safe_exam_subject); 
	//(re)construct name from database
	while($image = mysqli_fetch_assoc($image_set)) {
		if($image["semester_season"] === "WS"){
			$image_name = "Wintersemester";
		} else if ($image["semester_season"] === "SS"){
			$image_name = "Sommersemester";
		}
		$image_name .= "_20";
		$image_name .= $image["semester_year"];
		if($image["semester_season"] === "WS"){
			$image_name .= "_".($image["semester_year"]+1);
		}
		$image_name .= ".png";
		echo htmlentities($image_name);
		echo ",";
	}
?>

<?php
  // 5. Close database connection
	if (isset($connection)) {
	  mysqli_close($connection);
	}
?>
