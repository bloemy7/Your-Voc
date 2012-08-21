<?php
class CategorieManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "categories";
	public $entityName = "Categorie";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding["categorie"] = "nom";
		$this->arrayBinding["url"] = "url";
		$this->arrayBinding["general"] = "general";
	}
	
	protected function newInstanceEntity($donnees){
		return new Categorie($donnees);
	}
	
	public function getCategoriesByName($nameCritere){		
		$values = count($nameCritere);
		$criteria = sprintf("?%s", str_repeat(",?", ($values ? $values-1 : 0)));
		$query = sprintf("select * from ".$this->table." where categorie in (%s)", $criteria);
		$statement = $this->_db->prepare($query);
		$donnees = $statement->execute($nameCritere);
		$entityListe = array();
		while ($donnees = $statement->fetch(PDO::FETCH_ASSOC)){
			$entityListe[] = $this->newInstanceEntity($donnees);
		}		
		return $entityListe;
	}
	
	public function getCategorieById($id){
		$query = "select * from ".$this->table." where id = :id" ;
		$entity = new Categorie(array("id"=>$id));
		return $this->select($query, $entity);	
	}
	
	public function getCategorieByGeneral($id){
		$query = "select * from ".$this->table." where general = :categorie";
		$entity = new Categorie(array("categorie"=>$id));
		$entity->setId($id);
		return $this->select($query, $entity);
	}
}
?>
