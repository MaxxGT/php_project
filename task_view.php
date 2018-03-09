<?php 
include('conn_config.php');
include('acc_ct.php');

$q = intval($_GET['q']);
$logged_in_usr = $_SESSION['usr_sS'];


//logged in
$sqls = "Select * FROM usr_user WHERE usr_name = '$logged_in_usr'";
$rss = @mysqli_query($dbh,$sqls);
$rows = @mysqli_fetch_array($rss);

	$emp_first_name = $rows['emp_first_name'];	

$sql = "SELECT * FROM task WHERE rec_id = '".$q."'";
$result = @mysqli_query($dbh,$sql);
$row = @mysqli_fetch_array($result);

//Task assignee
$sqltas = "Select task_follower, task_assignee,task_due_date,task_due_time,task_label_code,task_visible_to FROM task WHERE rec_id = '$q' LIMIT 1";
$rstas = @mysqli_query($dbh,$sqltas);
$rowtas = @mysqli_fetch_array($rstas);

	$task_assignee = $rowtas['task_assignee'];
	$task_follower = $rowtas['task_follower'];
	$task_visible_to = $rowtas['task_visible_to'];
	$task_due_date = $rowtas['task_due_date'];
	$task_due_time = $rowtas['task_due_time'];
	$task_label_code = $rowtas['task_label_code'];
	
	if($task_visible_to){
		$task_visible_to_arr = explode(',',$task_visible_to);
		$c_task_visible_to_arr = count($task_visible_to_arr);
		$task_visible_to_str = implode("','",$task_visible_to_arr);

		$sqltv = "Select emp_first_name FROM usr_user WHERE usr_name IN ('$task_visible_to_str')";
		$rstv = @mysqli_query($dbh,$sqltv);
		while($rowtv = @mysqli_fetch_array($rstv)){		
			$task_visible_to_name_arr[] = $rowtv['emp_first_name'];		
		}
		$task_visible_to_name_str = implode(",",$task_visible_to_name_arr);				
	}else{
		$task_visible_to_name_str = "";
	}
	
	if($task_assignee){
		$task_assignee_arr = explode(',',$task_assignee);
		$c_task_assignee_arr = count($task_assignee_arr);
		$task_assignee_str = implode("','",$task_assignee_arr);

		$sqltan = "Select emp_first_name FROM usr_user WHERE usr_name IN ('$task_assignee_str')";
		$rstan = @mysqli_query($dbh,$sqltan);
		while($rowtan = @mysqli_fetch_array($rstan)){		
			$task_assignee_name_arr[] = $rowtan['emp_first_name'];		
		}
		$task_assignee_name_str = implode(",",$task_assignee_name_arr);		
	}else{
		$task_assignee_name_str = "";
	}
	
	if($task_follower){
		$task_follower_arr = explode(',',$task_follower);
		$c_task_follower_arr = count($task_follower_arr);
		$task_follower_str = implode("','",$task_follower_arr);

		$sqltan = "Select rec_id,emp_first_name FROM usr_user WHERE usr_name IN ('$task_follower_str')";
		$rstan = @mysqli_query($dbh,$sqltan);
		while($rowtan = @mysqli_fetch_array($rstan)){		
			//$task_follower_name_arr[] = $rowtan['emp_first_name'];	
            $task_follower_name_arr[] = "<span id='delete_follower' fid='".$rowtan['rec_id']."' title='Delete Follower ".$rowtan['rec_id']."'> ".$rowtan['emp_first_name']." <i class='fa fa-times iconred fa-lg'></i></span>";			
		}
		$task_follower_name_str = implode(",",$task_follower_name_arr);		
	}else{
		$task_follower_name_str = "";
	}
	
	if($task_label_code){
		$task_label_code_arr = explode(',',$task_label_code);
		$c_task_label_code_arr = count($task_label_code_arr);
		$task_label_code_str = implode("','",$task_label_code_arr);		
		
		$sqltlb = "Select task_label_desc FROM task_label WHERE task_label_code IN ('$task_label_code_str')";
		$rstlb = @mysqli_query($dbh,$sqltlb);
		while($rowtlb = @mysqli_fetch_array($rstlb)){		
			$task_label_desc_arr[] = $rowtlb['task_label_desc'];		
		}
		$task_label_desc_str = implode(",",$task_label_desc_arr);
	}else{		
		$task_label_desc_str = "";
	}

	


