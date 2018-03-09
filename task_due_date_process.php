<?php 
include('conn_config.php');
include('acc_ct.php');

$proc = $_POST['proc'];
$task_ref_id = $_POST['task_ref_id'];
$task_due_date = $_POST['task_due_date'];

if($proc=="add"){

}else if($proc=="update"){
	$sqlas = "UPDATE task SET task_due_date = '$task_due_date' 
	          WHERE rec_id = '$task_ref_id' ";	
	$rsas = @mysqli_query($dbh,$sqlas);
}

?>