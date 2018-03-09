<?php 
include('conn_config.php');
include('acc_ct.php');

$q = intval($_GET['q']);
$add_date = date('Y-m-d');
$add_time = date('H:i:s');
$add_by = $_SESSION['usr_sS'];
$upd_date = date('Y-m-d');
$upd_time = date('H:i:s');
$upd_by = $_SESSION['usr_sS'];

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


$sql_check = @mysqli_query($dbh,"SELECT * FROM task_comment WHERE task_ref_id = '$q' 
             AND deleted_flag != 'Y' ORDER BY rec_id DESC");
$attachment_stored_path = "";
while($r = @mysqli_fetch_array($sql_check)){
	
	$rec_id = $r['rec_id'];
	$add_date = $r['add_date'];
	$add_time = $r['add_time'];
	
	//Task Comment Attachment
	$sqlcma = "Select attachment_stored_path FROM task_comment_attachment WHERE task_comment_ref_id = '$rec_id' ";
	$rscma = @mysqli_query($dbh,$sqlcma);
	$rowcma = @mysqli_fetch_array($rscma);
	
		$attachment_stored_path = $rowcma['attachment_stored_path'];

?>

<script>
$(document).ready(function(){
    $("#delete_comment").click(function() {
		var rec_id = $('#delete_comment').attr("rec_id");
		var info = 'rec_id=' + rec_id;
			$.ajax({
				type : "GET",
				url : "task_delete.php", //URL to the delete php script
				data : info,
				success : function() {
					$('div#content3').load('task_success.php?q=<?=$q; ?>');
				    $('#newmsg').val('');
				}
			});
	});
});
</script>

<div class="timeline">
		  <p>
		  <i class="fa fa-comments" aria-hidden="true"></i> ACM- Lai commented on the task</h5> <a href="#" id="delete_comment" rec_id="<?=$rec_id ?>" title="Delete"> <i class="fa fa-times iconred fa-lg"></i></a><BR>
		  <small class="text-muted"><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo time_elapsed_string(''.$add_date.' '.$add_time.''); ?></small><BR>
		  <?php echo $r['task_comment_desc']; ?><BR>
		  <?php if($attachment_stored_path!=""){ ?>
		  <img src="<?=$attachment_stored_path ?>" width="250px" height="170px">
		  <?php } ?>
		  </p>
		  <BR>
</div>
<?php } ?>