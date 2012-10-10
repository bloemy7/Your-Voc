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
		if(isset($donnees['vues']))$entity->setVue($donnees['vues']);
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
		$listMotDef = new ListeMotDefinition();
		$listMotDef->setCategorie($nomCategorie);
		$listMotDef->setCategorie2($nomCategorie);
		return $this->count($query, $listMotDef);
	}
	
	public function getNbListe(){
		$query = "SELECT * FROM ".$this->table."";
		$entity = $this->newInstanceEntity(array());
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
	public function getListeByPseudoLimit3($pseudo){
		$query = "select * from ".$this->table." where pseudo = :pseudo ORDER BY id DESC LIMIT 3";
		$entity = new ListeMotDefinition();
		$entity->setMembre($pseudo);
		return $this->select($query, $entity);
	}
	public function getListeByPseudo($pseudo){
		$query = "select * from ".$this->table." where pseudo = :pseudo";
		$entity = new ListeMotDefinition();
		$entity->setMembre($pseudo);
		return $this->select($query, $entity);
	}
	public function getListeById($id){
		$query = "select * from ".$this->table." where id = :id";
		$entity = new ListeMotDefinition();
		$entity->setId($id);
		return $this->select($query, $entity);		
	}
	public function getListeByCategorie($categorie){
		$query = "select * from ".$this->table." where categorie = :categorie";				
		$entity = new ListeMotDefinition(array("categorie"=>$categorie));
		return $this->select($query, $entity);
	}
	public function getListeOrderByVues(){
		$query = "select * from ".$this->table." order by (vues + 0)";
		$entity = new ListeMotDefinition();
		return $this->select($query, $entity);		
	}
}
?>
