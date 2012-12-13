<?php
class Vote extends Entity{
	private $id_liste;
	private $membre;
	private $note;
	
	function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['id_liste']))$this->id_liste = $donnees['id_liste'];
		if(isset($donnees['pseudo']))$this->membre = $donnees['pseudo'];
		if(isset($donnees['note']))$this->note = $donnees['note'];
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
	
	public function note(){
		return $this->note;
	}
	public function setNote($note){
		$this->note = $note;
	}
}
?>