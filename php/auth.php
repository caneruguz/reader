<?php
/*  This file authenticates the user after login form is submitted  */

include('login.class.php');        // Load login related functions and database


/*********  LOGIN FUNCTION  *********/

if(isset($_POST['loginSubmit'])){

	/* Fill user information. */

	$username = $_POST['username'];
	$password = $_POST['password'];


	/* Check the database to see if this user exists.  */
	$username = mysql_real_escape_string($username);    // first sanitize the username.
	$query = "SELECT password, salt, id, userRole FROM users WHERE username = '".$username."';"; // Check if there is a row with this username
	$result = mysql_query($query);         // Get results from the database
	if(mysql_num_rows($result) == 0)         // If there are less than 1 rows, i.e. no user exists
		{
		header('Location: ../login.php?m=3');       // Send them back to the login form with an error message.  Message text for code 3 will be on that page.
		exit();
	} else {
		$userData = mysql_fetch_array($result, MYSQL_ASSOC);   // If there is a username add returned information into an array
		$userid   = $userData['id'];          // Point out the userid for convenience
		$userRole = $userData['userRole'];
		$hash = hash('sha256', $userData['salt'] . hash('sha256', $password) );   // Checking password
		if($hash != $userData['password'])         // If the password entered does NOT match
			{
			header('Location: ../login.php?m=4');       // Send them back to the login form with an error message.
			die();
		} else {
			$Login->validateUser($userid, $username, $userRole);         //sets the session data for this user
			   if(isset($_POST['remme'])) 
			    { 
			        //Add additional member to cookie array as per requirement 
			        setcookie("personid", $_SESSION['personid'], time()+60*60*24*100, "/"); 
			        setcookie("username", $_SESSION['username'], time()+60*60*24*100, "/"); 
			        setcookie("userRole", $_SESSION['userRole'], time()+60*60*24*100, "/"); 
			    } 
			header('Location: ../index.php');
			exit();
		}
	}
}

if(isset($_POST['registerSubmit'])){

	/* Get the values from the form. */
	$user = $_POST['username'];  // The name of the user.
	$pass1 = $_POST['pass1'];  // The first password input.
	$pass2 = $_POST['pass2'];  // The second password input.

	$message = $Login->validateRegister($user, $pass1, $pass2);
	if($message != 0){
		header('Location: ../register.php?m='.$message.'&u='.$user);
		exit();
	} else {
		/* Convert password to a hash string. */
		$hash = hash('sha256', $pass1);
		$salt = $Login->createSalt();
		$hash = hash('sha256', $salt . $hash);

		/* Enter the data into the database. */
		$username = mysql_real_escape_string($user);   // Sanitize the username to avoid sql injection
		$query = "INSERT INTO users ( username, password, salt ) VALUES ( '$username' , '$hash' , '$salt' );";  // A simple query to enter a row into the table users.
		mysql_query($query);
		mysql_close();
		header('Location: ../login.php?m=6');
		exit();
	}
}

if(isset($_GET['logout'])){
	session_start();
	$_SESSION = array(); //destroy all of the session variables
	session_unset();
	session_destroy(); 

    setcookie ("userid", "",time()-60*60*24*100, "/"); 
    setcookie ("username", "",time()-60*60*24*100, "/"); 
    setcookie ("userRole", "",time()-60*60*24*100, "/"); 
 

	header('Location: ../public.php?m=5');
	exit();
	
}




/* End of file auth.php */