//function here
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
?>


<link href="css/jquery-popover-0.0.3.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="css/bootstrap-datepicker3.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css">
<script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/js/bootstrap-timepicker.min.js"></script>
<script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
<style>
.display-info{
    height: 40px;	
}
</style>


<script>
$(document).ready(function(){
    $("form#myform").submit(function(event) {
		
		//disable the default form submission
		event.preventDefault();

		//grab all form data  
		var formData = new FormData($(this)[0]);

		$.ajax({
		url: 'task_process.php',
		type: 'POST',
		data: formData,
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function (returndata) {
				alert('Post success.');
				$('div#content3').load('task_success.php?q=<?=$q; ?>');
				$('#newmsg').val('');
				$('div#task').load('task.php?uid=<?=$_SESSION['usr_sS']; ?>');
		}
		});		 
		  return false;		  
    });
});



$(document).ready(function(){
    $("#subtaskform").submit(function(event) {
		
		//disable the default form submission
		event.preventDefault();

		//grab all form data  
		var formData = new FormData($(this)[0]);

		$.ajax({
		url: 'subtask_process.php',
		type: 'POST',
		data: formData,
		async: false,
		cache: false,
		contentType: false,
		processData: false,
		success: function (returndata) {
				alert('Subtask saved.');
				$('#subtask_posted').load('subtask_posted.php?task_ref_id=<?=$q; ?>');
		}
		});		 
		  return false;		  
    });
});

