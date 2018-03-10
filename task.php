 <?php
/*last modified: 09-03-2018;*/
include('conn_config.php');
include('acc_ct.php');
 
$uid = $_GET['uid'];
$network_code = $_SESSION['network_code'];

$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND network_code = '$network_code' ";
$rsut = @mysqli_query($dbh,$sqlut);
?>

<link rel="stylesheet" href="css/tab.css">

<script>
$(document).ready(function() {
   // put Ajax here.
   $('div#active').load('task_active.php?uid=<?=$uid; ?>');
 });
</script>

  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#active" onclick="$('div#active').load('task_active.php?uid=<?=$uid; ?>'); $('div#content').empty();">Active<BR><i class="fa fa-circle-o fa-lg"></i></a></a></li>
	<li><a data-toggle="tab" href="#completed" onclick="$('div#completed').load('task_completed.php?uid=<?=$uid; ?>'); $('div#content').empty();">Completed<BR><i class="fa fa-check fa-lg"></i></a></a></li>
    <li><a data-toggle="tab" href="#due_today" onclick="$('div#due_today').load('task_due_today.php?uid=<?=$uid; ?>'); $('div#content').empty();">Due Today<BR><i class="fa fa-calendar fa-lg"></i></a></li>
    <li><a data-toggle="tab" href="#late" onclick="$('div#late').load('task_late.php?uid=<?=$uid; ?>'); $('div#content').empty();">Late<BR><i class="fa fa-warning fa-lg"></i></a></li>
    <li><a data-toggle="tab" href="#all" onclick="$('div#all').load('task_all.php?uid=<?=$uid; ?>'); $('div#content').empty();">All<BR><i class="fa fa-list-ul fa-lg"></i></a></li>
	<li><a data-toggle="tab" href="#starred" onclick="$('div#starred').load('task_starred.php?uid=<?=$uid; ?>'); $('div#content').empty();">Starred<BR><i class="fa fa-star fa-lg"></i></a></li>
  </ul>

  <div class="tab-content">
    <div id="active" class="tab-pane fade in active"> 
    </div>
	
    <div id="completed" class="tab-pane fade">
    </div>
	
    <div id="due_today" class="tab-pane fade">
    </div>
	
    <div id="late" class="tab-pane fade">
    </div>

    <div id="all" class="tab-pane fade">
    </div>
	
    <div id="starred" class="tab-pane fade">
    </div>
  </div>
</div>

