<?php 
//include('acc_ct.php');
//include($_SERVER['DOCUMENT_ROOT'].'./connection/conn_config.php');
//include('header.php');

$uid = $_GET['uid'];
?>

<title>Account Lockout</title>
<script type="text/javascript" src="js/hidecode.js"></script>
<style>
body{
  margin:0;
  background-color:#0072C6;
}
</style>

<BR><BR><BR>
	
    <table border="0" cellpadding="0" cellspacing="0" style="font-family: Segoe UI; font-size: 12px;" background="img/wave_gr3.jpg" class="gridtable" align="center" width="100%">
        <tr style='height:520px; color:#FFFFFF; '>
		    <td colspan=2 align=center style='background-color:#0072C6' valign="top">
				<!--<div data-dismiss="modal" width="16px" title="Close Window" class="btnClose" onclick="javascript:window.location.reload();">
					<img src="img/x-mark-4-64.png" width="16">&nbsp;&nbsp;&nbsp;</div>-->
				<?php echo str_repeat("<BR>",8); ?>
			    <img src='img/warning-28-256.png'><BR> <!--Dear user, you are not authorized to view this page content.-->
				Dear User, your account "<?=$uid; ?>" has been disabled. Please contact your system administrator.<BR>
				Click <u><a href="index.php" style="color:#FFFFFF;">HERE</a></u> back to login screen.
		    </td>
		</tr>
	</table>

	
<BR>

<script>
function closeWin(){
  window.close();
}
</script>	
	
<?php  include('footer.php');?>