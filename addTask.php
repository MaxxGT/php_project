<?php
include('conn_config.php');

$create_task = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['create_task'])));
$task_userCreate = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['task_userCreate'])));
$network_code = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['task_network_code'])));
$task_status_code = "O0001";


$tb_name = "task";
$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sql = "INSERT INTO $tb_name(network_code, task_name, task_status_code, task_owner, task_visible_to, add_date, add_time) 
VALUES ('$network_code', '$create_task', '$task_status_code', '$task_userCreate', '$task_userCreate', '$add_date', '$add_time')";

$result = @mysqli_query($dbh,$sql);   

if($result)
{
	echo "<script type='text/javascript'>alert('Thank you for registering! An email has been send to your mail with details on how to activate your account. Please check your email!');</script>";
	
	echo "<script>window.top.location ='main.php';</script>";
}else
{
	
}
?>