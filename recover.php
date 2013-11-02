<?php 
include('php/login.class.php');                           // Load login related functions and database

if($Login->isLoggedIn())                       // If logged in ...
	{
	header('Location: index.php');      // Send them to the index page. 
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Recover forgotten password</title>
	<script type="text/javascript" src="assets/js/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
	
	<link href="css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />	
</head>

<body>
	<div class="container">
<?php 

if (isset($_POST['emailRecover']))
  {
  	$username = mysql_real_escape_string($_POST['emailRecover']); 
  
  //////////////////////////////////////**  SENDING THE EMAIL   **/////////////////////////////////////////// 

  // First check if this email address is in fact in our system
      $checkEmailRecover = mysql_query("SELECT * FROM users WHERE username = '".$username."'");  
  
    if(mysql_num_rows($checkEmailRecover) == 1)  
    { 
		    // Generate recovery code 
		    $code = mt_rand(10000, 100000000);    
		    
		    // Write the code and the current timestamp to database (timestamp is for expiring the link 
		    $recoverquery = mysql_query("UPDATE `users` SET  `userRecovery` =  \"".$code."\", userRecoveryTime = '".time()."' WHERE  `username` =\"".$username."\"");  
		    
		    if($recoverquery)  			// Check if database value was changed
	        {  
	             
			    //send email
			      $headers = "Content-type: text/html\r\n"; 
			      $from = "From: Login Script <caneruguz@gmail.com>\r\n"; 
				  $email = $username ;
				  $subject = "Reset your  password" ;
				  $message = " You requested your password to be changed. If you forgot your password click on the link below to set a new password. If this email was not sent by you, you don't need to take any action, your password is not reset until you click the link: <a href=\"http://code.caneruguz.com/login/recover.php?code=".$code."&user=".$email."\" > Reset Password </a>. <br /> This link will expire in 24 hours.   ";
				  mail($email, $subject,$message, $from . $headers);
				  
					echo '				<div class="form-signin">																	';
					echo '    		<h2 class="form-signin-heading">Recover password</h2>  										   	';
					echo '					<div class=\"alert alert-success\"><p><strong> Done! </strong></p> Please check your email for further action. </div>';
					echo '				<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p></div>';
				  
	        }  else  {  
					echo '				<div class="form-signin">																	';
					echo '    		<h2 class="form-signin-heading">Recover password</h2>  										   	';
					echo '					<p><h2> Error! </h2> There was a problem with changing the value. Please try again later, or contact an administrator.</p>';
					echo '				<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p></div>';	        
			} 
	    }  else {
	    			echo '				<div class="form-signin">																	';
					echo '    		<h2 class="form-signin-heading">Recover password</h2>  										   	';
					echo '					<div class="alert alert-error"><p><strong> Error! </strong></p> We could not find this email in our system. Please try again. </div>';
					echo '		<form method="POST" action="recover.php" name="recoverform" id="recoverform">';
					echo '		<div id="emailRecover_div"> <label for="emailRecover">Email Address: </label><input type="text" name="emailRecover" id="emailRecover" /></div>';
					echo '		<p><button type="submit" id="recoverSubmit" class="btn btn-info"/>Send Email</button></p>';
					echo '	</form>		';
					echo '	<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p></div>  ';
	    }

  } elseif(isset($_GET['code']) && isset($_GET['user'])) {								// If the code is in the URL initiate the change
	  
	   //////////////////////////////////////**  SHOW CHANGE PASSWORD FORM  **/////////////////////////////////////////// 
	  	// Put the links into variables 
	  	$linkcode = $_GET['code'];
	  	$user = $_GET['user'];
	  	
	  	// Check the link code with the database, if valid show the box to change password, if not throw error
	  	$checkTimeQuery = mysql_query("SELECT * FROM `users` WHERE `userRecovery` = \"".$linkcode."\" ");  
		    
		    if(mysql_num_rows($checkTimeQuery) == 1)  			
	        { 	
	        	//Check if link has expired 
	        	$row = mysql_fetch_array($checkTimeQuery);
	        	$currentTime = time();  
	        	$diff = $currentTime - $row['userRecoveryTime'];
	        	if ($diff < 86400) {													// Link expires in 24 hours = 86400 seconds
					echo '		<form class="form-signin" method="post" action="recover.php" name="registerform" id="registerform">';
					echo '    		<h2 class="form-signin-heading">Set up a new password</h2>  										   ';
					echo '    			<label for="passwordRecover">Password: </label>											   ';
					echo '    			<input type="password" name="passwordRecover" id="passwordRecover" />					   ';
					echo '    			<label for="passwordRecover2">Re-EnterPassword: </label>								   ';
					echo '    			<input type="password" name="passwordRecover2" id="passwordRecover2" />					   ';
					echo '    			<input type="hidden" name="userEmail" id="userEmail" value="'.$user.'" />				   ';
					echo '    		<p><button id="PasswordSubmit" class="btn btn-success">Change Password</button></p>			   ';
					echo '    	</form>																							   ';
	        	} else {
					echo '				<div class="form-signin">																	';
					echo '    		<h2 class="form-signin-heading">Recover password</h2>  										   	';
					echo '					<p> <h2> Error! </h2> 																	';
					echo '					Your link has expired. <a href="recover.php" >Use the form again</a> 				    ';
					echo '					to send a new key.</p>																    ';
					echo '					<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p> 	';
					echo '				</div>																						';
	        	}
	        } else {
		        
					echo '				<div class="form-signin">																	';
					echo '    				<h2 class="form-signin-heading">Recover password</h2>  									';
					echo '					<p><h2> Error! </h2> Sorry we could not find that link. 								';
					echo '					<a href="recover.php" >Use the form again</a> or check your email.</p> 				    ';
					echo '		    		<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p>   ';
					echo '				</div>																						';
	        }
	  	
  } elseif (isset($_POST['passwordRecover'])) {  
  	
  		  //////////////////////////////////////**  CHANGE THE PASSWORD  **/////////////////////////////////////////// 
  		$password = $_POST['passwordRecover'];
  		$password2 = $_POST['passwordRecover2']; 
  		
  		// check if passwords match
  		if($password != $password2){
					echo '		<form class="form-signin" method="post" action="recover.php" name="registerform" id="registerform">';
					echo '    		<h2 class="form-signin-heading">Set up a new password</h2>  								   ';
					echo '    	<div class="alert alert-warning"> The passwords did not match. Please try again</div>			   ';
					echo '    			<label for="passwordRecover">Password: </label>											   ';
					echo '    			<input type="password" name="passwordRecover" id="passwordRecover" />					   ';
					echo '    			<label for="passwordRecover2">Re-EnterPassword: </label>								   ';
					echo '    			<input type="password" name="passwordRecover2" id="passwordRecover2" />					   ';
					echo '    			<input type="hidden" name="userEmail" id="userEmail" value="'.$user.'" />				   ';
					echo '    		<p><button id="PasswordSubmit" class="btn btn-success">Change Password</button></p>			   ';
					echo '    	</form>																							   ';
	  		
  		} else {
			  	$hash = hash('sha256', $password);
				$salt = $Login->createSalt();
				$hash = hash('sha256', $salt . $hash);
		
				/* Enter the data into the database. */
				$query = "UPDATE users SET password = '".$hash."', salt = '".$salt."' WHERE username = '".$_POST['userEmail']."';";  // A simple query to enter a row into the table users.
				$resetpassquery = mysql_query($query);
		
		  		if($resetpassquery)  
		        {  
							echo '				<div class="form-signin">																	';
							echo '    				<h2 class="form-signin-heading">Recover password</h2>  								   	';
							echo '					<p><h2> Success! </h2> Your password has been changed. </p>								';
							echo '					<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p> 	';	
							echo '				</div>																						';
		        }   else  {  
							echo '				<div class="form-signin">																	';
							echo '    			<h2 class="form-signin-heading">Recover password</h2>  										';
							echo '					<p><h2> Error! </h2> Sorry, there was a problem. 										';
							echo '						Try again by going through the email link. </p>										';
							echo '					<p><a href=\"login.php\"> Login now.</a>.</p>											';
							echo '				</div>																						'; 
		        }  
	  		
  		}

  	} else {

	   //////////////////////////////////////**  IF EMPTY SUBMISSION  **/////////////////////////////////////////// 
?>
						<form class="form-signin" method="POST" action="recover.php" name="recoverform" id="recoverform">
							<h2 class="form-signin-heading">Recover password</h2>
							<p>Enter your email, we will send you instructions to recover your password.</p>	
							<div id="emailRecover_div"> 
								<label for="emailRecover">Email Address: </label>
								<input type="text" name="emailRecover" id="emailRecover" />
							</div>
							<p><button type="submit" id="recoverSubmit" class="btn btn-info"/>Send Email</button></p>
							<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p>
						</form>		
<?php 
	 
  }

?>

    </div> <!-- /container -->

</body>
</html>