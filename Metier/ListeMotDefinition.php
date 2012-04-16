<?php
class ListeMotDefinition{
	private $id;
	private $titre;
	private $membre;
	private $listeMot;// = array();	
	private $date;
	private $categorie;
	private $categorie2;
	private $note;
	private $vue;
	private $commentaire;
	private static $separator = " ";
	
	public function __construct (array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['titre']))$this->titre = $donnees['titre'];
		if(isset($donnees['pseudo']))$this->membre = $donnees['pseudo'];
		if(isset($donnees['liste'])){
			//$this->listeMot = explode($separator, $donnees['listeMot']);
			$this->listeMot = $donnees['liste'];
		}
		if(isset($donnees['categorie']))$this->categorie = $donnees['categorie'];
		if(isset($donnees['categorie2']))$this->categorie2 = $donnees['categorie2'];
		if(isset($donnees['note']))$this->note = $donnees['note'];
		if(isset($donnees['vue']))$this->vue = $donnees['vue'];
		if(isset($donnees['commentaire']))$this->commentaire = $donnees['commentaire'];
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
	public function membre(){
		return $this->membre;
	}
	public function setMembre($membre){
		$this->membre = $membre;
	}
}
?>