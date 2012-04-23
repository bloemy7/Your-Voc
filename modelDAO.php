<?php
require "/Metier/DBHelper.php";
require "/Metier/Entity.php";
require "/Metier/DbManager.php";
require "/Metier/Categorie.php";
require "/Metier/CategorieManager.php";
require "/Metier/ListeMotDefinition.php";
require "/Metier/ListeMotDefinitionManager.php";
require "/Metier/Membre.php";
require "/Metier/MembreManager.php";



function dbconnect(){
	dbConfiguration();
    static $connect = null;
    if ($connect === null) {
		$connect = mysql_connect (getProperty('db.host.name'), getProperty('db.user.name'), getProperty('db.user.mdp'));
		mysql_select_db (getProperty('db.name'));
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

function dbConfiguration(){
	DBHelper::addManager(new CategorieManager());
	DBHelper::addManager(new ListeMotDefinitionManager());
	DBHelper::addManager(new MembreManager());
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

function getMembre($login, $mdp){
	$liste = DBHelper::getDBManager("Membre")->getMembre($login);
	$result = "Votre identifiant est inconnu, merci de vous inscrire pour vous connecter";
	if(count($liste) == 1){
		$result = $liste[0];
		if(md5($mdp) != $liste[0]->pass()){
			$result = "Votre mot de passe est incorrect";
		}
	}else if(count($liste) > 1){
		$result = "Une erreur dans notre base est surevenu plusieur membres porte le même login. Merci de contacter l'administrateur du site.";
	}
	return $result;
}

function getConfigPage(){
	$configPage = new ConfigPage();
	$configPage->setPageName(getPage());
	initTitle($configPage->pageName());
	$configPage->setTitle($_ENV['title']);
	$configPage->setMetaContent($_ENV['metaContent']);
	return $configPage;
}



function getCategoriesWithNbListe($nb=0){
	$categories = getCategories($nb);
	$managerListeMot = DBHelper::getDBManager("ListeMotDefinition");
	foreach($categories as $categorie){
		$categorie->setNbListe($managerListeMot->getNbListeByCategorie($categorie->name()));
	}
	return $categories;
}

function getCategories($nb=0){
	$categories = getLimiteListe(DBHelper::getDBManager("Categorie"), $nb);
	return $categories;
}

function getListesMotDefinition($nb=0){
	return getLimiteListe(DBHelper::getDBManager("ListeMotDefinition"), $nb);
}

function getListeMotByCritere(array $critere){
	return DBHelper::getDBManager("ListeMotDefinition")->getListeByCritere($critere);
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

?>