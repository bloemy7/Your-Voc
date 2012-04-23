<?php
class Mot{
	private $mot;
	private $traduction;
	private $commentaire;
	
	public function __construct(){
		$args = func_get_args(); 
        $nbArgs = func_num_args(); 
        if ($nbArgs == 3) { 
        	callConstructor($this, "__construct3", $nbArgs, $args);
        }else if($nbArgs == 1){
        	$arg = $args[0];
        	if(is_array($arg)){
        		callConstructor($this, "__construct2", $nbArgs, $arg);
        	}else if(is_string($arg)){
        		call_user_func_array(array($this,"__construct1"), $arg);
        	}
        }
    }       
    
    private function __construct1(String $motAsString){
    	$indexEgal = strrpos($motAsString, "=");
    	$indexCom = strrpos($motAsString, "{");
    	$this->mot = substr($motAsString, $indexEgal);
    	$this->traduction = substr($motAsString, $indexEgal, $indexCom);
    	$this->commentaire = substr($motAsString, $indexCom , $strlen($motAsString));
    }
    
    private function __construct2(array $motAsArray){
    	if(isset($motAsArray['mot']))$this->mot = $motAsArray['mot'];
    	if(isset($motAsArray['traduction']))$this->traduction = $motAsArray['traduction'];
    	if(isset($motAsArray['commentaire']))$this->commentaire = $motAsArray['commentaire'];
    }
    
    private function __construct3($mot, $traduction, $commentaire){
    	$this->mot = $mot;
    	$this->traduction = $traduction;
    	$this->commentaire = $commentaire;
    }
	
	public function mot(){
		return $this->mot;
	}
	public function setMot($p_mot){
		$this->mot = $p_mot;
	}
	public function traduction(){
		return $this->traduction;
	}
	public function setTraduction($p_traduction){
		$this->traduction = $p_traduction;
	}
	public function commentaire(){
		return $this->commentaire;
	}
	public function setCommentaire($p_commentaire){
		$this->commentaire = $p_commentaire;
	}
}
?>