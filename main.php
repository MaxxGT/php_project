<?php 
include('header.php');

$network_code = $_SESSION['network_code'];

//Total user in this network
$sqlcn = "Select COUNT(rec_id) AS total_people FROM usr_user WHERE network_code = '$network_code'";
$rscn = @mysqli_query($dbh,$sqlcn);
$rowcn = @mysqli_fetch_array($rscn);

	$total_people = $rowcn['total_people'];

?>
<script>
$(document).ready(function() {
   // put Ajax here.
   $('div#content').empty(); 
   $('div#task').load('task.php?uid=<?=$_SESSION['usr_sS']; ?>');
});
</script>

<div class="nav-side-menu">
<div class="brand"> ACMTask</div>
<i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>
<div class="menu-list">
	<ul id="menu-content" class="menu-content collapse in">
		<!--<li>
			<a href="#">
				<i class="fa fa-search fa-lg"></i> Dashboard
			</a>
		</li>-->
		<li data-toggle="collapse" data-target="#products" class="collapsed active" aria-expanded="true">
			<a href="#"><i class="fa fa-user fa-lg"></i> People (<?=$total_people; ?>) <span class="arrow"></span></a> <a href="#"><span class="fa fa-plus"></span></a>
		</li>
		<ul class="sub-menu collapse in snav" id="products">
			<?php 
			$sqlnwm = "Select * FROM usr_user WHERE network_code = '$network_code' ORDER BY emp_name";
			$rsnwm = @mysqli_query($dbh,$sqlnwm);
			while($rownwm = @mysqli_fetch_array($rsnwm)){
				
				$emp_first_name = $rownwm['emp_first_name'];
				$uid = $rownwm['usr_name'];
			?>
			<li <?php if($_SESSION['usr_sS']==$uid) { echo "class='active'"; }?>><a onclick="$('div#content').empty(); $('div#task').load('task.php?uid=<?=$uid; ?>');"><?=$emp_first_name; ?> </a> <a href="#" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover"><i class="fa fa-cog fa-lg"></i></a></li>
			<?php } ?>
		</ul>
		<?php 
		$sqlcp = "Select COUNT(rec_id) AS total_project FROM project WHERE project_visible_to = '$usr_sS' AND network_code = '$network_code' ";
		$rscp = @mysqli_query($dbh,$sqlcp);
		$rowcp = @mysqli_fetch_array($rscp);
		
			$total_project = $rowcp['total_project'];
		?>
		<li data-toggle="collapse" data-target="#service" class="collapsed">
			<a href="#">
				<i class="fa fa-bar-chart fa-lg"></i> My Projects (<?=$total_project; ?>) <span class="arrow"></span>
			</a> 
			
			<a target="_blank" href="#" data-toggle="modal" data-target="#addProject" id="test">
				<span class="fa fa-plus"></span>
			</a>
			
		</li>
		<ul class="sub-menu collapse in snav" id="service">
			<?php 
			$sqlpj = "Select * FROM project WHERE project_visible_to LIKE '%$usr_sS%' AND network_code = '$network_code' ";
			$rspj = @mysqli_query($dbh,$sqlpj);
			while($rowpj = @mysqli_fetch_array($rspj)){
				
                $project_ref_id = $rowpj['rec_id'];
				$project_name = $rowpj['project_name'];
			?>
			<li <?php if($_SESSION['usr_sS']==$uid) { echo "class='active'"; }?>><a onclick="$('div#content').empty(); $('div#task').load('project.php?pid=<?=$project_ref_id; ?>');"><?=$project_name; ?> </a> </li>
			<?php } ?>
		</ul>


		<li data-toggle="collapse" data-target="#new" class="collapsed">
			<a href="#"><i class="fa fa-car fa-lg"></i> Labels (2) <span class="arrow"></span></a>&nbsp;&nbsp;&nbsp;
			
			<a target="_blank" href="#" data-toggle="modal" data-target="#addLabel" id="test"><span class="fa fa-plus"></span></a>
		</li>
		<ul class="sub-menu collapse in snav" id="new">
			<li>Approve-Complete</li>
			<li>Request-Complete</li>
		</ul>
		<li>
			<a href="#">
				<i class="fa fa-user fa-lg"></i> Profile
			</a>
		</li>
		<li>
			<a href="#">
				<i class="fa fa-users fa-lg"></i> Users
			</a>
		</li>
	</ul>
