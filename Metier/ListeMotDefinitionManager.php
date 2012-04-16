<?php
class ListeMotDefinitionManager {
	private $_db; // Instance de PDO
	private $table = "listes_public";
	
	public function __construct($db){
		$this->setDb($db);
	}
	
	public function add(ListeMotDefinition $listeMotDefinition){
		$q = $this->_db->prepare("INSERT INTO ".$this->table." SET categorie = :nom, url = :url, general = :groupe");		
		$q->bindValue(':titre', $listeMotDefinition->titre());
		$q->bindValue(':liste', $listeMotDefinition->listeMot());
		$q->bindValue(':date', $listeMotDefinition->date());
		$q->bindValue(':categorie', $listeMotDefinition->categorie());
		$q->bindValue(':categorie2', $listeMotDefinition->categorie2());
		$q->bindValue(':note', $listeMotDefinition->note());
		$q->bindValue(':vues', $listeMotDefinition->vue());
		$q->bindValue(':commentaire', $listeMotDefinition->commentaire());
		$q->execute();
	}
	
	public function delete(ListeMotDefinition $listeMotDefinition){
		$this->_db->exec('DELETE FROM '.$this->table.' WHERE id = '.$categorie->id());
	}
	
	public function get($id){
		$id = (int) $id;		
		$q = $this->_db->query('SELECT * FROM '.$this->table.' WHERE id = '.$id);
		$donnees = $q->fetch(PDO::FETCH_ASSOC);		
		return new ListeMotDefinition($donnees);
	}
	
	public function getList(){
		$listeMotDefinition = array();		
		$q = $this->_db->query('SELECT * FROM '.$this->table);		
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){			
			$listeMotDefinition[] = new ListeMotDefinition($donnees);
		}
		return $listeMotDefinition;
	}
	
	public function update(ListeMotDefinition $listeMotDefinition){
		$q = $this->_db->prepare('UPDATE '.$this->table.' SET titre = :titre, liste = :liste, categorie = :categorie, categorie2 = :categorie2, date = :date, note = : vue = :vue, note = :note, commentaire=:commentaire WHERE id = :id');		
		$q->bindValue(':titre', $listeMotDefinition->nom());
		$q->bindValue(':liste', $listeMotDefinition->listeMot(), PDO::PARAM_STR);
		$q->bindValue(':categorie', $listeMotDefinition->categorie(), PDO::PARAM_STR);
		$q->bindValue(':categorie2', $listeMotDefinition->categorie2(), PDO::PARAM_STR);
		$q->bindValue(':date', $listeMotDefinition->date(), PDO::PARAM_STR);		
		$q->bindValue(':vue', $listeMotDefinition->vue(), PDO::PARAM_STR);
		$q->bindValue(':note', $listeMotDefinition->note(), PDO::PARAM_STR);
		$q->bindValue(':commentaire', $listeMotDefinition->commentaire(), PDO::PARAM_STR);
		$q->execute();
	}
	
	public function setDb(PDO $db){
		$this->_db = $db;
	}
}
?>