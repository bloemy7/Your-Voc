<?php
class ListeMotDefinition extends Entity{
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
	
	public function __construct (){}        
	
    public function setDatas(array $donnees){
    }
    
	public function id(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function listeMot(){
		return $this->listeMot;
	}
	public function setListeMot($listeMot){
		if ($listeMot == null) {
                trigger_error('La liste de mot ne doit pas être null', E_USER_WARNING);
                return;
        }
		$this->listeMot = $listeMot;
	}
	public function titre(){
		return $this->titre;
	}
	public function setTitre($titre){
		$this->titre = $titre;
	}
	public function date(){
		return $this->date;
	}
	public function setDate($date){
		$this->date = $date;
	}
	public function categorie(){
		return $this->categorie;
	}
	public function setCategorie($categorie){
		$this->categorie = $categorie;
	}
	public function categorie2(){
		return $this->categorie2;
	}
	public function setCategorie2($categorie2){
		$this->categorie2 = $categorie2;
	}
	public function note(){
		return $this->note;
	}
	public function setNote($note){
		$this->note = $note;
	}
	public function vue(){
		return $this->vues;
	}
	public function setVue($vue){
		$this->vues = $vue;
	}
	public function commentaire(){
		return $this->commentaire;
	}
	public function setCommentaire($commentaire){
		$this->commentaire = $commentaire;
	}
	public function membre(){
		return $this->membre;
	}
	public function setMembre($membre){
		$this->membre = $membre;
	}
}
?>