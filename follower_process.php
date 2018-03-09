<?php 
include('conn_config.php');
include('acc_ct.php');

$proc = $_GET['proc'];
$task_ref_id = $_GET['task_ref_id'];
$task_follower = $_GET['follower_username_list'];

if($proc=="add"){
	$sqlas = "UPDATE task SET task_follower = '$task_follower' WHERE rec_id = '$task_ref_id' ";	
	$rsas = @mysqli_query($dbh,$sqlas);
}

?> 