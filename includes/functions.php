<?php

	function redirect_to($new_location) {
	  header("Location: " . $new_location);
	  exit;
	}

	function mysql_prep($string) {
		global $connection;
		
		$escaped_string = mysqli_real_escape_string($connection, $string);
		return $escaped_string;
	}
	
	function confirm_query($result_set) {
		if (!$result_set) {
			/*die("Es gibt momentan ein Problem mit dem Server. Versuch es später erneut.");*/
die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );
		}
	}

	function form_errors($errors=array()) {
		$output = "";
		if (!empty($errors)) {
		  $output .= "<div class=\"error\">";
		  $output .= "Please fix the following errors:";
		  $output .= "<ul>";
		  foreach ($errors as $key => $error) {
		    $output .= "<li>";
				$output .= htmlentities($error);
				$output .= "</li>";
		  }
		  $output .= "</ul>";
		  $output .= "</div>";
		}
		return $output;
	}
	
	function find_reports() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM reports ";
		$query .= "ORDER BY id DESC";
		$report_set = mysqli_query($connection, $query);
		confirm_query($report_set);
		return $report_set;
	}
	
	function find_all_courses() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM courses ";
		// $query .= "WHERE visible = 1 ";
		// $query .= "ORDER BY position ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
	}
	
	function find_all_subjects() {
		global $connection;
		
		$query  = "SELECT DISTINCT Fach ";
		$query .= "FROM courses ";
		// $query .= "WHERE visible = 1 ";
		$query .= "ORDER BY Fach ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
	}
	
	function find_all_exam_subjects() {
		global $connection;
		
		$query  = "SELECT DISTINCT exam_subject ";
		$query .= "FROM images ";
		$query .= "ORDER BY exam_subject ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
	}
	
	function find_all_histogram_subjects() {
		global $connection;
		
		$query  = "SELECT DISTINCT Fach ";
		$query .= "FROM exam_grades ";
		$query .= "ORDER BY Fach ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
	}

function find_histograms_for_subject($histogram_subject) {
		global $connection;
		
		$safe_histogram_subject = mysqli_real_escape_string($connection, $histogram_subject);
		
		$query = "SELECT * ";
		$query .="FROM exam_grades ";
		$query .="WHERE Fach = '{$safe_histogram_subject}'";
		$query .="ORDER BY Semester DESC";
		$histogram_set = mysqli_query($connection, $query);
		confirm_query($histogram_set);
		return $histogram_set;
	}
	
	function find_all_courses_for_subject($subject) {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM courses ";
		$query .= "WHERE Fach = '{$subject}' ";
		// $query .= "WHERE visible = 1 ";
		$query .= "ORDER BY course_name ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
	}

	
function find_all_courses_for_overview() {
		global $connection;
		$query  = "SELECT *";
		$query .= "FROM courses ";
		$query .= "ORDER BY course_name ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		return $course_set;
}	



	function find_comments_for_course($course_id) {
		global $connection;
		
		$safe_course_id = mysqli_real_escape_string($connection, $course_id);
		
		$query  = "SELECT * ";
		$query .= "FROM comments ";
		$query .= "WHERE course_id = '{$safe_course_id}' ";
		//$query .= "AND visible = 1";
		$query .= "ORDER BY comment_date DESC";
		$comment_set = mysqli_query($connection, $query);
		confirm_query($comment_set);
		return $comment_set;
	}
	
	function find_grades_for_comment($comment_id) {
		global $connection;
		
		$safe_comment_id = mysqli_real_escape_string($connection, $comment_id);
		
		$query  = "SELECT * ";//Gesamtnote, Auftreten, Didaktik, Klinische_Relevanz, Organisation";
		$query .= "FROM grades ";
		$query .= "WHERE comment_id = '{$safe_comment_id}' ";
		$grade_set = mysqli_query($connection, $query);
		confirm_query($grade_set);
		return $grade_set;
	}
	
	function find_grades_for_course($course_id) {
		global $connection;
		
		$safe_course_id = mysqli_real_escape_string($connection, $course_id);
		
		$query  = "SELECT AVG(Gesamtnote), AVG(Auftreten), AVG(Didaktik), AVG(Klinische_Relevanz), AVG(Organisation), COUNT(*) ";
		$query .= "FROM grades ";
		$query .= "WHERE course_id = '{$safe_course_id}' ";
		$grade_set = mysqli_query($connection, $query);
		confirm_query($grade_set);

return $grade_set;
	}

