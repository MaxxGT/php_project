 <?php
include('conn_config.php');
include('acc_ct.php');
 
$uid = $_GET['uid'];
$network_code = $_SESSION['network_code'];

$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND network_code = '$network_code' ";
$rsut = @mysqli_query($dbh,$sqlut);
?>
		<h5>Task All</h5>
		<hr>
		<h5>This Week</h5>
		<?php 
		$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND YEARWEEK(add_date)= YEARWEEK(NOW()) AND network_code = '$network_code'";
		$rsut = @mysqli_query($dbh,$sqlut);
		while($rowut = @mysqli_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('task_view.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>Last Week</h5>
		<?php 
		$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND WEEKOFYEAR(add_date)= WEEKOFYEAR(NOW())-1 AND network_code = '$network_code'";
		$rsut = @mysqli_query($dbh,$sqlut);
		while($rowut = @mysqli_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('task_view.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>This Month</h5>
		<?php 
		echo $sqlut = "SELECT * FROM task WHERE task_owner = '$uid' AND add_date > DATE_SUB(NOW(), INTERVAL 1 MONTH) AND YEARWEEK(add_date)!= YEARWEEK(NOW()) 
		          AND WEEKOFYEAR(add_date)!= WEEKOFYEAR(NOW())-1 AND network_code = '$network_code'";
		$rsut = @mysqli_query($dbh,$sqlut);
		while($rowut = @mysqli_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('task_view.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>Previous Month</h5>
		<?php 
		echo $sqlut = "SELECT * FROM task WHERE task_owner = '$uid' AND MONTH(add_date)<MONTH(curdate()) AND YEAR(add_date)=YEAR(curdate())
		          AND network_code = '$network_code'";
		$rsut = @mysqli_query($dbh,$sqlut);
		while($rowut = @mysqli_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('task_view.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>
		<h5>Previous Year</h5>
		<?php 
		$sqlut = "SELECT * FROM task WHERE task_owner = '$uid' AND YEAR(add_date) < YEAR(curdate()) AND network_code = '$network_code'";
		$rsut = @mysqli_query($dbh,$sqlut);
		while($rowut = @mysqli_fetch_array($rsut)){
			
			$task_id = $rowut['rec_id'];
			$task_name = $rowut['task_name'];
		?>
		<a onclick="$('div#content').load('task_view.php?q=<?=$task_id; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name; ?></a><BR><BR>
		<?php } ?>
		<hr>