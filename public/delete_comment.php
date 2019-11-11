<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>

<?php
  $current_comment = find_comment_by_id($_GET["comment"]);
  if (!$current_comment) {
    // comment ID was missing or invalid or 
    // comment couldn't be found in database
    redirect_to("manage_content.php");
  }
  
  $id = $current_comment["id"];
  $query = "DELETE FROM comments WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "comment deleted.";
    redirect_to("manage_content.php");
  } else {
    // Failure
    $_SESSION["message"] = "comment deletion failed.";
    redirect_to("manage_content.php?comment={$id}");
  }
  
?>
