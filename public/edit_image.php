<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation_functions.php"); ?>

<?php find_selected_comment(); ?>

<?php
  // Unlike new_comment.php, we don't need a course_id to be sent
  // We already have it stored in comments.course_id.
  if (!$current_comment) {
    // comment ID was missing or invalid or 
    // comment couldn't be found in database
    redirect_to("manage_content.php");
  }
?>

<?php
if (isset($_POST['submit'])) {
  // Process the form
  
  $id = $current_comment["id"];
  $user_name = mysql_prep($_POST["user_name"]);
  $position = (int) $_POST["position"];
  $visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);

  // validations
  $required_fields = array("user_name", "position", "visible", "content");
  validate_presences($required_fields);
  
  $fields_with_max_lengths = array("user_name" => 30);
  validate_max_lengths($fields_with_max_lengths);
  
  if (empty($errors)) {
    
    // Perform Update

    $query  = "UPDATE comments SET ";
    $query .= "user_name = '{$user_name}', ";
    $query .= "position = {$position}, ";
    $query .= "visible = {$visible}, ";
    $query .= "content = '{$content}' ";
    $query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

    if ($result && mysqli_affected_rows($connection) == 1) {
      // Success
      $_SESSION["message"] = "comment updated.";
      redirect_to("manage_content.php?comment={$id}");
    } else {
      // Failure
      $_SESSION["message"] = "comment update failed.";
    }
  
  }
} else {
  // This is probably a GET request
  
} // end: if (isset($_POST['submit']))

?>

<?php include("../includes/layouts/header.php"); ?>

<div id="main">
  <div id="navigation">
    <?php echo navigation($current_subject, $current_course, $current_comment); ?>
	<br />
	<a href="new_course.php">+ Add a course</a>
	<br />
	<?php echo image_navigation($current_exam_subject, $current_image); ?>
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php echo form_errors($errors); ?>
    
    <h2>Edit comment: <?php echo htmlentities($current_comment["user_name"]); ?></h2>
    <form action="edit_comment.php?comment=<?php echo urlencode($current_comment["id"]); ?>" method="post">
      <p>User name:
        <input type="text" name="user_name" value="<?php echo htmlentities($current_comment["user_name"]); ?>" />
      </p>
      <p>Position:
        <select name="position">
        <?php
          $comment_set = find_comments_for_course($current_comment["course_id"]);
          $comment_count = mysqli_num_rows($comment_set);
          for($count=1; $count <= $comment_count; $count++) {
            echo "<option value=\"{$count}\"";
            if ($current_comment["position"] == $count) {
              echo " selected";
            }
            echo ">{$count}</option>";
          }
        ?>
        </select>
      </p>
      <p>Visible:
        <input type="radio" name="visible" value="0" <?php if ($current_comment["visible"] == 0) { echo "checked"; } ?> /> No
        &nbsp;
        <input type="radio" name="visible" value="1" <?php if ($current_comment["visible"] == 1) { echo "checked"; } ?>/> Yes
      </p>
      <p>Content:<br />
        <textarea name="content" rows="20" cols="80"><?php echo htmlentities($current_comment["content"]); ?></textarea>
      </p>
      <input type="submit" name="submit" value="Edit comment" />
    </form>
    <br />
    <a href="manage_content.php?comment=<?php echo urlencode($current_comment["id"]); ?>">Cancel</a>
    &nbsp;
    &nbsp;
    <a href="delete_comment.php?comment=<?php echo urlencode($current_comment["id"]); ?>" onclick="return confirm('Are you sure?');">Delete comment</a>
    
  </div>
</div>

<?php include("../includes/layouts/footer.php"); ?>
