<?php 
require_once ('../includes/phpgraphlib/phpgraphlib.php'); 
require_once ('../includes/functions.php'); 
require_once ('../includes/db_connection.php');

$Safe_Fach =  mysqli_real_escape_string($connection, $_GET["Fach"]);

$query  = "SELECT durchschnitt, Semester";
$query .= " FROM exam_grades";
$query .= " Where Fach='{$Safe_Fach}'";
$graph_set = mysqli_query($connection, $query);
confirm_query($graph_set);

$data = array();

$plot= new PHPGraphLib(800,300);
while($graph = mysqli_fetch_assoc($graph_set)){
	$data_point = array($graph["Semester"] => $graph["durchschnitt"]);
	$data = array_merge($data,$data_point);
//print_r ($graph);
}
//print_r ($graph_set);
//print_r ($data);
$plot->addData($data);

$plot->setTitle("Durchschnitt");
$plot->setTextColor("blue");
$plot->setBars(false);
$plot->setLine(true);
$plot->setDataPoints(true);
$plot->setXValuesHorizontal(true);
$plot->setupYAxis("12");
$plot->setDataValues(true);

$plot->createGraph();

	
if (isset($connection)) { mysqli_close($connection); }
?>