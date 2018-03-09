<?php
include('conn_config.php');

$email = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['email'])));
$first_name = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['firstname'])));
$last_name = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['lastname'])));
$Contact = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['Contact'])));
$Company = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['Company'])));
$Password = mysqli_real_escape_string($dbh,strip_tags(trim($_POST['passwd'])));
$salt = genSalt();
$usr_pwd = genHash($Password, $salt);

$tb_name = "usr_register";
$role_code = "N0001";
$add_date = date('Y-m-d');
$add_time = date('H:i:s');

$sql = "INSERT INTO $tb_name(emp_name, emp_first_name, emp_last_name, role_code, usr_pwd, usr_pwd_salt, usr_email, usr_contact, company_name, usr_status, add_date, add_time) 
VALUES ('$first_name' '$last_name', '$first_name', '$last_name', '$role_code', '$usr_pwd', '$salt', '$email', '$Contact', '$Company', 'R', '$add_date', '$add_time')";

$result = @mysqli_query($dbh,$sql);   

if($result)
{
	echo "<script type='text/javascript'>alert('Thank you for registering! An email has been send to your mail with details on how to activate your account. Please check your email!');</script>";
	
	echo "<script>window.top.location ='index.php';</script>";
}else
{
	
}

function genHash($pass_word, $salt) {
    return hash("sha256", $pass_word . $salt);
}

function genSalt() {
    $intermediateSalt = md5(uniqid(rand(), true));
	return $intermediateSalt;
}
?>