<?php
class CategorieManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "categories";
	public $entityName = "Categorie";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["categorie"] = "nom";
		$this->arrayBinding["url"] = "url";
		$this->arrayBinding["general"] = "groupe";
		$this->arrayBinding["nbListe"] = "nbListe";		
	}
	
	protected function newInstanceEntity($donnees){
		return new Categorie($donnees);
	}
	
	public function getCategorieByName($name){
		$query = "select * from ".$this->table." where categorie = :categorie" ;
		$entity = new Categorie(array("categorie1"=>$name));
		return $this->select($query, $entity);
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
	
	public function getCategorieByGeneral($groupe){
		$query = "select * from ".$this->table." where general = :general";
		$entity = new Categorie(array("general"=>$groupe));
		return $this->select($query, $entity);
	}
}
?>
