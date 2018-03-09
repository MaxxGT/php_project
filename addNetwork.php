<?php
include('conn_config.php');

$create_task = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['create_task'])));
$task_userCreate = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['task_userCreate'])));
$network_code = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['task_network_code'])));

$tb_name = "network";
$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sql = "INSERT INTO $tb_name(network_name, add_date, add_time) 
VALUES ('$network_name', '$add_date', '$add_time')";

$result = @mysqli_query($dbh,$sql);   

if($result)
{
	echo "<script type='text/javascript'>alert('Network Add success, thank you!');</script>";
	echo "<script>window.top.location ='main.php';</script>";
}else
{
	
}
?>