<?php
	include("modelDAO.php");
	include("title.php");
	$hostDomain = getProperty("application.host");
	$redirection = 'Location: http://'.$hostDomain.$_SERVER['REQUEST_URI'];
	if ($_SERVER['HTTP_HOST'] == "") {		
		header($redirection);		
	}
	/*else{
		echo $redirection."<br>".$_SERVER['HTTP_HOST']."<br>".$_SERVER['REQUEST_URI'];
	}*/
	session_start();
	dbconnect();
	
	function getListeMotByUser($user){
	
	}
?>