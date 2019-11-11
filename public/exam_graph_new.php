<?php 
require_once ('../includes/phpgraphlib/phpgraphlib.php'); 
require_once ('../includes/functions.php'); 
require_once ('../includes/db_connection.php');

$Safe_Fach =  mysqli_real_escape_string($connection, $_GET["Fach"]);
$Safe_Semester =  mysqli_real_escape_string($connection, $_GET["Semester"]);

$query  = "SELECT *";
$query .= " FROM exam_grades";
$query .= " Where Fach='{$Safe_Fach}' AND Semester='{$Safe_Semester}'";
$graph_set = mysqli_query($connection, $query);
confirm_query($graph_set);
$graph = mysqli_fetch_assoc($graph_set);


$plot= new PHPGraphLib(800,300, $Safe_Fach."_".$Safe_Semester.".png");

if($graph["Typ"]=="Fachblock"){
	$sehrgut = "Sehr Gut";
	$gut = "Gut";
	$befriedigend = "Befriedigend";
	$ausreichend = "ausreichend";
	$nichtausreichend = "Nicht Ausreichend";
$data = array($sehrgut=>$graph["sehr_gut_4_punkte"], $gut=>$graph["gut_3_punkte"], $befriedigend=>$graph["befriedigend_2_punkte"], $ausreichend=>$graph["ausreichend_1_punkt"], $nichtausreichend=>$graph["nicht_ausreichend_0_punkte"]);
	
} else if($graph["Typ"]=="Querschnittsblock") { 
	$sehrgut = "4 Punkte";
	$gut = "3 Punkte";
	$befriedigend = "2 Punkte";
	$ausreichend = "1 Punkt";
	$nichtausreichend = "0 Punkte";
$data = array($nichtausreichend=>$graph["nicht_ausreichend_0_punkte"], $ausreichend=>$graph["ausreichend_1_punkt"], $befriedigend=>$graph["befriedigend_2_punkte"], $gut=>$graph["gut_3_punkte"], $sehrgut=>$graph["sehr_gut_4_punkte"]);
	
}
//$data = array($sehrgut=>$graph["sehr_gut_4_punkte"], $gut=>$graph["gut_3_punkte"], $befriedigend=>$graph["befriedigend_2_punkte"], $ausreichend=>$graph["ausreichend_1_punkt"], $nichtausreichend=>$graph["nicht_ausreichend_0_punkte"]);
if($graph["nicht_erschienen"]) {
	$nichterschienen = "Nicht Erschienen";
	$add_column = array($nichterschienen => $graph["nicht_erschienen"]);
	$data = array_merge($data, $add_column);

}


$plot->addData($data);

$title = "20".$graph["Semester"];
$title = str_replace("S"," Sommersemester",$title);
$title = str_replace("W"," Wintersemester",$title);
$plot->setTitle($title);
$plot->setTextColor("blue");
$plot->setBarColor("green");
$plot->setXValuesHorizontal(true);
$plot->setDataValues(true);

$plot->createGraph();

	
if (isset($connection)) { mysqli_close($connection); }
?>