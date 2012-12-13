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
		$this->arrayBinding["id_liste"] = "id_liste";
		$this->arrayBinding["pseudo"] = "membre";
	}
	
	protected function newInstanceEntity($donnees){
		return new Favori($donnees);
	}
	
	public function createFavori($id_liste, $pseudo){
		$query = "insert into ".$this->table." values('', '".$id_liste."', '".$pseudo."')" ;
		$statement = $this->_db->prepare($query);
		$statement->execute();
	}
	public function getFavoriByIdAndPseudo($id_liste, $membre){
		$query = "select * from ".$this->table." where id_liste = :id_liste AND membre = :pseudo" ;
		$entity = new Vote(array("id_liste"=>$id_liste));
		$entity -> setMembre($membre);
		return $this->select($query, $entity);
	}
	public function deleteFavoriByIdAndMembre($id_liste, $membre){
		$query = "delete from ".$this->table." where id_liste = '".$id_liste."' and membre = '".$membre."'" ;
		$statement = $this->_db->prepare($query);
		$statement->execute();
	}
	public function getFavoriByPseudo($membre){
		$query = "select * from ".$this->table." where membre = :pseudo" ;
		$entity = new Vote(array("pseudo"=>$membre));
		return $this->select($query, $entity);
	}
	public function getFavoriByPseudoLimit20($membre){
		$query = "select * from ".$this->table." where membre = :pseudo limit 20" ;
		$entity = new Vote(array("pseudo"=>$membre));
		return $this->select($query, $entity);
	}
	public function getFavoriByPseudoLimit50($membre){
		$query = "select * from ".$this->table." where membre = :pseudo limit 50" ;
		$entity = new Vote(array("pseudo"=>$membre));
		return $this->select($query, $entity);
	}
}
?>