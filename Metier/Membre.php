<?php
class Membre extends Entity{
	private $login;
	private $pass;
	private $email;
	
	function __construct(array $donnees){
		if(isset($donnees['id']))$this->id = $donnees['id'];
		if(isset($donnees['login']))$this->login = $donnees['login'];
		if(isset($donnees['pass_md5']))$this->pass = md5($donnees['login']);
		if(isset($donnees['email']))$this->email = $donnees['email'];
	}
	
	function id(){
		return $this->id;
	}
	
	function login(){
		return $this->login;
	}
	function setLogin($login){
		$this->login = $login;
	}
	
	function email(){
		return $this->email;
	}
	function setEmail($email){
		$this->email = $email;
	}
	
	function pass(){
		return $this->pass;
	}
	function setPass($pass){
		$this->pass = $pass;
	}
}
?>