 <?php
include('conn_config.php');
include('acc_ct.php');
 
$uid = $_GET['uid'];
$network_code = $_SESSION['network_code'];

$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND network_code = '$network_code' ";
$rsut = @mysqli_query($dbh,$sqlut);
?>
		<h5>Task Due Today</h5>
		<hr>
		<?php 
		$sqlut2 = "SELECT * FROM task WHERE task_owner = '$uid' AND task_due_date = curdate() AND network_code = '$network_code'";
		$rsut2 = @mysqli_query($dbh,$sqlut2);
		while($rowut2 = @mysqli_fetch_array($rsut2)){
			
			$task_id2 = $rowut2['rec_id'];
			$task_name2 = $rowut2['task_name'];
		?>
		<a onclick="$('div#content').load('task_view.php?q=<?=$task_id2; ?>')"><i class="fa fa-circle-o fa-lg"></i> <?=$task_name2; ?></a><BR><BR>
		<?php } ?>