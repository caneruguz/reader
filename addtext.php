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
include('php/config.php'); 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "INSERT INTO `texts` ( `textTitle` ,  `textContent` ,  `textAuthor` ,  `textAddedBy`  ) VALUES(  '{$_POST['textTitle']}' ,  '{$_POST['textContent']}' ,  '{$_POST['textAuthor']}' ,  '{$_POST['textAddedBy']}'  ) "; 
mysql_query($sql) or die(mysql_error()); 
echo "Added row.<br />"; 
echo "<a href='index.php'>Back To Listing</a>"; 
} 
?>

<form action='' method='POST'> 
<p><b>Title:</b><br /><textarea name='textTitle'></textarea> 
<p><b>Content:</b><br /><textarea name='textContent'></textarea> 
<p><b>Author:</b><br /><textarea name='textAuthor'></textarea> 
<p><b>TextAddedBy:</b><br /><textarea name='textAddedBy' val="<?php echo $_SESSION['personid']; ?>"></textarea> 
<p><input type='submit' value='Add Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 


   
   
    </div> <!-- /container -->
    
  


	</body>
</html>