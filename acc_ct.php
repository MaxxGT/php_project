<?php 
session_start();
extract($_SESSION);

error_reporting(0);
ini_set('display_errors', 0);

//$_SESSION['usr_sS'] = "hblai";
//$_SESSION['usr_right'] = array('1','2','44','3','72');;

if($_SESSION['sys_Code']!='ACMTASK') {
   header('Location: index.php');      
}

//$_SESSION['site_usr']



?>