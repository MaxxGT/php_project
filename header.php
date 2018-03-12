<?php 
include('conn_config.php');
include('acc_ct.php');
//ini_set('error_reporting', 0);
//ini_set('display_errors', 0);
$logged_in_usr = $_SESSION['usr_sS'];
$network_code = $_SESSION['network_code'];

//logged in
$sqls = "Select * FROM usr_user WHERE usr_name = '$logged_in_usr'";
$rss = @mysqli_query($dbh,$sqls);
$rows = @mysqli_fetch_array($rss);

$emp_first_name = $rows['emp_first_name'];	

//Network
$sqlnwc = "Select network_short_name FROM network WHERE network_code = '$network_code' ";
$rsnwc = @mysqli_query($dbh,$sqlnwc);
$rownwc = @mysqli_fetch_array($rsnwc);

$network_short_name = $rownwc['network_short_name'];	
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="css/bootstrap.min.css" />
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />  
<link rel="stylesheet" href="css/navbar.css" />
<script src="js/jquery-latest.min.js" type="text/javascript"></script>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>

<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
	<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
	  <span class="sr-only">Toggle navigation</span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	  <span class="icon-bar"></span>
	</button>
	<a class="navbar-brand" href="#"><span class="text-white"><?=$network_short_name ?> </span></a>
  </div>

  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="col-sm-3 col-md-2"></div>
  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	<ul class="nav navbar-nav navbar-left">
	  <!--<li><a href="#">Link</a></li>-->
	  <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="text-white"><i class="fa fa-sitemap text-white fa-lg"></i> <b class="caret"></b> </span></a>
		<ul class="dropdown-menu">
		  <?php 
		  $sqlnw = "Select network_code, network_short_name FROM network WHERE network_member LIKE '%$logged_in_usr%' ";
		  $rsnw = @mysqli_query($dbh,$sqlnw);
		  $crownw = @mysqli_num_rows($rsnw);
		  ?>
		  <li><a href="#">Networks: (<?=$crownw ?>)</a></li>
		  <?php while($rownw = @mysqli_fetch_array($rsnw)){ 
		  
		    $network_code_ref = $rownw['network_code'];
			$network_short_name = $rownw['network_short_name'];
		  ?>
		  <li><a href="network_change.php?rel=<?=$network_code_ref; ?>" id="btn-network"><?=$network_short_name; ?></a></li>
		  <?php } ?>
		  <li class="divider"></li>
		  <li><a href="#" data-toggle="modal" data-target="#addNet" id="test"><i class='fa fa-plus text-11 fa-lg'><span class="text-12"> Add Network</span></i></a></li>
		  <li><a href="#"><i class='fa fa-shield text-11 fa-lg'> <span class="text-12"> Customize Your Network</span></i></a></li>
		</ul>
	  </li>
	</ul>
	<div class="col-sm-3 col-md-3">
		<form class="navbar-form" role="search">
		<div class="input-group">
			<input type="text" class="form-control input-sm" placeholder="Search" name="q">
			<div class="input-group-btn">
				<button class="btn btn-default no-radius btn-lg" type="submit"><i class="fa fa-search"></i></button>
			</div>
		</div>
		</form>
	</div>
	<ul class="nav navbar-nav navbar-right">
	  <!--<li><a href="#">Link</a></li>-->
	  <li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="text-white"><?=$emp_first_name; ?> (2) <b class="caret"></b> </span></a>
		<ul class="dropdown-menu">
		  <li><a href="#"><i class="fa fa-cog fa-lg"></i> Settings</a></li>
		  <li><a href="#"><i class="fa fa-question-circle fa-lg"></i> Help</a></li>
		  <li class="divider"></li>
		  <li><a href="logout.php"><i class="fa fa-sign-out fa-lg"></i> Logout</a></li>
		</ul>
	  </li>
	</ul>
  </div>
  <!-- /.navbar-collapse -->
</nav>
</head>
<html>
	<!-- Modals -->
    <!-- Add Network -->
	<div class="modal" id="addNet" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <form action="addNetwork.php" method="POST">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Add Network</h4>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <label>Start a new network</label>
          <input type="text" class="form-control" placeholder="Network Name" name="network">
          <input type="text" class="form-control" placeholder="Network Short Name" name="network_short_name">
		  
		  <input type="hidden" name="network_userCreate" value="<?php echo "{$_SESSION['u_username']}"; ?>">
		  <input type="hidden" name="network_username" value="<?php echo "{$_SESSION['u_username']}"; ?>">
		  <input type="hidden" name="network_admin" value="<?php echo "{$_SESSION['usr_sS']}"; ?>">
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