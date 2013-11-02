<?php

/*
 * Login related functions.
 *
 */

/* Include database connection configuration file.
	- Use the exact same file as provided but remember to include your actual database information.
 */
define('MyConst', TRUE); // Avoids direct access to config.php
include_once('config.php');

class Login {


	/* 	Function for checking if the user is logged in.
	You will need to repeat this procedure on every page you need secured.
 */
	function isLoggedIn()
	{
		if(isset($_SESSION['valid']) && $_SESSION['valid'] == 1){
			return true;
		} else if(isset($_COOKIE['username']) && isset($_COOKIE['personid']) && isset($_COOKIE['userRole'])) {
			$this->validateUser($_COOKIE['personid'], $_COOKIE['username'],$_COOKIE['userRole']);
			return true; 
		}
		return false;
	}

	/* 	Function for creating a salt value for added security.
 */
	function createSalt()
	{
		$string = md5(uniqid(rand(), true));
		return substr($string, 0, 3);
	}

	/* This function is to create the session elements that will keep the user logged in..
	- These values come from the login form.
*/
	function validateUser($userid, $username, $userRole)
	{
		session_regenerate_id(); //this is a security measure
		$_SESSION['valid'] = 1;
		$_SESSION['personid'] = $userid;       // We save the user id to the session
		$_SESSION['username'] = $username;      // We save the username as well, your code will most likely need it.
		$_SESSION['userRole'] = $userRole;
	}

	function printErrors($errorid){
		switch ($errorid) {
		case 3:
			return 'There is no such user in the system.';
			break;
		case 1:
			return 'The passwords you entered did not match, please try again.';
			break;
		case 2:
			return 'The username needs to be between 3 and 30 characters. ';
			break;
		case 4:
			return 'The password you entered did not match our records for this user, please try again.';
			break;
		case 5:
			return 'You logged out successfully!';
			break;
		case 6:
			return 'You register successfully. Log in to start using the site.';
			break;
		case 7:
			return 'Please enter a password between 4 and 20 characters.';
			break;
		}
	}

	function validateRegister($user, $pass1, $pass2) {
		$m = 0;
		/* Validate form data.  */
		if($pass1 != $pass2) {       // Check if passwords match
			$m = 1;      // If not send them back to the login page. The message is 1, we will fill this in at the register_form page.
		}
		if(strlen($pass1) > 30 || strlen($pass1) < 4){
			$m = 7;      // This time the message is 2, we will fill this in at the register_form page.
		}
		if(strlen($user) > 30 || strlen($user) < 3){
			$m = 2;      // This time the message is 2, we will fill this in at the register_form page.
		}
		return $m;
	}


}

$Login = new Login();

/* End of file login.class.php */