$(document).ready(function(){
    $("#delete_comment").click(function() {
		var rec_id = $('#delete_comment').attr("rec_id");
		var task_ref_id = <?=$q; ?>;
		var info = 'rec_id=' + rec_id + '&task_ref_id=' + task_ref_id;
			$.ajax({
				type : "GET",
				url : "task_delete.php", //URL to the delete php script
				data : info,
				success : function() {
					$('div#content3').load('task_success.php?q=<?=$q; ?>');
					$('div#task').load('task.php?uid=<?=$_SESSION['usr_sS']; ?>');
				}
			});
	});
	
    $("#delete_follower").click(function() {
		var fid = $('#delete_follower').attr("fid");
		var task_ref_id = <?=$q; ?>;
		var info = 'rec_id=' + fid + '&task_ref_id=' + task_ref_id;
		
        alert(info);
			$.ajax({
				type : "GET",
				url : "task_follower_delete.php", //URL to the delete php script
				data : info,
				success : function() {
					$('div#content3').load('task_success.php?q=<?=$q; ?>');
					$('div#task').load('task.php?uid=<?=$_SESSION['usr_sS']; ?>');
				}
			});
	});

	/*
    $("#delete_subtask").click(function() {
		var subtask_ref_id = $('#delete_subtask').attr("rec_id");
		var task_ref_id = <?=$q; ?>;
		var subtask_info = 'proc=delete&subtask_ref_id=' + subtask_ref_id + '&task_ref_id=' + task_ref_id;
		
		alert('12');
			$.ajax({
				type : "GET",
				url : "subtask_delete.php", //URL to the delete php script
				data : subtask_info,
				success : function() {
					$('#subtask_posted').load('subtask_posted.php?task_ref_id=<?=$task_ref_id; ?>');
				}
			});
	});
	*/

	
	$('#assignee_sel').change( function() {
		//.val, get value frm divs
		//option:selected, get value frm dropdown
		//.attr, get value based on attribute
		var assignee_list = $('#assignee_username_list').val();
		var assignee_name_list = $('#assignee_name_list').val();
  	    var assignee_sel = $("#assignee_sel").val();
		var assignee_name_sel = $('#assignee_sel option:selected').attr('assignee_name');
	    
        if(assignee_list){		
		  if(assignee_list.indexOf(assignee_sel) != -1){
			var new_assignees = assignee_list; 
			var new_assignee_name_list = assignee_name_list;
		  }else{
			if(assignee_sel){
				var new_assignees = assignee_list+','+assignee_sel; 
				var new_assignee_name_list = assignee_name_list+','+assignee_name_sel;
			}else{
				var new_assignees = assignee_list; 
				var new_assignee_name_list = assignee_name_list;	
			}
		  }
		}else{ 
		  var new_assignees = assignee_sel; 
		  var new_assignee_name_list = assignee_name_sel;
		}
		
		var task_ref_id = <?=$q; ?>;
		var assignee_info = 'proc=add'+'&task_ref_id='+task_ref_id+'&assignee_username_list='+new_assignees;
		
		var new_assignee_name_list_arr = new_assignee_name_list.split(','); //Split a string into an array of strings
		for(var i=0;i<new_assignee_name_list_arr.length;i++){
			var new_assignee_name_list__link_arr = '<a href="#">'+new_assignee_name_list_arr[i]+'<i class="icon-remove-circle"></i></a> ';
		}
		var new_assignee_name_list__link_str = new_assignee_name_list__link_arr.toString();
		//alert(new_assignee_name_list__link_str);
        $.ajax({
				type : "GET",
				url : "assignee_process.php", //URL to the save assignee php script
				data : assignee_info,
				success : function() {
					$('#assignee').html(new_assignee_name_list);
					$('#assignee_list').html(new_assignee_name_list);
					$('#assignee_name_list').val(new_assignee_name_list);
					$('#assignee_username_list').val(new_assignees);
				}
		});
	});
	
	
	$('#follower_sel').change( function() {
		//.val, get value frm divs
		//option:selected, get value frm dropdown
		//.attr, get value based on attribute
		var follower_list = $('#follower_username_list').val();
		var follower_name_list = $('#follower_name_list').val();
  	    var follower_sel = $("#follower_sel").val();
		var follower_name_sel = $('#follower_sel option:selected').attr('follower_name');
	    
        if(follower_list){		
		  if(follower_list.indexOf(follower_sel) != -1){
			var new_followers = follower_list; 
			var new_followers_name_list = follower_name_list;
		  }else{
			if(follower_sel){
				var new_followers = follower_list+','+follower_sel; 
				var new_followers_name_list = follower_name_list+','+follower_name_sel;
			}else{
				var new_followers = follower_list; 
				var new_followers_name_list = follower_name_list;	
			}
		  }
		}else{ 
		  var new_followers = follower_sel; 
		  var new_followers_name_list = follower_name_sel;
		}
		
		var task_ref_id = <?=$q; ?>;
		var follower_info = 'proc=add'+'&task_ref_id='+task_ref_id+'&follower_username_list='+new_followers;
		
		var new_followers_name_list_arr = new_followers_name_list.split(','); //Split a string into an array of strings
		for(var i=0;i<new_followers_name_list_arr.length;i++){
			var new_followers_name_list__link_arr = '<a href="#">'+new_followers_name_list_arr[i]+'<i class="icon-remove-circle"></i></a> ';
		}
		var new_followers_name_list__link_str = new_followers_name_list__link_arr.toString();
		//alert(new_assignee_name_list__link_str);

        $.ajax({
				type : "GET",
				url : "follower_process.php", //URL to the save assignee php script
				data : follower_info,
				success : function() {
					$('#follower').html(new_followers_name_list);
					$('#follower_list').html(new_followers_name_list);
					$('#follower_name_list').val(new_followers_name_list);
					$('#follower_username_list').val(new_followers);
				}
		});
	});
	
	
	$('#task_due_date_sel').change( function() {
		//.val, get value frm divs
		//option:selected, get value frm dropdown
		//.attr, get value based on attribute
		var task_due_date = $('#task_due_date_sel').val(); 
		var task_ref_id = <?=$q; ?>;
		var task_due_date_info = 'proc=update'+'&task_ref_id='+task_ref_id+'&task_due_date='+task_due_date;

        $.ajax({
				type : "POST",
				url : "task_due_date_process.php", //URL to the save task_due_date php script
				data : task_due_date_info,
				success : function() {
					$('#task_due_date').html(task_due_date);
					$('#task_due_date_sel').html(task_due_date);
				}
		});
	});
	
	$('#task_due_time_sel').change( function() {
		//.val, get value frm divs
		//option:selected, get value frm dropdown
		//.attr, get value based on attribute
		var task_due_time = $('#task_due_time_sel :selected').text();   
		var task_ref_id = <?=$q; ?>;
		if(task_due_time!=' - - Select - - '){
		  var task_due_time_info = 'proc=update&task_ref_id='+task_ref_id+'&task_due_time='+task_due_time;	
		}

        $.ajax({
				type : "POST",
				url : "task_due_time_process.php", //URL to the save task_due_time php script
				data : task_due_time_info,
				success : function() {
					$('#task_due_time').html(task_due_time);
					//$('#task_due_time_sel').html(task_due_time);
				}
		});
	});	
	
});




