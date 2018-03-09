<?php
session_start();
extract($_POST);
include('conn_config.php');
require_once('timezone_inc.php');
//Debug

if($_POST['mode']=="lgn"){

		  $user_name = $_POST['usr_s']; 
		  $pass_word = $_POST['pwd_s'];
		 
		  $tblname = "usr_user";
		  $sqlsalt = "Select usr_name, usr_email, usr_pwd_salt, usr_pwd FROM usr_user WHERE usr_name = '$user_name' OR usr_email = '$user_name' LIMIT 1";
		  $ssalt = @mysqli_query($dbh,$sqlsalt); 
		  $rowsalt = @mysqli_fetch_array($ssalt); 
		  $salt = @$rowsalt['usr_pwd_salt'];
		  $salt2 = @$rowsalt['usr_pwd'];
		  $pws_hash = hash("sha256", $pass_word.$salt);
		  $user_name = @mysqli_real_escape_string($dbh,$user_name);
		  $act_type = "Login";
		  $add_date = date('Y-m-d');
		  $add_time = date('H:i:s');
		  $add_by = $user_name;
		  
		  $loginssql = "Select usr_name, usr_email, usr_pwd, usr_pwd_salt,role_code,usr_site,company_code,network_code 
		                FROM $tblname WHERE usr_name = '$user_name' OR usr_email = '$user_name' AND usr_pwd= '$pws_hash' AND usr_status = 'A' LIMIT 1"; 
		
		 $loginchk = @mysqli_query($dbh,$loginssql);
		  $cloginchk = @mysqli_num_rows($loginchk);  

  if($cloginchk>0){
  
		  $rowcl = @mysqli_fetch_array($loginchk);
		  
		        $usr_role = $rowcl['role_code'];  
                $company_code = $rowcl['company_code'];
				$network_code = $rowcl['network_code'];
		       
			$sqlcr = "Select right_code FROM usr_role WHERE role_code = '$usr_role' ";
			$rscr = @mysqli_query($dbh,$sqlcr);
			$rowcr = @mysqli_fetch_array($rscr);
                             
			     $right_code = $rowcr['right_code'];
				 $usr_right = explode(",", $right_code);
		
			
            @$_SESSION['usr_mod'] = $usr_mod;
		    @$_SESSION['usr_sS'] = $rowcl['usr_name'];  
			@$_SESSION['site_usr'] = $rowcl['usr_site'];
			@$_SESSION['usr_right'] = $usr_right;
            @$_SESSION['company_code'] = $company_code;
			@$_SESSION['network_code'] = $network_code;
            @$_SESSION['sys_Code'] = "ACMTASK";
            

			$sqllr = "UPDATE $tblname SET last_login_date = '$add_date' , last_login_time = '$add_time', logged_in = 'Y' WHERE usr_name = '$user_name' ";  
			$rslr = @mysqli_query($dbh,$sqllr);				
			header('Location: main.php');   
 

  }else{     
	        echo "<script>alert('Please enter the correct Username and Password!');</script>";
	        echo "<script>window.top.location ='index.php';</script>";      
  }
  
 
}
?>

  <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css" />
  <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" />  
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	
	<div class="container">    
        <div id="loginbox" style="margin-top:50px;" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">                    
            <div class="panel panel-info" >
                    <div class="panel-heading">
                        <div class="panel-title">Sign In to ACMTask</div>
                        <div style="float:right; font-size: 80%; position: relative; top:-10px">
							
							<a href="#" onClick="$('#loginbox').hide(); $('#forgotpassword').show()">
								Forgot password?
							</a>
						</div>
						
												
                    </div>     

                    <div style="padding-top:30px" class="panel-body" >

                        <div style="display:none" id="login-alert" class="alert alert-danger col-sm-12"></div>
                            
                        <form id="loginform" class="form-horizontal" role="form" method="post" action="index.php">
                                    
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                                        <input id="login-username" type="text" class="form-control" name="usr_s" placeholder="Username or Email" required>                                        
                                    </div>
                                
                            <div style="margin-bottom: 25px" class="input-group">
                                        <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
                                        <input id="login-password" type="password" class="form-control" name="pwd_s" placeholder="Password" required>
                                    </div>



                                <div style="margin-top:10px" class="form-group">
                                    <!-- Button -->

                                    <div class="col-sm-12 controls">
									  <input name="mode" type="hidden" value="lgn">
                                      <input type="submit" class="btn btn-success" value="Login">
                                      <!-- <a id="btn-fblogin" href="#" class="btn btn-primary">Login with Facebook</a> -->

                                    </div>
                                </div>


                                <div class="form-group">
                                    <div class="col-md-12 control">
                                        <div style="border-top: 1px solid#888; padding-top:15px; font-size:85%" >
                                            Don't have an account! 
                                        <a href="#" onClick="$('#loginbox').hide(); $('#signupbox').show()">
                                            Sign Up Here
                                        </a>
                                        </div>
                                    </div>
                                </div>    
                            </form>     



                        </div>                     
                    </div>  
        </div>
		
		<!-- Form register -->
		<form name="register user" method="post" action="register_process.php">
        <div id="signupbox" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Sign Up</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#loginbox').show()">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="email" placeholder="Email Address">
                                    </div>
                                </div>
                                    
                                <div class="form-group">
                                    <label for="firstname" class="col-md-3 control-label">First Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="firstname" placeholder="First Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="lastname" class="col-md-3 control-label">Last Name</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="lastname" placeholder="Last Name">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="Contact" class="col-md-3 control-label">Contact</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="Contact" placeholder="Contact Number">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label for="Company" class="col-md-3 control-label">Company</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" name="Company" placeholder="Company Name">
                                    </div>
                                </div>
								
								<div class="form-group">
                                    <label for="password" class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        <input type="password" class="form-control" name="passwd" placeholder="Password">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                      <input id="btn-signup" type="submit" class="btn btn-info" value="Sign Up">
										<span style="margin-left:8px;"></span>  
                                    </div>
                                </div>
                                
                                <!--<div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                                    </div>                                           
                                        
                                </div>-->
                                
                                
                                
                            </form>
                         </div>
                    </div>            
         </div> 
		 <!-- Form register -->
		 </form>
		 
		 <!-- Forgot Password -->
		<form name="forgot password" method="post" action="forgot_password_process.php">
        <div id="forgotpassword" style="display:none; margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <div class="panel-title">Forgot Password</div>
                            <div style="float:right; font-size: 85%; position: relative; top:-10px">
								<a id="signinlink" href="#" onclick="$('#signupbox').hide(); $('#forgotpassword').hide(); $('#loginbox').show()">Sign In</a></div>
                        </div>  
                        <div class="panel-body" >
                            <form id="signupform" class="form-horizontal" role="form">
                                
                                <div id="signupalert" style="display:none" class="alert alert-danger">
                                    <p>Error:</p>
                                    <span></span>
                                </div>
                                    
                                
                                  
                                <div class="form-group">
                                    <label for="email" class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        <input type="text" class="form-control" autofocus name="email" placeholder="Email Address" >
                                    </div>
                                </div>
                                    
                                
                                <div class="form-group">
                                    <!-- Button -->                                        
                                    <div class="col-md-offset-3 col-md-9">
                                      <input id="btn-signup" type="submit" class="btn btn-info" value="Submit">
										<span style="margin-left:8px;"></span>  
                                    </div>
                                </div>
                                
								<BR/><BR/>
								
								<B>Note:</B> Please provide the email address that you used when you signed up for your ACMTASK account. We will send you a message with instructions on how to reset your password.
                                <BR/>
								<BR/>
								If you signed up using your Facebook or Google credentials, the email address that you should enter here is the one associated with that account.
								
								
								<!--<div style="border-top: 1px solid #999; padding-top:20px"  class="form-group">
                                    
                                    <div class="col-md-offset-3 col-md-9">
                                        <button id="btn-fbsignup" type="button" class="btn btn-primary"><i class="icon-facebook"></i>   Sign Up with Facebook</button>
                                    </div>                                           
                                        
                                </div>-->
                                
                                
                                
                            </form>
                         </div>
                    </div>            
         </div>
		 <!-- Form register -->
		 </form>
    </div>
    