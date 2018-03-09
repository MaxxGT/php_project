<?php 
session_start(); 
$_SESSION['network_code'] = $_GET['rel'];
echo "<script>window.top.location ='main.php';</script>";

?>