<?php
class ListeMotDefinitionManager extends DbManager {
	protected $ID_COLUMN = "id";
	protected $table = "listes_public";
	protected $entityName = "ListeMotDefinition";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["pseudo"] = "membre";
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
		$entity = new ListeMotDefinition();
		if(isset($donnees['id']))$entity->setId($donnees['id']);
		if(isset($donnees['titre']))$entity->setTitre($donnees['titre']);
		if(isset($donnees['pseudo']))$entity->setMembre($donnees['pseudo']);
		if(isset($donnees['date'])){
			if(!preg_match("(.*\s2[0-9]{3])", $donnees['date'])){
				$donnees['date'] .=  "2012";
			}
			$entity->setDate($donnees['date']);
		}
		if(isset($donnees['liste'])){
			//$this->listeMot = explode($separator, $donnees['listeMot']);
			$entity->setListeMot($donnees['liste']);
		}
		if(isset($donnees['categorie']))$entity->setCategorie($donnees['categorie']);
		if(isset($donnees['categorie2']))$entity->setCategorie2($donnees['categorie2']);
		if(isset($donnees['note']))$entity->setNote($donnees['note']);
		if(isset($donnees['vue']))$entity->setVue($donnees['vue']);
		if(isset($donnees['commentaire']))$entity->setCommentaire($donnees['commentaire']);
		return $entity;
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