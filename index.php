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
	    <h1> Text Tool </h1>
	    <p> Welcome to the text tool. This text will provide introductory text. For more information about how to use this tool please see Help Page </p> 

	    <hr class="soften"> 

		<div class="row-fluid">
		  <div class="span12" id="textList">
			  <h2>Texts</h2>

<? 
echo "<table class='table table-striped' >"; 
echo "<tr>"; 
echo "<td><b>Id</b></td>"; 
echo "<td><b>Title</b></td>"; 
echo "<td><b>Content</b></td>"; 
echo "<td><b>Author</b></td>"; 
echo "<td><b>Added By</b></td>"; 
echo "<td><b>Timestamp</b></td>";
echo "<td></td><td></td>";  
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `texts`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
$content = nl2br( $row['textContent']);
$content = $Text->myTruncate($content, 300);  
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['textID']) . "</td>";  
echo "<td valign='top'><a href='text.php?t=".nl2br( $row['textID'])."' > " . nl2br( $row['textTitle']) . "</a></td>";  
echo "<td valign='top'>" . $content . "</td>";  
echo "<td valign='top'>" . nl2br( $row['textAuthor']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['textAddedBy']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['textextTimestamp']) . "</td>";  
echo "<td valign='top'><a href=edittext.php?textID={$row['textID']}>Edit</a></td><td><a href=deletetext.php?textID={$row['textID']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
echo "<a href=addtext.php>New Row</a>"; 
?>
			  
			  
		  </div>
		 
		</div>
		<hr class="soften">
		<div class="row-fluid">
			<div class="span12" id="userList">
			  <h2>Users</h2>
<? 
echo "<table class='table table-striped'>"; 
echo "<tr>"; 
echo "<td><b>Id</b></td>"; 
echo "<td><b>Username</b></td>"; 
echo "<td><b>Role</b></td>"; 
echo "<td><b>Status</b></td>"; 
echo "<td><b>First Name</b></td>"; 
echo "<td><b>Last Name</b></td>";
echo "<td></td><td></td>"; 
echo "</tr>"; 
$result = mysql_query("SELECT * FROM `users`") or trigger_error(mysql_error()); 
while($row = mysql_fetch_array($result)){ 
foreach($row AS $key => $value) { $row[$key] = stripslashes($value); } 
echo "<tr>";  
echo "<td valign='top'>" . nl2br( $row['id']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['username']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['userRole']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['userStatus']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['userFirstName']) . "</td>";  
echo "<td valign='top'>" . nl2br( $row['userLastName']) . "</td>";  
echo "<td valign='top'><a href=edituser.php?id={$row['id']}>Edit</a></td><td><a href=deleteuser.php?id={$row['id']}>Delete</a></td> "; 
echo "</tr>"; 
} 
echo "</table>"; 
echo "<a href=adduser.php>New Row</a>"; 
?>

				
			</div>
		</div>


    </div> <!-- /container -->
    
  


	</body>
</html>