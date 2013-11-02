<?php 
 	include_once('php/login.class.php'); 							// Load login related functions and database

 	if(isset($_GET['m'])){
	 	$m = $_GET['m'];
	 	$message = $Login->printErrors($m); 
	  $print = '<div class="alert alert-error">'.$message.' </div>'; 
 	}
	
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Sign in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
	</head>
	<body>


    <div class="container">

      <form class="form-signin" name="login" action="php/auth.php" method="post">
        <h2 class="form-signin-heading">Please sign in</h2>
        <?php echo $print;   ?> 
       <input type="text" class="input-block-level" name="username" placeholder="Email address">
        <input type="password" class="input-block-level" name="password"  placeholder="Password">
        <p class="pull-right"><a href="recover.php"> Forgot password? </a></p>
        <label class="checkbox">
          <input type="checkbox" value="remember-me" name="remme"> Remember me
        </label>
        <button class="btn btn-primary" type="submit" name="loginSubmit">Sign in</button>
          <hr class="soften">  
            <div class="alert">Don't have an account? <a href="register.php"> Register here</a>.</div>
      </form>

    </div> <!-- /container -->
    
  


	</body>
</html>
