<?php 
/*
 * Text related functions.
 *
 */

 
define('MyConst', TRUE); // Avoids direct access to config.php
include_once('config.php');

class Text {


	public function UserName($userID){
		/*  
		 *  Gets the full name of the user
		 */
		$query = mysql_query("SELECT userFirstName, userLastName FROM users WHERE id = '".$userID."' ");
		$results = mysql_fetch_array($query); 
		return $results[0] . ' ' . $results[1]; 
	}

	function myTruncate($string, $limit, $break=".", $pad="...")
	{
	  // return with no change if string is shorter than $limit
	  if(strlen($string) <= $limit) return $string;
	
	  // is $break present between $limit and the end of the string?
	  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
	    if($breakpoint < strlen($string) - 1) {
	      $string = substr($string, 0, $breakpoint) . $pad;
	    }
	  }
	
	  return $string;
	}







}

$Text = new Text();

/* End of file text.class.php */