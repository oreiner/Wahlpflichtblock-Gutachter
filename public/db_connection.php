<?php
	define("DB_SERVER", "localhost");
	define("DB_USER", "id1029154_main_admin");
	define("DB_PASS", "secretpassword");
	define("DB_NAME", "id1029154_gutachten");

  // 1. Create a database connection
  $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
  // Test if connection succeeded
  if(mysqli_connect_errno()) {
    	die ("Es gibt momentan ein Problem mit dem Server. Versuch es später erneut.");
/*die("Database connection failed: " . 
         mysqli_connect_error() . 
         " (" . mysqli_connect_errno() . ")"
    );*/
  }
  //super important: unsures the strings with Umlaut display and get saved correctly
  mysqli_query($connection, "SET NAMES 'utf8'");
?>