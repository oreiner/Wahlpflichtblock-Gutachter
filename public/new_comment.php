<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_comment(); ?>

<?php
  // Can't add a new comment unless we have a course as a parent!
  if (!$current_course) {
    // course ID was missing or invalid or 
    // course couldn't be found in database
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  //(changed the js to send 1 and 1. maybe change position to auto increment?)
  //before validations because the Plug-In nevers send position and visible. artifically create values
  if(!isset($_POST["position"])){ $_POST["position"] = 1; }
  if(!isset($_POST["visible"])){ $_POST["visible"] = 1; }
  
  // validations
  $required_fields = array("user_name", "content", "position", "visible");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("user_name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    // Perform Create

    // make sure you add the course_id!
    $course_id = $current_course["id"];
    $user_name = mysql_prep($_POST["user_name"]);
    $position = (int) $_POST["position"];
    $visible = (int) $_POST["visible"];
    // be sure to escape the content
    $content = mysql_prep($_POST["content"]);
	$comment_date = date("Y-m-d H:i:s");
  
    $query  = "INSERT INTO comments (";
    $query .= "  course_id, user_name, content, comment_date, position, visible";
    $query .= ") VALUES (";
    $query .= "  '{$course_id}', '{$user_name}', '{$content}', '{$comment_date}', {$position}, {$visible} ";
    $query .= ")";
    $result = mysqli_query($connection, $query);
	
    if ($result) {
      // Success
      $_SESSION["message"] = "comment created.";
      redirect_to("manage_content.php?course=" . urlencode($current_course["id"]));
    } else {
      // Failure
      $_SESSION["message"] = "comment creation failed.";
    }
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layouts/header.php"); ?>
<div id="main">
  <div id="navigation">
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
    <?php echo form_errors($errors); ?>
    
    <h2>Create comment</h2>
	<p>Kursname: <?php echo $current_course["course_name"]; ?> </p>
    <form action="new_comment.php?course=<?php echo urlencode($current_course["id"]); ?>" method="post">
      <p>Benutzername:
        <input type="text" name="user_name" value="" />
      </p>
	  <p>Fachsemester: <select name="Fachsemester"/>
					<?php for ($i = 1; $i <= 10; $i++) : ?>
						<option value="<?php echo $i; ?>"><?php echo $i; ?></option>
					<?php endfor; ?>
		</select> (In dem du warst, als du den Kurs absolviert hast)</p>
		<p>WPB-Semester: <select name="WPBsemester" value="WS 2016/17"/> 
			<?php for ($i = 2010, $year = date("Y"), $month = date("m"); $i <= $year ; $i++) : ?>
				<?php $j = $i-1999 /*default value is WS when current month is januar until may*/?>
				<option value="<?php echo "WS ".$i."/".$j; ?>" <?php if($i == $year-1 && $month <= 5){echo "selected";}?>><?php echo "WS ".$i."/".$j; ?></option> 
				<option value="<?php echo "SS ".($i+1); ?>" <?php if(($i+1) == $year && $month > 5){echo "selected";}?>><?php echo "SS ".($i+1); ?></option>	
			<?php endfor; ?>
		</select> (das Jahr, in dem du an dem WPB teilgenommen hast)</p>
      <p>Position:
        <select name="position">
        <?php
          $comment_set = find_comments_for_course($current_course["id"]);
          $comment_count = mysqli_num_rows($comment_set);
          for($count=1; $count <= ($comment_count + 1); $count++) {
            echo "<option value=\"{$count}\">{$count}</option>";
          }
        ?>
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" /> No
        &nbsp;
        <input type="radio" name="visible" value="1" CHECKED/> Yes
      </p>
      <p>Content:<br />
        <textarea name="content" rows="20" cols="80"></textarea>
      </p>
      <input type="submit" name="submit" value="Create comment" />
    </form>
    <br />
    <a href="manage_content.php?course=<?php echo urlencode($current_course["id"]); ?>">Cancel</a>
  </div>  
</div>

<?php include("../includes/layouts/footer.php"); ?>
