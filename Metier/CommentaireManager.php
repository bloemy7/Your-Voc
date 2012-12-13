<?php
class CommentaireManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "commentaires";
	public $entityName = "Commentaire";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["id_liste"] = "id_liste";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["commentaire"] = "commentaire";
		$this->arrayBinding["date"] = "date";
	}
	
	protected function newInstanceEntity($donnees){
		return new Commentaire($donnees);
	}
	
	public function countNbCommentairesById($id_liste){
		$query = "SELECT * FROM ".$this->table." WHERE id_liste = :id_liste";
		$listMotDef = new Commentaire(array("id_liste"=>$id_liste));
		return $this->count($query, $listMotDef);		
	}
	public function getCommentairesById($id_liste){
		$query = "select * from ".$this->table." where id_liste = :id_liste";
		$entity = new Commentaire(array("id_liste"=>$id_liste));
		return $this->select($query, $entity);		
	}
	public function createCommentaire($id_liste, $pseudo, $time, $commentaire){
		$query = "insert into ".$this->table." values('', '".$id_liste."', '".$pseudo."', '".$time."', '".$commentaire."')" ;
		$statement = $this->_db->prepare($query);
		$statement->execute();
	}
}
?>