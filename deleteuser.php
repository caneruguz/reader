<?php
include('php/login.class.php');                           // Load login related functions and database
include('php/text.class.php');                           // Load login related functions and database

/* Check if the user is logged in or not */

if(!$Login->isLoggedIn())                       // If not logged in ...
	{
	header('Location: login.php');      // Send them to the login page. No need for message.
	die();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <title>Text Tool</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
	</head>
	<body>

		<div id="logoutLink">
			<p>Hi <?php echo $Text->UserName($_SESSION['personid']); ?> <a class="btn btn-mini btn-warning" href="php/auth.php?logout=true">Logout</a></p>
		</div>

    <div class="container">
<? 
$id = (int) $_GET['id']; 
mysql_query("DELETE FROM `users` WHERE `id` = '$id' ") ; 
echo (mysql_affected_rows()) ? "Row deleted.<br /> " : "Nothing deleted.<br /> "; 
?> 

<a href='index.php'>Back To Listing</a>    
    
    
    </div> <!-- /container -->
    
  


	</body>
</html>