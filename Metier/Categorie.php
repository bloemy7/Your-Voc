<?php
class Categorie extends Entity{
	private $name;
	private $groupe;
	private $url;
	private $nbListe;
	
	public function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['categorie']))$this->name = $donnees['categorie'];
		if(isset($donnees['url']))$this->url = $donnees['url'];
		if(isset($donnees['general']))$this->groupe = $donnees['general'];
		if(isset($donnees['nbListe']))$this->nbListe = $donnees['nbListe'];
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
	public function setName($p_name){
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
?>