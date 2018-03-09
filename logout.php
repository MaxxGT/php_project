<?php
include('acc_ct.php');
include('conn_config.php');
require_once('timezone_inc.php');

session_start();
$add_by = $_SESSION['usr_sS'];
$tblname = "ath_chk";
// Destroying All Sessions
session_destroy(); 
//Destroy cookie
if (isset($_COOKIE['chk_conn_klfid'])) {
	$cookie_name = "chk_conn_klfid";
	$cookie_value = "";
	setcookie($cookie_name, $cookie_value, 1, "localhost"); 
}
$screen_type = "Logout";
$audit_right_code = "18";
$act_t = "O";       
$site_code = $rowcl['usr_site'];
$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sqllr = "UPDATE $tblname SET logged_in = '', usr_cookie='' WHERE usr_name = '$add_by' ";  
$rslr = @mysql_query($sqllr);	

//audit_log($screen_type,$audit_right_code,$act_t,'','','','','',$site_code,$add_date,$add_time,$add_by);	
header("Location: index.php"); // Redirecting to Home Page
?>