<?php
class CategorieManager {
	private $_db; // Instance de PDO
	private $table = "categories";
	
	public function __construct($db){
		$this->setDb($db);
	}
	
	public function add(Categorie $categorie){
		$q = $this->_db->prepare("INSERT INTO ".$this->table." SET categorie = :nom, url = :url, general = :groupe");		
		$q->bindValue(':nom', $categorie->nom());
		$q->bindValue(':url', $categorie->url());
		$q->bindValue(':groupe', $categorie->groupe());		
		$q->execute();
	}
	
	public function getNbListeByCategorie($nomCategorie){
		$result = mysql_query("SELECT * FROM listes_public WHERE categorie = '$nomCategorie' OR categorie2 = '$nomCategorie'")or die(mysql_error());
		return mysql_num_rows($result);
	}
	
	public function delete(Categorie $categorie){
		$this->_db->exec('DELETE FROM '.$this->table.' WHERE id = '.$categorie->id());
	}
	
	public function get($id){
		$id = (int) $id;		
		$q = $this->_db->query('SELECT id, categorie, url, general FROM '.$this->table.' WHERE id = '.$id);
		$donnees = $q->fetch(PDO::FETCH_ASSOC);		
		return new Categorie($donnees);
	}
	
	public function getList(){
		$categories = array();		
		$q = $this->_db->query('SELECT id, categorie, url, general FROM '.$this->table);		
		while ($donnees = $q->fetch(PDO::FETCH_ASSOC)){			
			$donnees['nbListe'] = $this->getNbListeByCategorie($donnees['categorie']);
			$categories[] = new Categorie($donnees);
		}
		return $categories;
	}
	
	public function update(Categorie $categorie){
		$q = $this->_db->prepare('UPDATE '.$this->table.' SET categorie = :nom, url = :url, general = :groupe, experience = :experience WHERE id = :id');		
		$q->bindValue(':nom', $categorie->nom(), PDO::PARAM_INT);
		$q->bindValue(':url', $categorie->url(), PDO::PARAM_INT);
		$q->bindValue(':groupe', $categorie->groupe(), PDO::PARAM_INT);
		$q->bindValue(':id', $categorie->id(), PDO::PARAM_INT);		
		$q->execute();
	}
	
	public function setDb(PDO $db){
		$this->_db = $db;
	}
}
?>