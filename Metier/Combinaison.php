<?php
class Commentaire extends Entity{
	private $idListeOrigine;
	private $membre;
	private $liste;
	private $titre;
	
	function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['liste']))$this->liste = $donnees['liste'];
		if(isset($donnees['pseudo']))$this->membre = $donnees['pseudo'];
		if(isset($donnees['titre']))$this->titre = $donnees['titre'];
		if(isset($donnees['id_liste']))$this->id_listeOrigine = $donnees['id_liste'];
	}
	
	public function id(){
		return $this->id;
	}
	public function setId($p_id){
		$this->id= $p_id;
	}
	
	public function liste(){
		return $this->liste;
	}
	public function setListesDefinition($liste){
		$this->liste = $liste;
	}
	
	public function membre(){
		return $this->membre;
	}
	public function setMembre($membre){
		$this->membre = $membre;
	}
	
	public function titre(){
		return $this->titre;
	}
	public function setTitre($titre){
		$this->commentaire = $titre;
	}
	
	public function idListeOrigine(){
		return $this->id_liste;
	}
	public function setIdListeOrigine($idListe){
		$this->idListeOrigine = $idListe;
	}
}
?>