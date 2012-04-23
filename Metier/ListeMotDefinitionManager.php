<?php
class ListeMotDefinitionManager extends DbManager {
	protected $ID_COLUMN = "id";
	protected $table = "listes_public";
	protected $entityName = "ListeMotDefinition";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding["id"] = "id";
		$this->arrayBinding["titre"] = "titre";
		$this->arrayBinding["liste"] = "listeMot";
		$this->arrayBinding["date"] = "date";
		$this->arrayBinding["categorie"] = "categorie";
		$this->arrayBinding["categorie2"] = "categorie2";
		$this->arrayBinding["note"] = "note";
		$this->arrayBinding["vues"] = "vue";
		$this->arrayBinding["commentaire"] = "commentaire";
	}
	
	protected function newInstanceEntity($donnees){
		return new ListeMotDefinition($donnees);
	}
	
	public function getListeByKeyWord($keyWord){
		$requete = explode(" ", $requete);
		$query = "Select * from ".$this.table." where ";
		return $this->select($query);
	}
	
	public function getNbListeByCategorie($nomCategorie){
		$query = "SELECT * FROM ".$this->table." WHERE categorie = :categorie OR categorie2 = :categorie2";
		$entity = $this->newInstanceEntity(array("categorie"=>$nomCategorie, "categorie2"=>$nomCategorie));	
		return $this->count($query, $entity);
	}
	
	public function getListeByCritere($critere){
		$query = "SELECT * FROM ".$this->table." WHERE ";
		$datas = array();		
		$entityCritere = new ListeMotDefinition(array());
		if(isset($critere['titre'])){
			$query.="titre like :titre";
			$entityCritere->setTitre("%".$critere['titre']."%");
		}
		if(isset($critere['categorie'])){
			$query.=" or categorie like :categorie";
			$entityCritere->setCategorie("%".$critere['categorie']."%");
		}
		if(isset($critere['categorie2'])){
			$query.=" or categorie2 like :categorie2";
			$entityCritere->setCategorie2("%".$critere['categorie2']."%");
		}
		return $this->select($query, $entityCritere);
	}
}
?>