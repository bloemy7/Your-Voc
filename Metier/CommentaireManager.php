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
		$this->arrayBinding["commentaire"] = "commentaire";
		$this->arrayBinding["date"] = "date";
	}
	
	protected function newInstanceEntity($donnees){
		return new Commentaire($donnees);
	}
}
?>