$(function(){
	$('.input-group.date').datepicker({
		format: 'yyyy-mm-dd',
		calendarWeeks: true,
		todayHighlight: true,
		autoclose: true
	});  
 
});
</script>
<script type="text/javascript">
	//$('#timepicker1').timepicker();
</script>



<style>
.form-inline .form-control {
    width:auto;
}
.form-inline .form-group {
    display: inline-block;
}
.iconred {color:red;}
.timeline-container{
	overflow-y: scroll;
	height:280px;
}
.popover-modal .popover-body { overflow:hidden; padding:1em;}
</style>



<div class="bs-example"><i class="fa fa-eye-slash fa-lg"></i> Visible to <?=$task_visible_to_name_str; ?></div>
<BR>
<div class="bs-example"><i class="fa fa-circle-o fa-lg"></i> <font size="2"><strong><?php echo $row['task_name']; ?></strong></font></div>

<BR>

<div>
<i class="fa fa-user fa-lg"></i> <strong>Assignees</strong> &nbsp;&nbsp;&nbsp;
<span class="popover-wrapper">
  <a href="#" data-role="popover" data-target="example-popover-2"><span id="assignee"><?php if($task_assignee_name_str=="") { echo "Add New"; }else{ echo $task_assignee_name_str; } ?></span></a>
  <div class="popover-modal example-popover-2">
   <div class="popover-header">Assign to
      <a href="#" data-toggle-role="close" style="float: right"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
    <div class="popover-body">
     <div class="row display-info">
	  <div class="col-sm-4">User</div>
	  <div class="col-sm-8">
		<select class="form-control input-sm" id="assignee_sel">
		  <option> - - Select - - </option>
		  <?php 
		    $sqlasn = "Select usr_name,emp_first_name FROM usr_user ";
			$rsasn = @mysqli_query($dbh,$sqlasn);
			while($rowasn = @mysqli_fetch_array($rsasn)){
		  ?>
		  <option value="<?=$rowasn['usr_name']; ?>" assignee_name="<?=$rowasn['emp_first_name']; ?>"><?=$rowasn['emp_first_name']; ?></option>
  		  <?php } ?>
		</select>
	  </div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4">Assignees:</div>
	  <div class="col-sm-8">
	    <div class="display-info" id="assignee_list" style="height: 30px;"><?=$task_assignee_name_str; ?></div>	  
		<input type="hidden" id="assignee_name_list" value="<?=$task_assignee_name_str; ?>">
	    <input type="hidden" id="assignee_username_list" value="<?=$task_assignee; ?>">
	  </div>	  
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4"><a href="#" class="text-red">Remove</a></div>
	  <div class="col-sm-8"><!--<button type="button" class="btn btn-primary btn-xs">Save</button>--></div>
	 </div>
    </div>
  </div>
</span>
</div>

