<?php 
include('conn_config.php');
include('acc_ct.php');

$proc = $_GET['proc'];
$task_ref_id = $_GET['task_ref_id'];
$task_assignee = $_GET['assignee_username_list'];

if($proc=="add"){
	$sqlas = "UPDATE task SET task_assignee = '$task_assignee' WHERE rec_id = '$task_ref_id' ";	
	$rsas = @mysqli_query($dbh,$sqlas);
}

?> 