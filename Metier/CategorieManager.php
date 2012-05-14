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
}
?>