<BR>
<div><i class="fa fa-calendar fa-lg"></i> <strong>Due Date</strong> &nbsp;&nbsp;&nbsp;&nbsp;
<span class="popover-wrapper">
  <a href="#" data-role="popover" data-target="example-popover-2">
    <span id="task_due_date"><?php if($task_due_date=="") { echo "Add New"; }else{ echo $task_due_date; } ?></span> - 
	<span id="task_due_time"><?php if($task_due_time=="") { echo "Add New"; }else{ echo $task_due_time; } ?></span></a>
  <div class="popover-modal example-popover-2">
   <div class="popover-header">Schedule It
      <a href="#" data-toggle-role="close" style="float: right"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
    <div class="popover-body">
     <div class="row display-info">
	  <div class="col-sm-4">Date</div>
	  <div class="col-sm-8">
			<div class="input-group date">
				<input type="text" class="form-control input-sm" id="task_due_date_sel" value="<?php echo $row['task_due_date']; ?>"><span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
			</div>
	  </div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4">Time</div>
	  <div class="col-sm-8">
        <select class="form-control input-sm" id="task_due_time_sel">
		  <option> - - Select - - </option>
		  <option <?php if($task_due_time=="12:00am"){ echo "selected"; }?>>12:00am</option>
		  <option <?php if($task_due_time=="12:30am"){ echo "selected"; }?>>12:30am</option>
		  <option <?php if($task_due_time=="01:00am"){ echo "selected"; }?>>01:00am</option>
		  <option <?php if($task_due_time=="01:30am"){ echo "selected"; }?>>01:30am</option>
		  <option <?php if($task_due_time=="02:00am"){ echo "selected"; }?>>02:00am</option>
		  <option <?php if($task_due_time=="02:30am"){ echo "selected"; }?>>02:30am</option>
		  <option <?php if($task_due_time=="03:00am"){ echo "selected"; }?>>03:00am</option>
		  <option <?php if($task_due_time=="03:30am"){ echo "selected"; }?>>03:30am</option>
		  <option <?php if($task_due_time=="04:00am"){ echo "selected"; }?>>04:00am</option>
		  <option <?php if($task_due_time=="04:30am"){ echo "selected"; }?>>04:30am</option>
		  <option <?php if($task_due_time=="05:00am"){ echo "selected"; }?>>05:00am</option>
		  <option <?php if($task_due_time=="05:30am"){ echo "selected"; }?>>05:30am</option>
		  <option <?php if($task_due_time=="06:00am"){ echo "selected"; }?>>06:00am</option>
		  <option <?php if($task_due_time=="06:30am"){ echo "selected"; }?>>06:30am</option>
		  <option <?php if($task_due_time=="07:00am"){ echo "selected"; }?>>07:00am</option>
		  <option <?php if($task_due_time=="07:30am"){ echo "selected"; }?>>07:30am</option>
		  <option <?php if($task_due_time=="08:00am"){ echo "selected"; }?>>08:00am</option>
		  <option <?php if($task_due_time=="08:30am"){ echo "selected"; }?>>08:30am</option>
		  <option <?php if($task_due_time=="09:00am"){ echo "selected"; }?>>09:00am</option>
		  <option <?php if($task_due_time=="09:30am"){ echo "selected"; }?>>09:30am</option>
		  <option <?php if($task_due_time=="10:00am"){ echo "selected"; }?>>10:00am</option>
		  <option <?php if($task_due_time=="10:30am"){ echo "selected"; }?>>10:30am</option>
		  <option <?php if($task_due_time=="11:00am"){ echo "selected"; }?>>11:00am</option>
		  <option <?php if($task_due_time=="11:30am"){ echo "selected"; }?>>11:30am</option>
		  <option <?php if($task_due_time=="12:00pm"){ echo "selected"; }?>>12:00pm</option>
		  <option <?php if($task_due_time=="12:30pm"){ echo "selected"; }?>>12:30pm</option>
		  <option <?php if($task_due_time=="01:00pm"){ echo "selected"; }?>>01:00pm</option>
		  <option <?php if($task_due_time=="01:30pm"){ echo "selected"; }?>>01:30pm</option>
		  <option <?php if($task_due_time=="02:00pm"){ echo "selected"; }?>>02:00pm</option>
		  <option <?php if($task_due_time=="02:30pm"){ echo "selected"; }?>>02:30pm</option>
		  <option <?php if($task_due_time=="03:00pm"){ echo "selected"; }?>>03:00pm</option>
		  <option <?php if($task_due_time=="03:30pm"){ echo "selected"; }?>>03:30pm</option>
		  <option <?php if($task_due_time=="04:00pm"){ echo "selected"; }?>>04:00pm</option>
		  <option <?php if($task_due_time=="04:30pm"){ echo "selected"; }?>>04:30pm</option>
		  <option <?php if($task_due_time=="05:00pm"){ echo "selected"; }?>>05:00pm</option>
		  <option <?php if($task_due_time=="05:30pm"){ echo "selected"; }?>>05:30pm</option>
		  <option <?php if($task_due_time=="06:00pm"){ echo "selected"; }?>>06:00pm</option>
		  <option <?php if($task_due_time=="06:30pm"){ echo "selected"; }?>>06:30pm</option>
		  <option <?php if($task_due_time=="07:00pm"){ echo "selected"; }?>>07:00pm</option>
		  <option <?php if($task_due_time=="07:30pm"){ echo "selected"; }?>>07:30pm</option>
		  <option <?php if($task_due_time=="08:00pm"){ echo "selected"; }?>>08:00pm</option>
		  <option <?php if($task_due_time=="08:30pm"){ echo "selected"; }?>>08:30pm</option>
		  <option <?php if($task_due_time=="09:00pm"){ echo "selected"; }?>>09:00pm</option>
		  <option <?php if($task_due_time=="09:30pm"){ echo "selected"; }?>>09:30pm</option>
		  <option <?php if($task_due_time=="10:00pm"){ echo "selected"; }?>>10:00pm</option>
		  <option <?php if($task_due_time=="10:30pm"){ echo "selected"; }?>>10:30pm</option>
		  <option <?php if($task_due_time=="11:00pm"){ echo "selected"; }?>>11:00pm</option>
		  <option <?php if($task_due_time=="11:30pm"){ echo "selected"; }?>>11:30pm</option>
		</select>
	  </div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4"><a href="#" class="text-red">Remove</a></div>
	  <div class="col-sm-8"><!--<button type="button" class="btn btn-primary btn-xs">Save</button>--></div>
	 </div>
    </div>
  </div>
