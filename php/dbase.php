<?php 

define('MyConst', TRUE); // Avoids direct access to config.php
include_once('config.php');
    header('Content-type: application/json');							// Set headers for transferring the data between php and ajax    


$action	= $_POST['action'];									// What the ajax call asks the php to do. 

if ($action == 'getText')
{
	GetTextRow();     
}
if ($action == 'newHighlight')
{
	NewHighlight();     
}
if ($action == 'addMessage')
{
	addMessage();     
}
if ($action == 'deleteHighlight')
{
	DeleteHighlight();   
}

function GetTextRow(){
/*  
 *  Gets all the information for specific text
 */

	$textID = $_POST['textID'];
	$results = array(); 
	$user = $_SESSION['personid']; 
	$h = array(); 
	
	$query = mysql_query("SELECT * FROM texts WHERE textID = '".$textID."' ");
	$results['text'] = mysql_fetch_array($query); 
	
	// Add section to retrieve highlights as well. 
	$highlights = mysql_query("SELECT * FROM `highlights` WHERE `hUser` = '".$user."' AND `hText` = '".$textID."' "); 

	while($r = mysql_fetch_assoc($highlights)) 
	{					
		$h[] = $r;
	}

	$results['highlights'] = $h; 	
	
	echo json_encode($results); 
}


function NewHighlight(){
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
	$sql = "INSERT INTO `highlights` ( `hCode` , `hUser` ,  `hText` , `hPage` ,  `hBegin` ,  `hEnd`,  `hComment`,  `hType`,   `hContent`  ) VALUES(  '{$_POST['hCode']}' , '{$_POST['hUser']}' ,  '{$_POST['hText']}' ,'{$_POST['hPage']}' ,  '{$_POST['hBegin']}' ,  '{$_POST['hEnd']}' ,   '{$_POST['hComment']}', '{$_POST['hType']}', '{$_POST['hContent']}'   ) "; 
	mysql_query($sql) or die(mysql_error()); 

}  

function AddMessage(){
	foreach($_POST AS $key => $value) { $_POST[$key] = mysql_real_escape_string($value); } 
	
	$sql = "UPDATE `highlights` SET `hComment`	= '".$_POST['hComment']."'   WHERE `hCode` = ".$_POST['hCode']." "; 
	mysql_query($sql) or die(mysql_error()); 
	
} 

function DeleteHighlight(){
$hCode = (int) $_POST['hCode']; 
mysql_query("DELETE FROM `highlights` WHERE `hCode` = '$hCode' ") ; 
	
}   
  
  /* end of dbase.php */