<?php
include('conn_config.php');
$tb_name = "network";
$i = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network'])));
$i = $i[0].'0001';

$sql_network = "SELECT network_code FROM $tb_name WHERE network_code = '$i'";
$result = @mysqli_query($dbh,$sql_network);
$i_totl = @mysqli_num_rows($result);

if($i_totl =='0')
{
	$i = $i[0].'0001';
}else
{
	$i = $i[0].'000'.++$i_totl;
}

$network_code = $i;
$network_name = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network'])));
$network_short_name = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network_short_name'])));
$network_admin = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['network_admin'])));


$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sql = "INSERT INTO $tb_name(network_code, network_name, network_short_name, network_admin, network_member, add_date, add_time) 
VALUES ('$network_code', '$network_name', '$network_short_name', '$network_admin', '$network_admin', '$add_date', '$add_time')";

$result = @mysqli_query($dbh,$sql);   

if($result)
{
	echo "<script type='text/javascript'>alert('Network has been addeed successful, thank you!');</script>";
	echo "<script>window.top.location ='main.php';</script>";
}else
{
	
}
?>