function find_semesterbegleitend_for_course($course_id) {
global $connection;
		
		$safe_course_id = mysqli_real_escape_string($connection, $course_id);
		
		$query  = "SELECT Semesterbegleitend ";
		$query .= "FROM courses ";
		$query .= "WHERE id = '{$safe_course_id}' ";
$semesterbegleitend_array = mysqli_query($connection, $query);
confirm_query($semesterbegleitend_array);

$semesterbegleitend = mysqli_fetch_assoc($semesterbegleitend_array);
		return $semesterbegleitend["Semesterbegleitend"];

}
	
	/* depracted, changed how the database works
	function find_grades_for_course($course_id) {
		global $connection;
		
		$safe_course_id = mysqli_real_escape_string($connection, $course_id);
		
		$query  = "SELECT Gesamtnote, Auftreten, Didaktik, Klinische_Relevanz, Organisation, Stimmen ";
		$query .= "FROM courses ";
		$query .= "WHERE visible = 1 ";
		$query .= "AND id = '{$safe_course_id}' ";
		$grade_set = mysqli_query($connection, $query);
		confirm_query($grade_set);
		return $grade_set;
	}*/
	
	function find_images_for_subject($exam_subject) {
		global $connection;
		
		$safe_exam_subject = mysqli_real_escape_string($connection, $exam_subject);
		
		//$query = "SELECT semester_season, semester_year ";
		$query = "SELECT * ";
		$query .="FROM images ";
		$query .="WHERE exam_subject = '{$safe_exam_subject}'";
		$query .="ORDER BY semester_year DESC, semester_season DESC";
		$image_set = mysqli_query($connection, $query);
		confirm_query($image_set);
		return $image_set;
	}
	
	//almost identical to image_query. one could probably avoid repeating code...
	function format_images_for_subject($exam_subject) {
		$image_set = find_images_for_subject($exam_subject); 
		$images = [];
		//(re)construct name from database
		for($i=0 ; $image = mysqli_fetch_assoc($image_set) ; $i++) {
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
			$image_name .= ".PNG"; //.png on computer,.PNG on 000webhost
			$images[$i] = htmlentities($image_name);
		}
		return $images;
	}
	
	function find_course_by_id($course_id) {
		global $connection;
		
		$safe_course_id = mysqli_real_escape_string($connection, $course_id);
		
		$query  = "SELECT * ";
		$query .= "FROM courses ";
		$query .= "WHERE id = '{$safe_course_id}' ";
		$query .= "LIMIT 1";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		if($course = mysqli_fetch_assoc($course_set)) {
			return $course;
		} else {
			return null;
		}
	}

	function find_comment_by_id($comment_id) {
		global $connection;
		
		$safe_comment_id = mysqli_real_escape_string($connection, $comment_id);
		
		$query  = "SELECT * ";
		$query .= "FROM comments ";
		$query .= "WHERE id = {$safe_comment_id} ";
		$query .= "LIMIT 1";
		$comment_set = mysqli_query($connection, $query);
		confirm_query($comment_set);
		if($comment = mysqli_fetch_assoc($comment_set)) {
			return $comment;
		} else {
			return null;
		}
	}
	
	function find_image_by_id($image_id) {
		global $connection;
		
		$safe_image_id = mysqli_real_escape_string($connection, $image_id);
		
		$query  = "SELECT * ";
		$query .= "FROM images ";
		$query .= "WHERE id = {$safe_image_id} ";
		$query .= "LIMIT 1";
		$image_set = mysqli_query($connection, $query);
		confirm_query($image_set);
		if($image = mysqli_fetch_assoc($image_set)) {
			return $image;
		} else {
			return null;
		}
	}
	
	
	function find_subject_by_course($course_id) {
		global $connection;
		
		$safe_course_id = mysqli_real_escape_string($connection, $course_id);
		
		$query  = "SELECT Fach ";
		$query .= "FROM courses ";
		$query .= "WHERE id = '{$safe_course_id}' ";
		$query .= "LIMIT 1";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		if($course = mysqli_fetch_assoc($course_set)) {
			return $course;
		} else {
			return null;
		}
	}
	
	//find_select_menu_item
	function find_selected_comment() {
		global $current_subject;
		global $current_course;
		global $current_comment;
		global $current_exam_subject;
		global $current_image;
		global $current_histogram_subject;
		
		if (isset($_GET["subject"])) {
			$current_subject = mysql_prep($_GET["subject"]); //subject is string
			$current_course = null;
			$current_comment = null;
			$current_exam_subject = null;
			$current_image = null;
			$current_histogram_subject = null;
		} else if (isset($_GET["course"])) {
			$current_subject = null;
			$current_course = find_course_by_id(mysql_prep($_GET["course"]));
			$current_comment = null;
			$current_exam_subject = null;
			$current_image = null;
			$current_histogram_subject = null;
		} else if (isset($_GET["comment"])) {
			$current_subject = null;
			$current_course = null;
			$current_exam_subject = null;
			$current_image = null;
			$current_comment = find_comment_by_id(mysql_prep($_GET["comment"]));
			$current_histogram_subject = null;
		} else if (isset($_GET["exam_subject"])){
			$current_subject = null;
			$current_course = null;
			$current_comment = null;
			$current_exam_subject = mysql_prep($_GET["exam_subject"]);
			$current_image = null;	
			$current_histogram_subject = null;
		} else if (isset($_GET["image"])){
			$current_subject = null;
			$current_course = null;
			$current_comment = null;
			$current_exam_subject = null;
			$current_image = find_image_by_id(mysql_prep($_GET["image"]));
			$current_histogram_subject = null;			
		} else if (isset($_GET["histogram_subject"])){
			$current_subject = null;
			$current_course = null;
			$current_comment = null;
			$current_exam_subject = null;
			$current_image = null;
			$current_histogram_subject = mysql_prep($_GET["histogram_subject"]);			
		} else {
			$current_subject = null;
			$current_course = null;
			$current_comment = null;
			$current_exam_subject = null;
			$current_image = null;
			$current_histogram_subject = null;
		}
	}

	// navigation takes 3 arguments
	// - the current subject array or null
	// - the current course array or null
	// - the current comment array or null
	function navigation($subject_array, $course_array, $comment_array) {
$output = "<h3>Wahlpflichtblöcke</h3>";
		$output .= "<ul class=\"subjects\">";
		$subject_set = find_all_subjects();
		while($subject = mysqli_fetch_assoc($subject_set)){
			$output .= "<li";
			if ($subject_array && $subject["Fach"] == $subject_array) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?subject=";
			$output .= urlencode($subject["Fach"]);
			$output .= "\">";
			$output .= htmlentities($subject["Fach"]);
			$output .= "</a>";
			
			$course_set = find_all_courses_for_subject($subject["Fach"]);
			$output .= "<ul class=\"courses\">";
			if ($subject_array == $subject["Fach"] || 
					$course_array["Fach"] == $subject["Fach"]) {
				while($course = mysqli_fetch_assoc($course_set)) {
					$output .= "<li";
					if ($course_array && $course["id"] == $course_array["id"]) {
						$output .= " class=\"selected\"";
					}
					$output .= ">";
					$output .= "<a href=\"manage_content.php?course=";
					$output .= urlencode($course["id"]);
					$output .= "\">";
					$output .= htmlentities($course["course_name"]);
					$output .= "</a>";
					
					$comment_set = find_comments_for_course($course["id"]);
					$output .= "<ul class=\"comments\">";
					if ($course_array["id"] == $course["id"] || 
						$comment_array["course_id"] == $course["id"]) {
						while($comment = mysqli_fetch_assoc($comment_set)) {
							$output .= "<li";
							if ($comment_array && $comment["id"] == $comment_array["id"]) {
								$output .= " class=\"selected\"";
							}
							$output .= ">";
							$output .= "<a href=\"manage_content.php?comment=";
							$output .= urlencode($comment["id"]);
							$output .= "\">";
							$output .= htmlentities($comment["user_name"]);
							$output .= "</a></li>";
						}
						mysqli_free_result($comment_set);
						$output .= "</ul></li>";
					} else {
						mysqli_free_result($comment_set);
						$output .= "</ul></li>";
					}
				}
				mysqli_free_result($course_set);
				$output .= "</ul></li>";
			} else {
				mysqli_free_result($course_set);
					$output .= "</ul></li>";
			}
		}
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
	}

	function image_navigation($exam_subject_array) {
		$output = "<h3>Notenspiegel</h3>";
		$output .= "<ul class=\"subjects\">";
		$exam_subject_set = find_all_exam_subjects();
		while($exam_subject = mysqli_fetch_assoc($exam_subject_set)) {
			$output .= "<li";
			if ($exam_subject_array && $exam_subject["exam_subject"] == $exam_subject_array) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?exam_subject=";
			$output .= urlencode($exam_subject["exam_subject"]);
			$output .= "\">";
			$output .= htmlentities(str_replace("_"," ",$exam_subject["exam_subject"])); //str_replace make name Physikum_X into Physikum X
			$output .= "</a>";
		}
		mysqli_free_result($exam_subject_set);
		$output .= "</ul>";
		return $output;
	}
	
	function histogram_navigation($exam_subject_array) {
		$output = "<h3>Notenspiegel</h3>";
		$output .= "<ul class=\"subjects\">";
		$exam_subject_set = find_all_histogram_subjects();
		while($exam_subject = mysqli_fetch_assoc($exam_subject_set)) {
			$output .= "<li";
			if ($exam_subject_array && $exam_subject["Fach"] == $exam_subject_array) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"manage_content.php?exam_subject=";
			$output .= urlencode($exam_subject["Fach"]);
			$output .= "\">";
			//$output .= htmlentities(str_replace("_"," ",$exam_subject["Fach"])); //str_replace make name Physikum_X into Physikum X
			$output .= "</a>";
		}
		mysqli_free_result($exam_subject_set);
		$output .= "</ul>";
		return $output;
	}
	
	
	function public_navigation($subject_array, $course_array) {
		$output = "<a href=\"index.php\"><h3>Startseite</h3></a>";
$output .= "<a href=\"overview.php\"><h3>Übersicht</h3></a>"; //<img src=\"/images/neu_btn.PNG\" width=\"32px\" height=\"16px\"></h3></a>";
$output .= "<a href=\"plugin.php\"><h3>Klips-Plugin</h3></a>";
		$output .= "<h3>Wahlpflichtblöcke</h3>";
		$output .= "<ul class=\"subjects\">";
		$subject_set = find_all_subjects();
		while($subject = mysqli_fetch_assoc($subject_set)){
			$output .= "<li";
			if ($subject_array && $subject["Fach"] == $subject_array) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?subject=";
			$output .= urlencode($subject["Fach"]);
			$output .= "\">";
			$output .= htmlentities($subject["Fach"]);
			$output .= "</a>";
			
			$course_set = find_all_courses_for_subject($subject["Fach"]);
			$output .= "<ul class=\"courses\">";
			if ($subject_array == $subject["Fach"] || 
					$course_array["Fach"] == $subject["Fach"]) {
				while($course = mysqli_fetch_assoc($course_set)) {
					$output .= "<li";
					if ($course_array && $course["id"] == $course_array["id"]) {
						$output .= " class=\"selected\"";
					}
					$output .= ">";
					$output .= "<a href=\"index.php?course=";
					$output .= urlencode($course["id"]);
					$output .= "\">";
					$output .= htmlentities($course["course_name"]);
					$output .= "</a></li>";
					
				}
				mysqli_free_result($course_set);
				$output .= "</ul></li>";
			} else {
				mysqli_free_result($course_set);
					$output .= "</ul></li>";
			}
		}
		mysqli_free_result($subject_set);
		$output .= "</ul>";
		return $output;
	}
	
	function public_image_navigation($exam_subject_array) {
		$output = "<h3>Notenspiegel</h3>";
		$output .= "<ul class=\"subjects\">";
		$exam_subject_set = find_all_exam_subjects();
		while($exam_subject = mysqli_fetch_assoc($exam_subject_set)) {
			$output .= "<li";
			if ($exam_subject_array && $exam_subject["exam_subject"] == $exam_subject_array) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?exam_subject=";
			$output .= urlencode($exam_subject["exam_subject"]);
			$output .= "\">";
			$output .= htmlentities(str_replace("_"," ",$exam_subject["exam_subject"])); //str_replace make name Physikum_X into Physikum X
			$output .= "</a>";
		}
		mysqli_free_result($exam_subject_set);
		$output .= "</ul>";
		return $output;
	}

	
	function public_histogram_navigation($exam_subject_array) {
		$output = "<h3>Notenspiegel</h3>";
		$output .= "<ul class=\"subjects\">";
		$exam_subject_set = find_all_histogram_subjects();
		while($exam_subject = mysqli_fetch_assoc($exam_subject_set)) {
			$output .= "<li";
			if ($exam_subject_array && $exam_subject["Fach"] == $exam_subject_array) {
				$output .= " class=\"selected\"";
			}
			$output .= ">";
			$output .= "<a href=\"index.php?histogram_subject=";
			$output .= urlencode($exam_subject["Fach"]);
			$output .= "\">";
			$output .= htmlentities(str_replace("_"," ",$exam_subject["Fach"])); //str_replace make name Physikum_X into Physikum X
			$output .= "</a>";
		}
		mysqli_free_result($exam_subject_set);
		$output .= "</ul>";
		return $output;
	}
		
	function populate_table(){
		$course_set = find_all_courses_for_overview();
		while($course = mysqli_fetch_assoc($course_set)) {
			$output = "<tr>";
			$output .= "<td><a href=\"/index.php?course=";
			$output .= urlencode($course["id"]);
			$output .= "\">";
			$output .= htmlentities($course["course_name"]);
			$output .= "</a></td>";
			$grade_set = find_grades_for_course($course["id"]);
$grade = mysqli_fetch_assoc($grade_set);
$gesamtnote = htmlentities(number_format($grade["AVG(Gesamtnote)"], 2, ",", "."));
$stimmen = htmlentities(number_format($grade["COUNT(*)"], 0, ",", "."));
			$output .= "<td>$gesamtnote</td>";
			$output .= "<td>$stimmen</td>";
			$comments_num = mysqli_num_rows(find_comments_for_course($course["id"]));
			$output .= "<td>";
			$output .= $comments_num;
			$output .= "</td><td>";
			$output .= htmlentities($course["Semesterbegleitend"]);
			$output .= "</td><td>";
			$output .= htmlentities($course["Schlüsselqualifikationskurs"]);
			$output .= "</td></tr>";
echo $output;
		}
return 1;
	}


	function find_default_comment_for_course($course_id) {
		$comment_set = find_comments_for_course($course_id);
		if($first_comment = mysqli_fetch_assoc($comment_set)) {
			return $first_comment;
		} else {
			return null;
		}
	}
	
