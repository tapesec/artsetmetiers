<?php
class Sanitize{

	//static $magic_quotes = true;
	
	
	/**
	*@param les données à nettoyer de toute tentative de hack
	*@return les données nettoyer
	**/
	static function clean($data){
		$data = (is_array($data))? array_map('Sanitize::clean', $data) : htmlspecialchars($data);
		return $data;
	}
	
		
	/**
	*@param les données à traiter contre les antislash avant affichage
	*@return les données traitées
	**/
	static function show($value){
		$value = (is_array($value)) ? array_map('Sanitize::show', $value) : stripslashes($value);
	    return $value;
	}



}