</div>
</div>

<div class="container" id="main">
    <div class="row">
        <div class="col-md-6" class="collapse in">
		<BR><BR><BR><BR>
		</div>
	</div>
	
	<div class="row">
		<div class="col-sm-2">
			<div class="input-group">
				<span class="input-group-addon">
					<input type="checkbox" aria-label="Checkbox for following text input" /> 
				</span>	
			
				<span class="input-group-addon">
					<ul class="nav navbar-nav navbar-left">
					  <li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="text-black">Actions <b class="caret"></b> </span>
						</a>
						<ul class="dropdown-menu">
						  <li>Select </li>
						  <li class="divider"></li>
							<li>Manual</li>
							<li>All</li>
							<li>None</li>
							<li>Done</li>
							<li>Not Done</li>
							<li>Starred</li>
							<li>Unstarred</li>
							<li>Unscheduled</li>
						</ul>
					  </li>
					</ul>
				</span>
				<input type='hidden' />
			</div>
		</div>
		
		<div class="col-lg-4">
			<button type="button" class="btn btn-secondary" align='right' onclick="$('div#task').load('task.php?uid=<?=$_SESSION['usr_sS']; ?>'); $('div#content').empty();$('div#calendar').empty();"><i class="fa fa-list-ul"></i>&nbsp;List</button>
			<button type="button" class="btn btn-secondary" align='right' onclick="$('div#calendar').load('calendar.php'); $('div#content').empty();$('div#task').empty();"><i class="fa fa-calendar"></i>&nbsp;Calendar</button>
			<button type="button" class="btn btn-secondary" align='right'><i class="fa fa-line-chart"></i>&nbsp;Activitie</button>
		</div>
	</div>
	
    <div class="row">
        <div class="col-md-6" class="collapse in">
			<a href="#" data-toggle="modal" data-target="#addTask" id="test">
				<i class="fa fa-plus fa-lg"></i> Add Task 
			</a>
		</div>
	</div>
    <div class="row">
		<div id="task" class="col-md-7"> 
        </div>
		<div id="calendar" class="col-md-7"> 
        </div>
        <div id="content" class="col-md-5">
        </div>
    </div>
</div>

<!-- Modals -->
	
	<!-- Add Project -->
	<!-- Add Label -->
	<div class="modal" id="addProject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <form action="addProject.php" method="POST">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Add New Project</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group">
			  
			  <input type="text" class="form-control" placeholder="Name the Project" name="project">
			  <input type="hidden" name="network_code" value="<?php echo "{$_SESSION['network_code']}"; ?>">
			  <input type="hidden" name="project_owner" value="<?php echo "{$_SESSION['usr_sS']}"; ?>">
			
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" name="submit" class="btn btn-primary">Save</button>
		  </div>
		</form>
		</div>
	  </div>
	</div>

	
	
	
	
	<!-- Add Task -->
	<div class="modal" id="addTask" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <form action="addTask.php" method="POST">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Add New Task</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group">
			  
			  <input type="text" class="form-control" placeholder="Type here to create a task" name="create_task">
			  <input type="hidden" name="task_userCreate" value="<?php echo "{$_SESSION['usr_sS']}"; ?>">
			  <input type="hidden" name="task_username" value="<?php echo "{$_SESSION['u_username']}"; ?>">
			  <input type="hidden" name="task_network_code" value="<?php echo "{$_SESSION['network_code']}"; ?>">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" name="submit" class="btn btn-primary">Save</button>
		  </div>
		</form>
		</div>
	  </div>
	</div>




<!-- Add Label -->
	<div class="modal" id="addLabel" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <form action="includes/addLabel.inc.php" method="POST">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Add New Label</h4>
		  </div>
		  <div class="modal-body">
			<div class="form-group">
			  
			  <input type="text" class="form-control" placeholder="Name the Label" name="network">
			  <input type="hidden" name="network_userCreate" value="<?php echo "{$_SESSION['u_username']}"; ?>">
			  <input type="hidden" name="network_username" value="<?php echo "{$_SESSION['u_username']}"; ?>">
			</div>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			<button type="submit" name="submit" class="btn btn-primary">Save</button>
		  </div>
		</form>
		</div>
	  </div>
	</div>



