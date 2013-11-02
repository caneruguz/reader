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
if (isset($_GET['textID']) ) { 
$textID = (int) $_GET['textID']; 
if (isset($_POST['submitted'])) { 
foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
$sql = "UPDATE `texts` SET  `textTitle` =  '{$_POST['textTitle']}' ,  `textContent` =  '{$_POST['textContent']}' ,  `textAuthor` =  '{$_POST['textAuthor']}' ,  `textAddedBy` =  '{$_POST['textAddedBy']}'   WHERE `textID` = '$textID' "; 
mysql_query($sql) or die(mysql_error()); 
echo (mysql_affected_rows()) ? "Edited row.<br />" : "Nothing changed. <br />"; 
echo "<a href='index.php'>Back To Listing</a>"; 
} 
$row = mysql_fetch_array ( mysql_query("SELECT * FROM `texts` WHERE `textID` = '$textID' ")); 
?>

<form action='' method='POST' class="form"> 
<p><b>Title:</b><br /><textarea name='textTitle'><?= stripslashes($row['textTitle']) ?></textarea> 
<p><b>Content:</b><br /><textarea name='textContent'><?= stripslashes($row['textContent']) ?></textarea> 
<p><b>Author:</b><br /><textarea name='textAuthor'><?= stripslashes($row['textAuthor']) ?></textarea> 
<p><b>Added By:</b><br /><textarea name='textAddedBy'><?= stripslashes($row['textAddedBy']) ?></textarea> 
<p><input type='submit' value='Edit Row' /><input type='hidden' value='1' name='submitted' /> 
</form> 
<? } ?> 


    </div> <!-- /container -->
    
  


	</body>
</html>