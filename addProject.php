<?php
include('conn_config.php');

$project_name = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['project'])));
$network_code = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network_code'])));
$project_owner = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['project_owner'])));

$tb_name = "project";
$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sql = "INSERT INTO $tb_name(network_code, project_name, project_visible_to, project_owner, add_date, add_time) 
VALUES ('$network_code', '$project_name', '$project_owner', '$project_owner', '$add_date', '$add_time')";

$result = @mysqli_query($dbh,$sql);   

if($result)
{
	echo "<script type='text/javascript'>alert('Network Add success, thank you!');</script>";
	echo "<script>window.top.location ='main.php';</script>";
}else
{
	
}
?>