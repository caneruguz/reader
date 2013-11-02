<?php 
if(!defined('MyConst')){die('Direct access not permitted');}   // This is in case of direct  access to this file, it's unlikely but more secure. 
 
session_start();  
  
 $dbhost = "internal-db.s115312.gridserver.com"; 		 // Your database name. If hosted this is most like to stay as localhost. 
 $dbname = "db115312_jake"; 			 // the name of the database   
 $dbuser = "db115312_caner";				 // the username   
 $dbpass = "19Tpo!22903"; 				 // the awesome password   
 
define('CLIENT_LONG_PASSWORD', 1);
mysql_connect($dbhost, $dbuser, $dbpass) or die("MySQL Error: " . mysql_error());  // Connect to the database
mysql_select_db($dbname) or die("MySQL Error: " . mysql_error());  					// Select the database name



/* End of file config.php */

