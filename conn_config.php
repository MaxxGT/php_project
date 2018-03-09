<?php
//error_reporting(0);

$dbh = @mysqli_connect('localhost', 'root' , '' , 'nt_etms');

// Check connection
if (mysqli_connect_errno()){
  echo "Error: Failed to connect to Database: " . mysqli_connect_error();
}

?>