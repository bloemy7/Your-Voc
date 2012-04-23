<?php
class DBHelper {
	private static $dbManagerListe = array();
	
	public static function addManager(DbManager $dbManager){
		print_r($dbManager->getEntityName()."<br>");
		$dbManagerListe[$dbManager->getEntityName()] = $dbManager;
	}
	
	public static function getDBManager($entityName){
		print_r('<br>'.$entityName);
		return self::$dbManagerListe[$entityName];
	}
	
	public static function getDBManagerListe(){
		$copyOfDbManagerListe = self::$dbManagerListe;
		return $copyOfDbManagerListe;
	}

}
?>