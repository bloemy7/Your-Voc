<?php
function dbconnect(){
    static $connect = null;
    if ($connect === null) {
		$connect = mysql_connect (getProperty('db.host.name'), getProperty('db.user.name'), getProperty('db.user.mdp'));
		mysql_select_db (getProperty('db.name'));
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
	private $general;
	
	public function __construct ($name, $general){
		$this->name = $name;
		$this->general = $general;
    }   
	
	public function name(){
		return $this->name;
	}
	public function setMot($p_name){
		$this->name = $p_name;
	}
	public function general(){
		return $this->general;
	}
	public function setGeneral($p_general){
		$this->general = $p_general;
	}
}
?>