<?php
require "/Metier/Categorie.php";
require "/Metier/CategorieManager.php";
require "/Metier/ListeMotDefinition.php";
require "/Metier/ListeMotDefinitionManager.php";

function dbconnect(){
    static $connect = null;
    if ($connect === null) {
		$connect = mysql_connect (getProperty('db.host.name'), getProperty('db.user.name'), getProperty('db.user.mdp'));
-		mysql_select_db (getProperty('db.name'));
    }
    return $connect;
}

function dbPDO(){
    static $connect = null;
    if ($connect === null) {
		$dbhost = 'mysql:host='.getProperty('db.host.name').';dbname='.getProperty('db.name');
		$connect = new PDO($dbhost, getProperty('db.user.name'), getProperty('db.user.mdp'));
    }
    return $connect;
}

function getProperty($propertyName){
	$filename = "config.properties";
	global $props;
	if (file_exists($filename)) {
		$props = parse_ini_file($filename);
	}else{
		echo "fichier de propriété '".$filename."' introuvable<br>";
		die();
	}
	return $props[$propertyName];
}


function getConfigPage(){
	$configPage = new ConfigPage();
	$configPage->setPageName(getPage());
	initTitle($configPage->pageName());
	$configPage->setTitle($_ENV['title']);
	$configPage->setMetaContent($_ENV['metaContent']);
	return $configPage;
}

function getCategories($nb=0){
	$manager = new CategorieManager(dbPDO());
	return getLimiteListe($manager, $nb);
}

function getListesMotDefinition($nb=0){
	$manager = new ListeMotDefinitionManager(dbPDO());
	return getLimiteListe($manager, $nb);
}

function getLimiteListe($manager, $nb=0){
	$liste = $manager->getList();
	if($nb > 0){
		$liste = array_slice($liste ,0,$nb);
	}
	return $liste;	
}

function getPage(){
	$filename = "accueil.php";
	if(isset($_GET['page'])){
		$filename = $_GET['page'].".php";
		if(!file_exists($filename)){
			$filename = "error.php";
		}
	}
	return $filename;
}

function get_comment($news_id){
}

function insert_comment($comment){
}



class Mot{
	private $mot;
	private $traduction;
	private $commentaire;
	
	public function __construct(){
		$args = func_get_args(); 
        $nbArgs = func_num_args(); 
        if ($nbArgs == 3) { 
        	callConstructor($this, "__construct3", $nbArgs, $args);
        }else if($nbArgs == 1){
        	$arg = $args[0];
        	if(is_array($arg)){
        		callConstructor($this, "__construct2", $nbArgs, $arg);
        	}else if(is_string($arg)){
        		call_user_func_array(array($this,"__construct1"), $arg);
        	}
        }
    }       
    
    private function __construct1(String $motAsString){
    	$indexEgal = strrpos($motAsString, "=");
    	$indexCom = strrpos($motAsString, "{");
    	$this->mot = substr($motAsString, $indexEgal);
    	$this->traduction = substr($motAsString, $indexEgal, $indexCom);
    	$this->commentaire = substr($motAsString, $indexCom , $strlen($motAsString));
    }
    
    private function __construct2(array $motAsArray){
    	if(isset($motAsArray['mot']))$this->mot = $motAsArray['mot'];
    	if(isset($motAsArray['traduction']))$this->traduction = $motAsArray['traduction'];
    	if(isset($motAsArray['commentaire']))$this->commentaire = $motAsArray['commentaire'];
    }
    
    private function __construct3($mot, $traduction, $commentaire){
    	$this->mot = $mot;
    	$this->traduction = $traduction;
    	$this->commentaire = $commentaire;
    }
	
	public function mot(){
		return $this->mot;
	}
	public function setMot($p_mot){
		$this->mot = $p_mot;
	}
	public function traduction(){
		return $this->traduction;
	}
	public function setTraduction($p_traduction){
		$this->traduction = $p_traduction;
	}
	public function commentaire(){
		return $this->commentaire;
	}
	public function setCommentaire($p_commentaire){
		$this->commentaire = $p_commentaire;
	}
}

function callConstructor($instance, $constructName, $nbArgs, $args){
	$isValidConstruct = true;
	if (method_exists($instance, $constructName, $args)) {
		call_user_func_array(array($this, $constructName), $args);
	}else{
		trigger_error('Les arguments passé en parametre ne correspondent a aucun constructeur', E_USER_WARNING);
	}
}

class ConfigPage{
	private $pageName;
	private $title;
	private $metaContent;
	
	function pageName(){
		return $this->pageName;
	}	
	function setPageName($p_pageName){
		$this->pageName = $p_pageName;
	}
	
	function title(){
		return $this->title;
	}	
	function setTitle($p_title){
		$this->title = $p_title;
	}
	
	function metaContent(){
		return $this->metaContent;
	}	
	function setMetaContent($p_metaContent){
		$this->metaContent = $p_metaContent;
	}
}

class User{
	
}


?>