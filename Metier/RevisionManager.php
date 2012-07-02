<?php
class RevisionManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "revise";
	public $entityName = "Revision";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding["id_liste"] = "listesDefinition";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["moyenne"] = "moyenne";
		$this->arrayBinding["date"] = "date";
	}
	
	protected function newInstanceEntity($donnees){
		return new Revision($donnees);
	}
}
?>