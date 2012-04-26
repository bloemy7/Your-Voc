<?php
class Membre extends Entity{
	private $login;
	private $pass;
	private $email;
	
	function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['login']))$this->login = $donnees['login'];
		if(isset($donnees['pass_md5']))$this->pass = $donnees['pass_md5'];
		if(isset($donnees['email']))$this->email = $donnees['email'];
	}
	
	public function id(){
		return $this->id;
	}
	public function setId($p_id){
		$this->id= $p_id;
	}
	
	public function login(){
		return $this->login;
	}
	public function setLogin($login){
		$this->login = $login;
	}
	
	public function email(){
		return $this->email;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	
	public function pass(){
		return $this->pass;
	}
	public function setPass($pass){
		$this->pass = $pass;
	}
}
?>