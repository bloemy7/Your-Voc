<?php
class Vote extends Entity{
	private $listesDefinition;
	private $membre;
	private $note;
	
	function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['id_liste']))$this->listesDefinition = $donnees['id_liste'];
		if(isset($donnees['pseudo']))$this->membre = $donnees['pseudo'];
		if(isset($donnees['note']))$this->note = $donnees['note'];
	}
	
	public function id(){
		return $this->id;
	}
	public function setId($p_id){
		$this->id= $p_id;
	}
	
	public function listesDefinition(){
		return $this->listesDefinition;
	}
	public function setListesDefinition($p_listesDefinition){
		$this->listesDefinition = $listesDefinition;
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