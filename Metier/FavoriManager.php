<?php
class FavoriManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "favoris";
	public $entityName = "Favori";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["id_liste"] = "listesDefinition";
		$this->arrayBinding["pseudo"] = "membre";
	}
	
	protected function newInstanceEntity($donnees){
		return new Favori($donnees);
	}
}
?>