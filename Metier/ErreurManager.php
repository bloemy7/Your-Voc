<?php
class ErreurManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "erreurs";
	public $entityName = "Erreur";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["id_liste"] = "listesDefinition";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["type"] = "type";
		$this->arrayBinding["message"] = "message";
		$this->arrayBinding["date"] = "date";
	}
	
	protected function newInstanceEntity($donnees){
		return new Erreur($donnees);
	}
}
?>