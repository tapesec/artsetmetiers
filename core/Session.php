<?php
class Session{
	
	

	/**
	*@return ouvre une session
	**/
	public  function __construct(){
		session_start(); 
		write('new session !<br>');

	}


	/**
	*@param $attr , $value le nom de la variable de session et sa valeur
	*@return crée une variable de session
	**/
	public function set($attr, $value){
		$_SESSION[$attr] = $value;
	}


	/**
	*@param $message le message flash a afficher
	**/
	public function setFlash($message, $statut=null){
		$this->set('flash', $message);
		$this->set('flashStatut', $statut);
	}

	/**
	*@return $_SESSION['flash'], le message flash dans la vue
	**/
	public function flash($statut=null){
		
		if(!empty($_SESSION['flash'])){
			include ROOT.DS.'views'.DS.'flash'.DS.'flash.php';
		}else{
			echo '';
		}
		/*$_SESSION['compteur'] = $_SESSION['compteur'] +1;*/
		$_SESSION['flash'] ='';
		$_SESSION['flashStatut'] ='';
	}

}