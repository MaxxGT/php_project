<?php
include('conn_config.php');
require 'phpmailer/PHPMailerAutoload.php';

$c_time = date('H:i A');
$sqltc = "Select task_name, task_due_date,task_due_time,task_owner FROM task WHERE task_due_date = curdate() 
               AND task_due_time = '$c_time' AND task_status_code !='C0001' ";
$rstc = @mysqli_query($dbh,$sqltc);
while($rowtc = @mysqli_fetch_array($rstc)){
	
	//$curr_date = date('Y-m-d');
	//$curr_time = date('H:i:s');
	
	$task_name = $rowtc['task_name'];
	$task_due_date = $rowtc['task_due_date'];
	$task_due_date_disp = date("d F Y",strtotime($task_due_date));
	$task_due_time = $rowtc['task_due_time'];
	$task_owner = $rowtc['task_owner'];
	
	$sqlto = "Select emp_first_name,usr_email FROM usr_user WHERE usr_name = '$task_owner' ";
	$rsto = @mysqli_query($dbh,$sqlto);
	$rowto = @mysqli_fetch_array($rsto);
	
		$task_owner_name = $rowto['emp_first_name']; 
		$task_owner_email = $rowto['usr_email'];

	$mail = new PHPMailer;

	$mail->isSMTP();
	$mail->Host = 'smtp.gmail.com';
	$mail->SMTPAuth = true;
	$mail->Username = 'weihan0914@gmail.com';
	$mail->Password = '13550000';
	$mail->SMTPSecure = 'tls';

	$mail->From = 'weihan0914@gmail.com';
	$mail->FromName = 'ACMTask';
	$mail->addAddress($task_owner_email);

	$mail->isHTML(true);

	$mail->Subject = 'Deadline reached for task: '.$task_name;
	$mail->Body    = '<table>
						<tr>
						  <td>Hi '.$task_owner_name.',</td>
						</tr>
						<tr>
						  <td><BR><BR>The deadline for this task is set to '.$task_due_date_disp.', '.$task_due_time.' </td>
						</tr>
						<tr>
						  <td><BR><a href="http://www.google.com.my">Click here to view the task.</a> </td>
						</tr>
						<tr>
						  <td><BR><BR><i><font style="6px;">This email has been sent to weihan0914@gmail.com . If you dont want to receive these emails from ACMTask in the future you can edit your notification preferences. </font></i></td>
						</tr>
					  </table>';

	if(!$mail->send()) {
		//echo 'Message could not be sent.';
		//echo 'Mailer Error: ' . $mail->ErrorInfo;
		echo "<script>window.close();</script>";
	 } else {
		//echo 'Message has been sent';
		echo "<script>window.close();</script>";
	}

}
?>