<?php 
class Auth{

	static $session; //array faisant référence à toutes les variables de session d'un utilisateur connecté


	/**
	*@param $user les informations issues d'une base de données d'un utilisateurs venant de se connecté
	*@return crée et hydrate la super variable de sessions 'auth' de chaques attributs de l'utilisateur connecté
	**/
	public static function load($user = array()){
		debug(current($user));
		//echo 'load !';

		foreach($user as $k => $v){
			self::rec($k, $v);
		}
		//die();
	}


	/**
	*@param $sessionauth la super variable de session 'auth'
	*@return hydrate le tableau static $session avec la session auth 
	**/
	static public function start($sessionauth){
		//echo 'start';
		$array = array();
		foreach($sessionauth as $k => $v){
			$array[$k] = $v;
		}	
		self::$session = $array;
	}

	/**
	*@return detruit la variable de session auth
	**/
	static public function destroy(){
		unset($_SESSION['auth']);
		
	}

	/**
	*@param $k, $v couple clé valeur pour la fonction récursive
	**/
	static private function rec($k, $v){
		if(is_array($v)){
			foreach ($v as $kk => $vv) {
				self::rec($kk, $vv);
			}
		}else{
			$_SESSION['auth'][$k] = $v;
		}
	}
	
}
