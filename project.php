 <?php
$dbHost = 'localhost'; // usually localhost
$dbUsername = 'root';
$dbPassword = 'P@ssw0rd';
$dbDatabase = 'nt_etms';
$uid = $_GET['uid'];

$db = mysql_connect($dbHost, $dbUsername, $dbPassword) or die ("Unable to connect to Database Server.");
mysql_select_db ($dbDatabase, $db) or die ("Could not select database.");

$sqlut = "Select * FROM task WHERE task_owner = '$uid' ";
$rsut = @mysql_query($sqlut);
?>

<link rel="stylesheet" href="css/tab.css">
<script src="js/jquery-1.7.1.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


  <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#completed">Completed <i class="fa fa-check fa-lg"></i></a></a></li>
    <li><a data-toggle="tab" href="#due_today">Due Today <i class="fa fa-calendar fa-lg"></i></a></li>
    <li><a data-toggle="tab" href="#late">Late <i class="fa fa-warning fa-lg"></i></a></li>
    <li><a data-toggle="tab" href="#all">All <i class="fa fa-list-ul fa-lg"></i></a></li>
	<li><a data-toggle="tab" href="#starred">Starred <i class="fa fa-star fa-lg"></i></a></li>
  </ul>

  <div class="tab-content">
    <div id="completed" class="tab-pane fade in active">
		<h5>This Week</h5>
		<?php 
		$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND YEARWEEK(add_date)=YEARWEEK(NOW())";
		$rsut = @mysql_query($sqlut);
		while($rowut = @mysql_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>Last Week</h5>
		<?php 
		$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND MONTH(add_date) = MONTH(CURRENT_DATE()) AND add_date >= curdate() - INTERVAL DAYOFWEEK(curdate())+30 DAY
                  AND add_date < curdate() - INTERVAL DAYOFWEEK(curdate())-1 DAY";
		$rsut = @mysql_query($sqlut);
		while($rowut = @mysql_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>This Month</h5>
		<?php 
		$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND WEEK(add_date,1)";
		$rsut = @mysql_query($sqlut);
		while($rowut = @mysql_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>Previous Month</h5>
		<?php 
		$sqlut = "";
		$rsut = @mysql_query($sqlut);
		while($rowut = @mysql_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>Previous Year</h5>
    </div>
    <div id="due_today" class="tab-pane fade">
		<h5>Task</h5>
		<?php 
		$sqlut2 = "";
		$rsut2 = @mysql_query($sqlut2);
		while($rowut2 = @mysql_fetch_array($rsut2)){
			
			$task_id2 = $rowut2['rec_id'];
			$task_name2 = $rowut2['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id2; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name2; ?></a><BR><BR>
		<?php } ?>
    </div>
    <div id="late" class="tab-pane fade">
		<h5>Task</h5>
		<?php 
		$sqlut3 = "Select * FROM task WHERE task_owner = '$uid' ";
		$rsut3 = @mysql_query($sqlut3);
		while($rowut3 = @mysql_fetch_array($rsut3)){
			
			$task_id3 = $rowut3['rec_id'];
			$task_name3 = $rowut3['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id3; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name3; ?></a><BR><BR>
		<?php } ?>
    </div>
    <div id="all" class="tab-pane fade">
		<h5>Task</h5>
		<?php 
		$sqlut4 = "Select * FROM task WHERE task_owner = '$uid' ";
		$rsut4 = @mysql_query($sqlut4);
		while($rowut4 = @mysql_fetch_array($rsut4)){
			
			$task_id4 = $rowut4['rec_id'];
			$task_name4 = $rowut4['task_name'];
		?>
		<a onclick="$('div#content').load('data.php?q=<?=$task_id4; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name4; ?></a><BR><BR>
		<?php } ?>
    </div>
  </div>
</div>

