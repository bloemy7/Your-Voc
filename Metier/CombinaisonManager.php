<?php
class CombinaisonManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "combiner";
	public $entityName = "Combinaison";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["liste"] = "liste";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["titre"] = "titre";
		$this->arrayBinding["id_liste"] = "id_liste";
	}
	
	protected function newInstanceEntity($donnees){
		return new Combinaison($donnees);
	}
	
	public function getCombinaisonByPseudoLimit5($pseudo){
		$query = "select * from ".$this->table." where pseudo = :pseudo ORDER BY id DESC LIMIT 5";
		$entity = new Combinaison(array("pseudo"=>$pseudo));
		return $this->select($query, $entity);		
	}
	public function getCombinaisonByPseudoLimit15($pseudo){
		$query = "select * from ".$this->table." where pseudo = :pseudo ORDER BY id DESC LIMIT 15";
		$entity = new Combinaison(array("pseudo"=>$pseudo));
		return $this->select($query, $entity);
	}
}
?>