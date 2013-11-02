<?php 
 	include('php/login.class.php'); 							// Load login related functions and database


	$print =''; 
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
        <h2 class="form-signin-heading">Public Page</h2>
        	<p> You are viewing the public page. Anyone can view this page.  </p>
        	<p> <?php echo $print; ?> </p>
        	<p><a href="index.php"><i class="icon-arrow-left"></i> Back to the home page </a></p>
      </form>

    </div> <!-- /container -->
    
  


	</body>
</html>