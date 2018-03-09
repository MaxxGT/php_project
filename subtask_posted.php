<?php 
include('conn_config.php');
include('acc_ct.php');

$task_ref_id = $_GET['task_ref_id'];

?>
<link href="http://www.jqueryscript.net/css/jquerysctipttop.css" rel="stylesheet" type="text/css">
<script>
$(document).ready(function(){
    $("#delete_subtask").click(function() {
		var subtask_ref_id = $('#delete_subtask').attr("rec_id");
		var task_ref_id = <?=$q; ?>;
		var info = 'proc=delete&subtask_ref_id=' + subtask_ref_id + '&task_ref_id=' + task_ref_id;
		
		alert(info);
			$.ajax({
				type : "GET",
				url : "subtask_delete.php", //URL to the delete php script
				data : info,
				success : function() {
					$('#subtask_posted').load('subtask_posted.php?task_ref_id=<?=$task_ref_id; ?>');
				}
			});
	});
});
</script>

<?php
$sqlst = "Select rec_id,subtask_name FROM task_subtask WHERE task_ref_id = '$q' AND deleted_flag !='Y' ";
$rsst = @mysqli_query($dbh,$sqlst);
while($rowst = @mysqli_fetch_array($rsst)){
	
	$subtask_ref_id = $rowst['rec_id'];
	$subtask_name = $rowst['subtask_name'];	
	echo '<i class="fa fa-circle-o" aria-hidden="true"></i>&nbsp; '.$subtask_name.' <a href="#" id="delete_subtask" rec_id="'.$rec_id.'" title="Delete Subtask"><i class="fa fa-times iconred fa-lg"></i></a>';
	echo "<BR>";
}
?>