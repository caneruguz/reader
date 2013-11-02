<?php
include_once('php/login.class.php');                           // Load login related functions and database
include_once('php/text.class.php');                           // Load login related functions and database

/* Check if the user is logged in or not */

if(!$Login->isLoggedIn())                       // If not logged in ...
	{
	header('Location: login.php');      // Send them to the login page. No need for message.
	die();
}

if(!isset($_GET['t'])){
	header('Location: index.php');      // Send them to the login page. No need for message.
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

    <script type="text/javascript" src="js/jquery-1.7.1.min.js"></script>
    <script type="text/javascript" src="js/jquery-ui-1.8.21.custom.min.js"></script>
    <script type="text/javascript" src="js/jquery.scrollTo-min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/text.js"></script>

    <link href="css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="css/style.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="css/start/jquery-ui-1.10.0.custom.css" media="screen" rel="stylesheet" type="text/css" />


	<script type="text/javascript">
		var Text = new TextJS(); 
	</script>
	</head>
	<body>


    <div class="container">

	    <div class="page">
		    <div id="pageHeader">
		    	<div id="textTitle"></div>
		  
		    </div>
		    <hr class="soften">
		  
		    <div id="pageContent">
		    	<div id="lineNumbers"></div>
		    	<div id="contentText"></div>
		    </div>
		    <hr class="soften">

		    <div id="pageFooter">
		    <p>

				<div class="btn-group">
				  <button type="button" class="btn " id="previous"><i class="icon-chevron-left"></i> Previous </button>
				  <button type="button" class="btn btn-primary"> <span id="pageLabel"></span> </button>
				  <button type="button" class="btn " id="next"> Next <i class="icon-chevron-right"></i></button>
				</div>
				</p>
				 
				<div id="pageSlider"></div>
		    </div>
	    	    	    
	    </div>
	   

  
    </div> <!-- /container -->
    
  <div id="toolbar">
	  <div class="toolbarMenu" id="blue">
		  <div class="toolbarIcon blueDot" id="blueDot"></div>
		  <div class="toolbarText" id="blueText">REMINDS ME OF...</div>
	  </div>

	  <div class="toolbarMenu" id="green">
		  <div class="toolbarIcon greenDot" id="greenDot"></div>
		  <div class="toolbarText" id="greenText">A-HA!</div>		  
	  </div>
	  
	  <div class="toolbarMenu" id="red">
		  <div class="toolbarIcon redDot" id="redDot"></div>
		  <div class="toolbarText" id="redText">PREDICTION</div>		  
	  </div>	  

	  <div class="toolbarMenu" id="undo">
		  <div class="toolbarIcon" id="undoIcon"><i class="icon-backward"></i></div>
		  <div class="toolbarText undoTextLight" id="undoText">UNDO LAST HIGHLIGHT</div>		  
	  </div>
	 	   
	  <div class="toolbarMenu" id="logout">
		  <div class="toolbarIcon" id="logoutIcon"><i class="icon-off"></i></div>
		  <div class="toolbarText" id="lineOffText"> <a class="" href="php/auth.php?logout=true">LOGOUT</a></div>		  
	  </div>

  </div>




<div id="messageBox" class="hide">
	<div id="form">
		<textarea name="messageText" id="messageText" placeholder="Enter your comment"></textarea>
		<input type="hidden" name="locationIDhidden" id="locationIDhidden" val=''>
		<input type="hidden" name="currentHighlight" id="currentHighlight" val=''>
		<button class="btn  btn-info" id="cancelMessage"> Cancel </button>
		<button class="btn  btn-primary" id="addMessage"> Post </button>
		
	</div>
</div>
<div id="commentbox" class="hide"></div>

<input type="hidden" id="personid" name="personid" value="<?php echo $_SESSION['personid']; ?>" >
	</body>
</html>