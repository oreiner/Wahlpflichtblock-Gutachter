<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include_once("../includes/analyticstracking.php") ?>

<?php 
print_r( count_courses() ); 
echo "/";
print_r( count_comments() ); 
echo "/";
print_r( count_grades() ); 
?>