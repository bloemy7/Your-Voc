<?php
class RevisionManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "revise";
	public $entityName = "Revision";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding["id_liste"] = "id_liste";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["moyenne"] = "moyenne";
		$this->arrayBinding["date"] = "date";
	}
	
	protected function newInstanceEntity($donnees){
		return new Revision($donnees);
	}
	
	public function getRevisionsByPseudoLimit20($pseudo){
		$query = "select * from ".$this->table." where pseudo = :pseudo ORDER BY id DESC LIMIT 20";
		$entity = new ListeMotDefinition();
		$entity->setMembre($pseudo);
		return $this->select($query, $entity);
	}
	public function getRevisionsByPseudoLimit3($pseudo){
		$query = "select * from ".$this->table." where pseudo = :pseudo ORDER BY id DESC LIMIT 3";
		$entity = new ListeMotDefinition();
		$entity->setMembre($pseudo);
		return $this->select($query, $entity);
	}
}
?>