<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php include_once("../includes/analyticstracking.php") ?>

<?php
						echo "check";
						
						$file = file_get_contents('http://wpbgutachter.xyz/site_statistics.php');
                       echo substr($file,-12);
                         
                        echo " check2";

					?>