<?php 
include('conn_config.php');
include('acc_ct.php');

$rec_id = $_GET['rec_id'];

$sqldc = "UPDATE task_comment SET deleted_flag = 'Y' WHERE rec_id = '$rec_id' ";
$rsdc = @mysqli_query($dbh,$sqldc);

//mysqli_query($dbh,"Insert into task_comment(task_ref_id,task_comment_desc,add_date,add_time) values ('$q','$content','$add_date','$add_time')");
?>