//login functions
	function password_encrypt($password) {
  	$hash_format = "$2y$10$";   // Tells PHP to use Blowfish with a "cost" of 10
	  $salt_length = 22; 					// Blowfish salts should be 22-characters or more
	  $salt = generate_salt($salt_length);
	  $format_and_salt = $hash_format . $salt;
	  $hash = crypt($password, $format_and_salt);
		return $hash;
	}
	
	function generate_salt($length) {
	  // Not 100% unique, not 100% random, but good enough for a salt
	  // MD5 returns 32 characters
	  $unique_random_string = md5(uniqid(mt_rand(), true));
	  
		// Valid characters for a salt are [a-zA-Z0-9./]
	  $base64_string = base64_encode($unique_random_string);
	  
		// But not '+' which is valid in base64 encoding
	  $modified_base64_string = str_replace('+', '.', $base64_string);
	  
		// Truncate string to the correct length
	  $salt = substr($modified_base64_string, 0, $length);
	  
		return $salt;
	}
	
	function password_check($password, $existing_hash) {
		// existing hash contains format and salt at start
	  $hash = crypt($password, $existing_hash);
	  if ($hash === $existing_hash) {
	    return true;
	  } else {
	    return false;
	  }
	}

	function attempt_login($username, $password) {
		$admin = find_admin_by_username($username);
		if ($admin) {
			// found admin, now check password
			if (password_check($password, $admin["hashed_password"])) {
				// password matches
				return $admin;
			} else {
				// password does not match
				return false;
			}
		} else {
			// admin not found
			return false;
		}
	}
	//root user log in
	function logged_in() {
		if (isset($_SESSION['admin_id'])) {
			if($_SESSION['username'] === "main_admin"){ 
				return 1; 
			}
		}
		return 0; 
	}
	
	function confirm_logged_in() {
		if (!logged_in() && !editor_logged_in()) {
			redirect_to("login.php");
		} else if(!logged_in() && editor_logged_in()){
			$_SESSION["message"] = "In order to accesss this page, please login as root user";
			redirect_to("login.php");
		}
	}
	
	function editor_logged_in() {
		return isset($_SESSION['admin_id']);
	}
	
	function confirm_editor_logged_in() {
		if (!editor_logged_in()) {
			redirect_to("login.php");
		}
	}
		
	function find_admin_by_id($admin_id) {
		global $connection;
		
		$safe_admin_id = mysqli_real_escape_string($connection, $admin_id);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE id = {$safe_admin_id} ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}

	function find_admin_by_username($username) {
		global $connection;
		
		$safe_username = mysqli_real_escape_string($connection, $username);
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "WHERE username = '{$safe_username}' ";
		$query .= "LIMIT 1";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		if($admin = mysqli_fetch_assoc($admin_set)) {
			return $admin;
		} else {
			return null;
		}
	}
	
	function find_all_admins() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM admins ";
		$query .= "ORDER BY username ASC";
		$admin_set = mysqli_query($connection, $query);
		confirm_query($admin_set);
		return $admin_set;
	}
	
	//public functions to count site statistics, e.g. for skripte.koeln
	function count_courses() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM courses ";
		// $query .= "WHERE visible = 1 ";
		// $query .= "ORDER BY position ASC";
		$course_set = mysqli_query($connection, $query);
		confirm_query($course_set);
		$count = mysqli_num_rows($course_set);
		return $count;
	}
	
	function count_grades() {
		global $connection;
		
		$query  = "SELECT * ";
		$query .= "FROM grades ";
		// $query .= "WHERE visible = 1 ";
		// $query .= "ORDER BY position ASC";
		$grade_set = mysqli_query($connection, $query);
		confirm_query($grade_set);
		$count = mysqli_num_rows($grade_set);
		return $count;
	}
	
	function count_comments() {
		global $connection;
		//couldn't get exclude to work, so count all rows and subtract Klips2 and Notenvergaben
		
		//count all
		$query  = "SELECT *";
		$query .= "FROM comments ";
		$comment_set = mysqli_query($connection, $query);
		confirm_query($comment_set);
		$count = mysqli_num_rows($comment_set);
		
		//count Klips2 comments
		$query  = "SELECT * ";
		$query .= "FROM comments ";
		$query .= "WHERE user_name='Klips2' ";
		$comment_set2 = mysqli_query($connection, $query);
		confirm_query($comment_set2);
		
		$count = $count - mysqli_num_rows($comment_set2);
		
		//count Notenvergabe comments
		$query  = "SELECT * ";
		$query .= "FROM comments ";
		$query .= "WHERE content='[Nur Notenvergabe]' ";
		$comment_set3 = mysqli_query($connection, $query);
		confirm_query($comment_set3);
		
		$count = $count - mysqli_num_rows($comment_set3);
		
		return $count ;
	}