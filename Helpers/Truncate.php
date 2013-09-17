<?php

class Truncate{

	/**
	*
	*Helper disposant de methode de découpe de chaine de caractère
	*
	*
	*
	**/
	public function __construct(){
		write('Truncate instancié<br>');
	}

	/**
	*@param $content, $length : le contenu à raccourcir et la taille de l'extrait (en mot)
	*@return un contenu coupé en fonction du nombre de mots passé en argument mais arrondi à la phrase suppérieure.
	**/
	public function fragment($content, $length){
		$frag = explode(' ', $content, $length);
		//debug($frag);
		$string=null;
		for($i=0, $c = $length-1;$i<$c;$i++){

			$string .= (isset($frag[$i]))? ' '.$frag[$i] : false; 
		}
		if(isset($frag[$length-1])){
			$end = preg_split('/\./', $frag[$length-1]);
		}else{
			$end = ' ';
		}
		
		//debug($end);
		$string .= ' '.$end[0].'..';
		return $string;
	}

}
