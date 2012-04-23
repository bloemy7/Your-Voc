<?php
class DBHelper {
	private static $dbManagerListe = array();
	
	public static function addManager(DbManager $dbManager){
		self::$dbManagerListe[$dbManager->getEntityName()] = $dbManager;
	}
	
	public static function getDBManager($entityName){
		return self::$dbManagerListe[$entityName];
	}
	
	public static function getDBManagerListe(){
		$copyOfDbManagerListe = self::$dbManagerListe;
		return $copyOfDbManagerListe;
	}
}
?>