<?php
	require_once("modelDAO.php");
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
	
	require_once("title.php");
	
	function getIdCookie(){
		if (!isset($_SESSION['login']) && !empty($_COOKIE['id']) && !empty($_COOKIE['connexion_auto'])){
			return $_COOKIE['id'];
		}
		return null;
	}
	
	function initCookie($membre){
		if(isset($membre) && $membre!=null){
			setcookie( 'id', $_SESSION['id'], strtotime("+1 year"), '/');
			setcookie('connexion_auto', getHash($membre->login(), $membre->id()), strtotime("+1 year"), '/');
			return true;
		}
		return false;
	}
	
	function isCookieValid($membre){
		if(getHash($login, $id) == getHash($membre->login(), $membre->id())){
			return true;
		}
		return false;
	}
	
	function getNavigateur(){
		return (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : '';
	}
	
	function getHash($login, $id){
		return sha1('yes'.$login.'set'.$id.'treb'.getNavigateur().'crac');
	}
?>