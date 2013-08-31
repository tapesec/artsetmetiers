<?php
class Router{


	static $right;

	/**
	*@param $url Url à parser
	*@return tableau contenant les paramètres et redirige ou coupe le script en cas d'appel d'action par un utilisateur n'ayant pas les droits
	**/
	static function parse($url, Request $request, $authSession=null){
		$url = trim($url,'/');
		$k = explode('/', $url);
		
		//debug(self::$right);
		
		$request->controller = (isset($k[0]))? $k[0] : 'demo';
		$request->action = (isset($k[1]))? $k[1] : 'index';
		$request->param = array_slice($k, 2);
		if(isset(self::$right[$request->controller][$request->action])){
			//debug(self::$right[$request->controller][$request->action]);
			//debug(Auth::$session['use_statut']);
			if(isset(Auth::$session['use_statut'])){
				if(self::$right[$request->controller][$request->action] <= Auth::$session['use_statut']){
				//
				return true;
				}else{
					header('location:'.Config::$website_adress);
					die();
					//return false;
				}
			}else{
				header('location:'.Config::$website_adress);
				die();
			}
			//die();	
		}else{
			return true;
		}
		
		
		
	}

	/**
	*@param $acces dans le controlleur Config, le tableau qui définit les droits d'acces restreints à certaines actions.
	*@return hydrate l'attribut static $right pour permettre à la fonction parse d'ecouter les urls et de rediriger vers l'acceuil en cas d'acces interdit
	**/
	static function checkAccess($acces){
		foreach ($acces as $controller => $listAction) {
			foreach ($listAction as $action => $prefix) {
				self::$right[$controller][$action] = $prefix; 
			}	
		}

	}

}