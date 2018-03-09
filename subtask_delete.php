<?php 
include('conn_config.php');
include('acc_ct.php');

$proc = $_GET['proc'];
$subtask_ref_id = $_GET['subtask_ref_id'];

if($proc=="delete"){
	echo $sqldc = "UPDATE task_subtask SET deleted_flag = 'Y' WHERE rec_id = '$subtask_ref_id' ";
	$rsdc = @mysqli_query($dbh,$sqldc);		
}

//mysqli_query($dbh,"Insert into task_comment(task_ref_id,task_comment_desc,add_date,add_time) values ('$q','$content','$add_date','$add_time')");
?>