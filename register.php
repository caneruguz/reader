<?php 
 	include_once('php/login.class.php'); 							// Load login related functions and database
	
	$print =''; 
 	if(isset($_GET['m'])){
	 	$m = $_GET['m'];
	 	$message = $Login->printErrors($m); 
	  $print = '<div class="alert alert-error">'.$message.' </div>'; 
 	}

	$u = ''; 
	if(isset($_GET['u'])){
		$u = $_GET['u']; 
	} 	 
?> 
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Register</title>
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
        <h2 class="form-signin-heading">Sign up</h2>
        <?php echo $print;   ?> 
        <label for="username">Enter Email </label>
        <input type="text" class="input-block-level"  name="username" maxlength="30" value="<?php echo $u;?>">
        <label for="pass1">Enter password </label>
        <input type="password" class="input-block-level" name="pass1">
        <label for="pass2">Confirm password </label>
        <input type="password" class="input-block-level" name="pass2">
        <button class="btn btn-primary" type="submit" name="registerSubmit">Register</button>
      </form>

    </div> <!-- /container -->

	</body>
</html>