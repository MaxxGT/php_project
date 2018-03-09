<?php 
//Prevent Brute force attacks
function login_attempt_chk($user_name,$pass_word){
$tblname = "ath_login_att";
$tblname2 = "user";
$add_date = date('Y-m-d');
$add_time = date('H:i:s');
$add_by = $user_name;
$upd_date = date('Y-m-d');
$upd_time = date('H:i:s');
$upd_by = $user_name;

$sqlchk = "Select login_attempt FROM $tblname WHERE identify_name = '$user_name' LIMIT 1";  
$rschk = @mysql_query($sqlchk);
$crow = @mysql_num_rows($rschk);   
$rowchk = @mysql_fetch_array($rschk);

        $login_attempt = $rowchk['login_attempt'];   
	
	if(($user_name!="hblai")&&($user_name!="ongchin")){
		if($crow>0){
		   if($login_attempt>=5){
			  $sqlua = "UPDATE $tblname2 SET usr_status = 'S', upd_date = '$upd_date', upd_time = '$upd_time', upd_by = '$upd_by' WHERE usr_name = '$user_name' "; 
			  $rsua = @mysql_query($sqlua);
			  echo "<script>window.top.location ='acc_disabled.php?uid=$user_name';</script>";   
		   }else{
			  $new_login_attempt = $login_attempt+1;
			  $sqlla = "UPDATE $tblname SET identify_id = '$pass_word', login_attempt = '$new_login_attempt' , upd_date = '$upd_date', upd_time = '$upd_time', upd_by = '$upd_by' WHERE identify_name = '$user_name' ";
			  $rsla = @mysql_query($sqlla); 
		   }
		}else{
			  //insert login attempt into table ath_login_att
			  $sqlla = "INSERT INTO $tblname (identify_name,identify_id,login_attempt,add_date,add_time,add_by)VALUES ('$user_name','$pass_word','1','$add_date','$add_time','$add_by')"; 
			  $rsla = @mysql_query($sqlla);	   
		}
	}
}



function genHashWithSalt($pass_word) {
    $intermediateSalt = md5(uniqid(rand(), true));
    $salt = substr($intermediateSalt, 0, MAX_LENGTH);
    return hash("sha256", $password . $salt);
	
	function mysalt($salt){
	     return $salt;
	}

}

?>