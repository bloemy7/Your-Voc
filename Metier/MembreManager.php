<?php
class MembreManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "membre";
	public $entityName = "Membre";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding["login"] = "login";
		$this->arrayBinding["email"] = "email";
		$this->arrayBinding["pass_md5"] = "pass";
	}
	
	protected function newInstanceEntity($donnees){
		return new Membre($donnees);
	}
	
	public function getMembre($login){
		$query = "select * from ".$this->table." where login = :login" ;
		$entity = new Membre(array("login"=>$login));
		return $this->select($query, $entity);
	}
}
?>