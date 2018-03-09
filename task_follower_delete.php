<?php 
include('conn_config.php');
include('acc_ct.php');

$rec_id = $_GET['rec_id'];
$task_ref_id = $_GET['task_ref_id'];

//Check follower username
$sqlcn = "Select usr_name FROM usr_user WHERE rec_id = '$rec_id' LIMIT 1";
$rscn = @mysql_query($dbh,$sqlcn);
$rowcn = @mysql_fetch_array($rscn);

	$usr_name = $rowcn['usr_name'];
	

//Select previous follower list
$sqlcn1 = "Select task_follower FROM task WHERE rec_id = '$task_ref_id' LIMIT 1";
$rscn1 = @mysql_query($dbh,$sqlcn1);
$rowcn1 = @mysql_fetch_array($rscn1);

	$task_follower = $rowcn1['task_follower'];
	$task_follower_arr = explode(",",$task_follower);
	$to_remove = array($usr_name);
	$new_task_follower_arr = array_diff($task_follower_arr, $to_remove);
	$new_task_follower_str = implode(",",$new_task_follower_arr);
	
	
$sqldc = "UPDATE task SET task_follower = '$new_task_follower_str' WHERE rec_id = '$task_ref_id' ";
$rsdc = @mysqli_query($dbh,$sqldc);


//mysqli_query($dbh,"Insert into task_comment(task_ref_id,task_comment_desc,add_date,add_time) values ('$q','$content','$add_date','$add_time')");
?>

<script>alert('<?=$sqldc; ?>');</script>