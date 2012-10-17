<?php
class RevisionManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "vote";
	public $entityName = "Vote";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding["id_liste"] = "listesDefinition";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["note"] = "note";
	}
	
	protected function newInstanceEntity($donnees){
		return new Vote($donnees);
	}
}
?>