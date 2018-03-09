<?php 
include('conn_config.php');
include('acc_ct.php');

$proc = $_POST['proc'];
$task_ref_id = $_POST['task_ref_id'];
$subtask_name = $_POST['subtask_name'];

$add_date = date('Y-m-d');
$add_time = date('H:i:s');
$add_by = $_SESSION['usr_sS'];
$upd_date = date('Y-m-d');
$upd_time = date('H:i:s');
$upd_by = $_SESSION['usr_sS'];


if($proc=="add"){
	echo $sqlas = "INSERT INTO task_subtask (task_ref_id, subtask_name, subtask_desc, add_date, add_time, add_by)
	          VALUES('$task_ref_id','$subtask_name','$subtask_desc','$add_date','$add_time','$add_by')";	
	$rsas = @mysqli_query($dbh,$sqlas);
}

?>