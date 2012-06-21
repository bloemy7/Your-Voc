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
	
	public function getCategorieByName($name){
		$query = "select * from ".$this->table." where categorie = :categorie" ;
		$entity = new Categorie(array("categorie"=>$name));
		return $this->select($query, $entity);
	}
	
	public function getCategorieById($id){
		$query = "select * from ".$this->table." where id = :id" ;
		$entity = new Categorie(array("id"=>$id));
		return $this->select($query, $entity);
	}
}
?>