</span>
</div>

<BR>

<div>
<i class="fa fa-tags fa-lg"></i> <strong>Labels</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<span class="popover-wrapper">
  <a href="#" data-role="popover" data-target="example-popover-2"><?php if($task_label_desc_str=="") { echo "Add New"; }else{ echo $task_label_desc_str; } ?></a>
  <div class="popover-modal example-popover-2">
   <div class="popover-header">Add Labels
      <a href="#" data-toggle-role="close" style="float: right"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
    <div class="popover-body">
     <div class="row display-info">
	  <div class="col-sm-4">Select Label</div>
	  <div class="col-sm-8">
		<select class="form-control input-sm" id="label">
		  <option> - - Select - - </option>
		  <?php 
		    $sqlalb = "Select task_label_code,task_label_desc FROM task_label ";
			$rsalb = @mysqli_query($dbh,$sqlalb);
			while($rowalb = @mysqli_fetch_array($rsalb)){
		  ?>
		  <option value="<?=$rowalb['task_label_code']; ?>"><?=$rowalb['task_label_desc']; ?></option>
  		  <?php } ?>
		</select>
	  </div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4">Label:</div>
	  <div class="col-sm-8"><div id="label"><?php echo $task_label_desc_str; ?></div></div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4"><a href="#" class="text-red">Remove</a></div>
	  <div class="col-sm-8"><!--<button type="button" class="btn btn-primary btn-xs">Save</button>--></div>
	 </div>
    </div>
  </div>
</span>
</div>

<BR>

<div>
<i class="fa fa-rss fa-lg"></i> <strong>Followers</strong> &nbsp;&nbsp;&nbsp;&nbsp;
<span class="popover-wrapper">
  <span id="follower">
    <?php //if($task_follower_name_str=="") { echo "Add New"; }else{ echo $task_follower_name_str; } 
	echo $task_follower_name_str;
	?>
	&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="#" data-role="popover" data-target="example-popover-2">Add New</a>
  </span>
  
  <div class="popover-modal example-popover-2">
   <div class="popover-header">Add Followers
      <a href="#" data-toggle-role="close" style="float: right"><i class="fa fa-times" aria-hidden="true"></i></a>
    </div>
    <div class="popover-body">
     <div class="row display-info">
	  <div class="col-sm-4">User</div>
	  <div class="col-sm-8">
		<select class="form-control input-sm" id="follower_sel">
		  <option> - - Select - - </option>
		  <?php 
		    $sqlasn = "Select usr_name,emp_first_name FROM usr_user ";
			$rsasn = @mysqli_query($dbh,$sqlasn);
			while($rowasn = @mysqli_fetch_array($rsasn)){
		  ?>
		  <option value="<?=$rowasn['usr_name']; ?>" follower_name="<?=$rowasn['emp_first_name']; ?>"><?=$rowasn['emp_first_name']; ?></option>
  		  <?php } ?>
		</select>
	  </div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4">Followers:</div>
	  <div class="col-sm-8">
        <div class="display-info" id="follower_list" style="height: 30px;"><?=$task_follower_name_str; ?></div>	  
		<input type="hidden" id="follower_name_list" value="<?=$task_follower_name_str; ?>">
	    <input type="hidden" id="follower_username_list" value="<?=$task_follower; ?>"> 
	  </div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row">
	  <div class="col-sm-4"></div>
	  <div class="col-sm-8"></div>
	 </div>
	 <div class="row display-info">
	  <div class="col-sm-4"><a href="#" class="text-red">Remove</a></div>
	  <div class="col-sm-8"><!--<button type="button" class="btn btn-primary btn-xs">Save</button>--></div>
	 </div>
    </div>
  </div>
