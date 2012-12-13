<?php
class Erreur extends Entity{
	private $id_liste;
	private $membre;
	
	function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['id_liste']))$this->id_liste = $donnees['id_liste'];
		if(isset($donnees['pseudo']))$this->membre = $donnees['pseudo'];
		if(isset($donnees['type']))$this->type = $donnees['type'];
		if(isset($donnees['message']))$this->message = $donnees['message'];
		if(isset($donnees['date']))$this->date = $donnees['date'];
	}
	
	public function id(){
		return $this->id;
	}
	public function setId($p_id){
		$this->id= $p_id;
	}
	
	public function id_liste(){
		return $this->id_liste;
	}
	public function setId_liste($p_id_liste){
		$this->id_liste = $id_liste;
	}
	
	public function membre(){
		return $this->membre;
	}
	public function setMembre($membre){
		$this->membre = $membre;
	}
	
	public function type(){
		return $this->type;
	}
	public function setType($type){
		$this->type = $type;
	}
	
	public function message(){
		return $this->message;
	}
	public function setMessage($message){
		$this->message = $message;
	}
	
	public function date(){
		return $this->date;
	}
	public function setDate($date){
		$this->date = $date;
	}
}
?>