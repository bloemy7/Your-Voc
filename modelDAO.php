<?php
function dbconnect(){
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

function getAllCategorie(){
	$manager = new CategoriesManager(dbconnect());
	return $manager->getList();
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

class ListeMotDefinition{
	private $id;
	private $listeMot = array();
	private $titre;
	private $date;
	private $categorie;
	private $categorie2;
	private $note;
	private $vue;
	private $commentaire;
	
	public function __construct ($listeMot, $titre, $date, $categorie, $categorie2, $note, $vue, $commentaire){
		$this->listeMot = $listeMot;
		$this->titre = $titre;
		$this->date = $date;
		$this->categorie = $categorie;
		$this->categorie2 = $categorie2;
		$this->note = $note;
		$this->vue = $vue;
		$this->commentaire = $commentaire;
    }        
	
	public function id(){
		return $this->id;
	}
	public function listeMot(){
		return $this->listeMot;
	}
	public function setListeMot($p_listeMot){
		if ($p_listeMot == null) {
                trigger_error('La liste de mot ne doit pas être null', E_USER_WARNING);
                return;
        }
		$this->listeMot = $p_listeMot;
	}
	public function titre(){
		return $this->titre;
	}
	public function setTitre($p_titre){
		$this->titre = $p_titre;
	}
	public function date(){
		return $this->date;
	}
	public function setDate($p_date){
		$this->date = $p_date;
	}
	public function categorie(){
		return $this->categorie;
	}
	public function setCategorie($p_categorie){
		$this->categorie = $p_categorie;
	}
	public function categorie2(){
		return $this->categorie2;
	}
	public function setCategorie2($p_categorie2){
		$this->categorie2 = $p_categorie2;
	}
	public function note(){
		return $this->note;
	}
	public function setNote($p_note){
		$this->note = $p_note;
	}
	public function vue(){
		return $this->vue;
	}
	public function setVue($p_vue){
		$this->vue = $p_vue;
	}
	public function commentaire(){
		return $this->commentaire;
	}
	public function setCommentaire($p_commentaire){
		$this->commentaire = $p_commentaire;
	}
}

class Mot{
	private $mot;
	private $traduction;
	private $commentaire;
	
	public function __construct ($mot, $traduction, $commentaire){
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

class Categorie{
	private $id;
	private $name;
	private $groupe;
	private $url;
	private $nbListe;
	
	public function hydrate(array $donnees){
		if(isset($donnees['id']))$categorie->id($donnees['id']);
		if(isset($donnees['categorie']))$categorie->setName($donnees['categorie']);
		if(isset($donnees['url']))$categorie->setUrl($donnees['url']);
		if(isset($donnees['general']))$categorie->setGroupe($donnees['general']);
		if($this->name() != null)$categorie->setNbListe(getNbListeByCategorie($this->name()));
	}

	public function id(){
		return $this->id;
	}
	public function setId($p_id){
		$this->id= $p_id;
	}
	public function name(){
		return $this->name;
	}
	public function setMot($p_name){
		$this->name = $p_name;
	}
	public function groupe(){
		return $this->groupe;
	}
	public function setGroupe($p_groupe){
		$this->groupe = $p_groupe;
	}
	public function url(){
		return $this->url;
	}
	public function setUrl($p_url){
		$this->url = $p_url;
	}
	public function nbListe(){
		return $this->nbListe;
	}
	public function setNbListe($p_nbListe){
		$this->nbListe = $p_nbListe;
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

class CategoriesManager {
	private $_db; // Instance de PDO
	private $table = "categories";
	
	public function __construct($db){
		$this->setDb($db);
	}
	
	public function add(Categorie $categorie){
		$q = $this->_db->prepare("INSERT INTO ".$this->table." SET categorie = :nom, url = :url, general = :groupe");		
		$q->bindValue(':nom', $categorie->nom());
		$q->bindValue(':url', $categorie->url());
		$q->bindValue(':groupe', $categorie->groupe());		
		$q->execute();
	}
	
	public function getNbListeByCategorie($nomCategorie){
		$result = mysql_query("SELECT * FROM listes_public WHERE categorie = '$nomCategorie' OR categorie2 = '$nomCategorie'")or die(mysql_error());
		return mysql_num_rows($result);
	}
	
	public function delete(Categorie $categorie){
		$this->_db->exec('DELETE FROM '.$this->table.' WHERE id = '.$categorie->id());
	}
	
	public function get($id){
		$id = (int) $id;		
		$q = $this->_db->query('SELECT id, categorie, url, general FROM '.$this->table.' WHERE id = '.$id);
		$donnees = $q->fetch(PDO::FETCH_ASSOC);		
		return new Categorie($donnees);
	}
	
	public function getList(){
		$categories = array();		
		$q = $this->_db->query('SELECT id, categorie, url, general FROM '.$this->table.' ORDER BY categorie');		
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){
			$donnees['nbListe'] = $this->getNbListeByCategorie($donnees['categorie']);
			$categories[] = new Categorie($donnees);
		}		
		return $categories;
	}
	
	public function update(Categorie $categorie){
		$q = $this->_db->prepare('UPDATE '.$this->table.' SET categorie = :nom, url = :url, general = :groupe, experience = :experience WHERE id = :id');		
		$q->bindValue(':nom', $categorie->nom(), PDO::PARAM_INT);
		$q->bindValue(':url', $categorie->url(), PDO::PARAM_INT);
		$q->bindValue(':groupe', $categorie->groupe(), PDO::PARAM_INT);
		$q->bindValue(':id', $categorie->id(), PDO::PARAM_INT);		
		$q->execute();
	}
	
	public function setDb(PDO $db){
		$this->_db = $db;
	}
}
?>