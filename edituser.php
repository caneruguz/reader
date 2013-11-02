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
if (isset($_GET['id']) ) { 
$id = (int) $_GET['id']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 

		$hash = hash('sha256', $_POST['password']);
		$salt = $Login->createSalt();
		$hash = hash('sha256', $salt . $hash);

$sql = "UPDATE `users` SET  `username` =  '{$_POST['username']}' ,  `password` =  '{$hash}' ,  `salt` =  '{$salt}' ,  `userRole` =  '{$_POST['userRole']}' ,  `userStatus` =  '{$_POST['userStatus']}' ,  `userFirstName` =  '{$_POST['userFirstName']}' ,  `userLastName` =  '{$_POST['userLastName']}'   WHERE `id` = '$id' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
echo "<a href='index.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `users` WHERE `id` = '$id' ")); 
?>

<form action='' method='POST'> 
<p><b>Username:</b><br /><input type='text' name='username' value='<?= stripslashes($row['username']) ?>' /> 
<p><b>Password:</b><br /><input type='password' name='password' value='' /> 
<p><b>UserRole:</b><br /><input type='text' name='userRole' value='<?= stripslashes($row['userRole']) ?>' /> 
<p><b>UserStatus:</b><br /><input type='text' name='userStatus' value='<?= stripslashes($row['userStatus']) ?>' /> 
<p><b>UserFirstName:</b><br /><input type='text' name='userFirstName' value='<?= stripslashes($row['userFirstName']) ?>' /> 
<p><b>UserLastName:</b><br /><input type='text' name='userLastName' value='<?= stripslashes($row['userLastName']) ?>' /> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<? } ?> 
    
    
    </div> <!-- /container -->
    
  


	</body>
</html>