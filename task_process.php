 <?php
include('conn_config.php');
include('acc_ct.php');

$q = intval($_POST['q']);
$add_date = date('Y-m-d');
$add_time = date('H:i:s');
$add_by = $_SESSION['usr_sS'];

if(isSet($_POST['newmsg'])){
	$content = $_POST['newmsg'];
	@mysqli_query($dbh,"Insert into task_comment(task_ref_id,task_comment_desc,add_date,add_time,add_by) values ('$q','$content','$add_date','$add_time','$add_by')");
	
	$task_comment_ref_id = mysqli_insert_id($dbh);
	
	if(isset($_FILES["comment_attachment"]) && $_FILES["comment_attachment"]["error"]== UPLOAD_ERR_OK)
	{
		############ Edit settings ##############
		$UploadDirectory	= 'upload/'; //specify upload directory ends with / (slash)
		##########################################
		
		/*
		Note : You will run into errors or blank page if "memory_limit" or "upload_max_filesize" is set to low in "php.ini". 
		Open "php.ini" file, and search for "memory_limit" or "upload_max_filesize" limit 
		and set them adequately, also check "post_max_size".
		*/
		
		//check if this is an ajax request
		if (!isset($_SERVER['HTTP_X_REQUESTED_WITH'])){
			die();
		}
		
		
		//Is file size is less than allowed size.
		if ($_FILES["comment_attachment"]["size"] > 5242880) {
			die("File size is too big!");
		}
		
		//allowed file type Server side check
		switch(strtolower($_FILES['comment_attachment']['type']))
			{
				//allowed file types
				case 'image/png': 
				case 'image/gif': 
				case 'image/jpeg': 
				case 'image/pjpeg':
				case 'text/plain':
				case 'text/html': //html file
				case 'application/x-zip-compressed':
				case 'application/pdf':
				case 'application/msword':
				case 'application/vnd.ms-excel':
				case 'video/mp4':
					break;
				default:
					die('Unsupported File!'); //output error
		}
		
		$File_Name          = strtolower($_FILES['comment_attachment']['name']);
		$File_Ext           = substr($File_Name, strrpos($File_Name, '.')); //get file extention
		$Random_Number      = rand(0, 9999999999); //Random number to be added to name.
		$NewFileName 		= $Random_Number.$File_Ext; //new file name
		$comment_attachment_path = "upload/".$NewFileName;
		
		if(move_uploaded_file($_FILES['comment_attachment']['tmp_name'], $UploadDirectory.$NewFileName )){
			$sqlip = "INSERT INTO task_comment_attachment (task_comment_ref_id,attachment_stored_path,attachment_file_format,add_date,add_time,add_by) 
						   VALUES ('$task_comment_ref_id','$comment_attachment_path','$File_Ext','$add_date','$add_time','$add_by')";
			$rsip = @mysqli_query($dbh,$sqlip);
			die('Success! File Uploaded.');
		}else{
			die('error uploading File!');
		}
		

		
	}
	else
	{
		die('Something wrong with upload! Is "upload_max_filesize" set correctly?');
	}
	
}
?>