</span>
</div>

<BR>

<div>
<i class="fa fa-tasks fa-lg"></i> <strong>Subtasks</strong> &nbsp;&nbsp;&nbsp;&nbsp;
<form id="subtaskform"  method="POST" class="form_statusinput" style="display: inline;">
	<input class="input" name="subtask_name" id="subtask_name" placeholder="Add subtask here..." autocomplete="off" size="40">
	<input type="hidden"  name="task_ref_id" id="task_ref_id" value="<?php echo $q; ?>">
	<input type="hidden"  name="proc" id="proc" value="add">
</form>

	<div id="subtask_posted">
		<?php
		$sqlst = "Select rec_id,subtask_name FROM task_subtask WHERE task_ref_id = '$q' AND deleted_flag !='Y' ";
		$rsst = @mysqli_query($dbh,$sqlst);
		while($rowst = @mysqli_fetch_array($rsst)){
			
			$subtask_ref_id = $rowst['rec_id'];
			$subtask_name = $rowst['subtask_name'];	
			?>
			<i class="fa fa-circle-o" aria-hidden="true"></i>&nbsp; <?=$subtask_name; ?> <a href="#" class="delete_subtask" rec_id="<?=$subtask_ref_id; ?>" title="Delete Subtask"><i class="fa fa-times iconred fa-lg"></i></a>
			<?php
			echo "<BR>";
		}
		?>
	</div>
</div>

<hr>

<form id="myform"  method="POST" class="form_statusinput" enctype="multipart/form-data">
	<input class="input" name="newmsg" id="newmsg" placeholder="Write something here..." autocomplete="off" size="40">
	<input type="hidden"  name="q" id="q" value="<?php echo $q; ?>">
	<input type="submit" id="button" value="Post" class="btn btn-primary btn-sm">
	<input type="file" class="comment_attachment" id="comment_attachment"  name="comment_attachment"/>
</form>



<div class="timeline-container" id="content3"> 
<?php

$sql_check = @mysqli_query($dbh,"SELECT * FROM task_comment WHERE task_ref_id = '$q' 
             AND deleted_flag != 'Y' ORDER BY rec_id DESC");
$attachment_stored_path = "";
while($r = @mysqli_fetch_array($sql_check)){
	
	$rec_id = $r['rec_id'];
	$add_by = $r['add_by'];
	$add_date = $r['add_date'];
	$add_time = $r['add_time'];
	
	//Task Comment Attachment
	$sqlcma = "Select attachment_stored_path FROM task_comment_attachment WHERE task_comment_ref_id = '$rec_id' ";
	$rscma = @mysqli_query($dbh,$sqlcma);
	$rowcma = @mysqli_fetch_array($rscma);
	
		$attachment_stored_path = $rowcma['attachment_stored_path'];
		
	//Comment by
	$sqlc = "Select emp_first_name FROM usr_user WHERE usr_name = '$add_by'";
	$rsc = @mysqli_query($dbh,$sqlc);
	$rowc = @mysqli_fetch_array($rsc);

		$comment_by = $rowc['emp_first_name'];

?>

<div class="timeline">
		  <p>
		  <i class="fa fa-comments" aria-hidden="true"></i> <?=$comment_by ?> commented on the task</h5> <a href="#" id="delete_comment" rec_id="<?=$rec_id ?>" title="Delete"> <i class="fa fa-times iconred fa-lg"></i></a><BR>
		  <small class="text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo time_elapsed_string(''.$add_date.' '.$add_time.''); ?></small><BR>
		  <?php echo $r['task_comment_desc']; ?> </a><BR>
		  <?php if($attachment_stored_path!=""){ ?>
		  <img src="<?=$attachment_stored_path ?>" width="250px" height="170px">
		  <?php } ?>
		  </p>
		  <BR>
</div>
<?php } ?>
</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script src="js/jquery-popover-0.0.3.js"></script>
<script>
$(document).ready(function () {
    $('[data-role="popover"]').popover({
        html: true
    }).on('shown.bs.popover', function () {
        $('#datetimepicker2').datetimepicker();
    });
});
</script>

<?php
mysqli_close($dbh);
?>