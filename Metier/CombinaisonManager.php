<?php
class CombinaisonManager extends DbManager{
	public $ID_COLUMN = "id";
	public $table = "combiner";
	public $entityName = "Combinaison";
	
	public function __construct(){
		parent::__construct();
	}
	
	protected function binding(){
		$this->arrayBinding[$this->ID_COLUMN] = "id";
		$this->arrayBinding["liste"] = "liste";
		$this->arrayBinding["pseudo"] = "membre";
		$this->arrayBinding["titre"] = "titre";
		$this->arrayBinding["id_liste"] = "id_listeOrigine";
	}
	
	protected function newInstanceEntity($donnees){
		return new Combinaison($donnees);
	}
}
?>