<?php
class Revision extends Entity{
	private $membre;
	private $id_liste;
	private $moyenne;
	private $date;
	
	public function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['pseudo']))$this->nom = $donnees['pseudo'];
		if(isset($donnees['id_liste']))$this->id_liste = $donnees['id_liste'];
		if(isset($donnees['moyenne']))$this->moyenne = $donnees['moyenne'];
		if(isset($donnees['date']))$this->date = $donnees['date'];
	}

	public function id(){
		return $this->id;
	}
	public function setId($p_id){
		$this->id= $p_id;
	}
	public function membre(){
		return $this->membre;
	}
	public function setMembre($p_membre){
		$this->membre = $p_membre;
	}
	public function id_liste(){
		return $this->id_liste;
	}
	public function setId_liste($p_id_liste){
		$this->id_liste = $p_id_liste;
	}
	public function moyenne(){
		return $this->moyenne;
	}
	public function setMoyenne($p_moyenne){
		$this->moyenne = $p_moyenne;
	}
	public function date(){
		return $this->date;
	}
	public function setDate($p_date){
		$this->date = $p_date;
	}
}
?>