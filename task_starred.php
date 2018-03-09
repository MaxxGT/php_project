 <?php
include('conn_config.php');
include('acc_ct.php');
 
$uid = $_GET['uid'];
$network_code = $_SESSION['network_code'];

$sqlut = "Select * FROM task WHERE task_owner = '$uid' AND network_code = '$network_code' ";
$rsut = @mysqli_query($dbh,$sqlut);
?>
		<h5>Task Starred</h5>
		<hr>