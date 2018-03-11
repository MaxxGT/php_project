<?php
include('conn_config.php');

$network_name = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network'])));
$network_admin = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network_admin'])));

$tb_name = "network";
$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sql = "INSERT INTO $tb_name(network_name, network_admin, network_member, add_date, add_time) 
VALUES ('$network_name', '$network_admin', '$network_admin', '$add_date', '$add_time')";

$result = @mysqli_query($dbh,$sql);   

if($result)
{
	echo "<script type='text/javascript'>alert('Network Add success, thank you!');</script>";
	echo "<script>window.top.location ='main.php';</script>";
}else
{
	
}
?>