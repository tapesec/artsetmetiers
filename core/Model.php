<?php

class Model{


	static $dbi = false; // instance de l'objet PDO de la connexion
	static $connected = false; // token de contrôle de connexion à la base de données pour eviter les doublons
	protected $validate;
	public $session;

	/**
	*@return $dbi : retourne une instance de PDO.
	**/
	public function __construct(Session $session, Request $request){
		write('model '.get_class($this).' instancié !<br>');
		$this->session = $session;
		$this->request = $request;
		if(!Model::$connected){
			$param = Config::$database[Config::$database_name];
			try{
				/*error_reporting(0);*/
				$pdo = new PDO($param['type'].':host='.$param['host'].';dbname='.$param['database'], $param['user'], $param['password'], array(1002 => 'SET NAMES utf8'));
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				Model::$dbi = $pdo;
				//echo 'PDO connecté !<br>...';
				Model::$connected = true;
			}catch(PDOException $e){
				if(Config::$debug_level == 1){
					die('Error :  le probleme est '.$e->getMessage());
				}else{
					
					die('Service web momentanément indisponible veuillez vous reconnecter plus tard..');
				}	
			}
		}else{
			//echo 'déjà connecté à la base de données PDO !<br>';
		}
	}


	/**
	*@param array(mixed) $data tableau contenant tous les paramètres nécessaire aux requetes select
	*@return $data array(mixed)  tableau contenant toutes les données extraites de la 
	*base de données et à traiter dans le controller ayant appelé le model
	**/
	public function find($data = array()){
		// définition des valeurs par défaut en cas d'absence de paramètre à la fonction find
		$fields = (isset($data['fields']))? $data['fields'] : '*';
		$cond = (isset($data['where']))? $data['where'] : '1=1';
		$limit = (isset($data['limit']))? $data['limit'] : '';
		$order = (isset($data['order']))? $data['order'] : substr(lcfirst(get_class($this)), 0, 3).'_id DESC';
		$table_to_join = (isset($data['join']['table']) && isset($data['join']['type']))? $data['join']['table'] : '';
		$type_of_join = (isset($data['join']['type']))? $data['join']['type'] : '';
		$join_cond = (isset($data['join']['table']) && isset($data['join']['type']) && isset($data['join']['condition']))? $data['join']['condition'] : '';
		$group = (isset($data['group']))? $data['group'] : '';
		
		/*si une condition WHERE est passé en attribut à la fonction find, on écrit le morceau de la futur requête préparé avec des tokkens
		pour eviter les injections sql sinon on met par défaut comme condition 1=1*/
		if($cond !== '1=1'){
			$m="";
			foreach($cond as $k => $v){
				$wherecond = ' AND ';
				if($k != 'OR'){
					$wherecond = (preg_match('#OR $#', $m))? "" : $wherecond;
					$f1 = ' '.$k.' = ? ';
						
				}else{
					unset($cond[$k]);
					$wherecond = ' OR ';
				}
				$m .= $wherecond.$f1;
				$f1 ="";
			}
			$m = ltrim($m, ' AND ');
		}else{
			$m = '1=1';
		}
		
		$jointure='';
		if(!empty($table_to_join) && !empty($type_of_join) && !empty($join_cond)){
			if(is_array($table_to_join)){
				$c = count($table_to_join);
				for($i=0;$i<$c; $i++) {
					$jointure .= ' LEFT OUTER JOIN '.$table_to_join[$i].' ON '.$join_cond[$i];
				}
			}else{
				$jointure .= ' LEFT OUTER JOIN '.$table_to_join.' ON '.$join_cond;
			}
		}
		/*debug($jointure);
		debug($table_to_join);
		debug($type_of_join);
		debug($join_cond);*/

		


		$req = 'SELECT '.$fields.' FROM '.lcfirst(get_class($this)).'s '.$jointure.
		' WHERE '.$m.' '.$group.' ORDER BY '.$order.'  '.$limit;
		
		write($req.'<br>'); //<-- affichera la requête SQL finale avant sa préparation et l'insertion des variables sécurisées
		
		// on essaye d'executer le bloc ci dessous ..
		try{
			if($cond !== '1=1'){
			//préparation de la requete ..
				
			$result = Model::$dbi->prepare($req);		//attribution dynamique des variables de condition
				foreach($cond as  $vv){
					$param[] = $vv;
				}
				debug($param);
			$result->execute($param);
			
			}else{
				// sinon aucun paramètre fourni, execution d'une requête simple
				$result = Model::$dbi->query($req);
			}
					

		}
		catch(PDOException $e){
			echo 'Erreur :' .$e->getMessage();
		}
		$data = array();
		while($line = $result->fetch(PDO::FETCH_ASSOC)){
			$data[] = $line;	
		}
		$result->closeCursor();
	
		if(!empty($data)) {
			return $data;
		}else{
			return false;
		}	
	}


	/**
	 *@param mixed $data, tableau contenant les données à sauvegarder
	 *@return les données correspondant aux critères de recherche 
	 * */
	public function search($data = array()) {
		$fields = (isset($data['fields']))? $data['fields'] : '*';
		$like = (isset($data['like']))? $data['like'] : die("requete like obligatoire !");
		$order = (isset($data['order']))? $data['order'] : substr(lcfirst(get_class($this)), 0, 3).'_id DESC';

		$wherecond = ' AND ';
		foreach($like as $k => $v){ 
			if($k != 'OR'){
				$f1[] = ' '.$k.' LIKE ? ';
			}else{
				unset($like[$k]);
				$wherecond = ' OR ';
			}
		}
		
		$m = implode($wherecond, $f1);
					
		$req = 'SELECT '.$fields.' FROM '.lcfirst(get_class($this)).'s WHERE '.$m.' ORDER BY '.$order;
		
		write($req.'<br>');

		try{
			//préparation de la requete ..
			$result = Model::$dbi->prepare($req);		//attribution dynamique des variables de condition
				foreach($like as $vv){
					$param[] = $vv;
				}
				//debug($param);
			$result->execute($param);	

		}
		catch(PDOException $e){
			echo 'Erreur :' .$e->getMessage();
		}
		$data = array();
		while($line = $result->fetch(PDO::FETCH_ASSOC)){
			$data[] = $line;	
		}
		$result->closeCursor();
		return $data;

	}
	

	/**
	*@param $data tableau contenant les données à sauvegarder
	*@return insert les données dans la base de données
	**/
	public function save($data = array()){
		if($this->beforeSave($data)){
			foreach($data as $k => $v){
				if(preg_match('/^put[a-zA-Z-0-9_\-.]+id$/', $k)){
					$new_value = $v;
					$new_key = substr($k, 3);
					unset($data[$k]);
					$data[$new_key] = $new_value;
					//debug($k);
					break;
				}
			}
			
			debug($data);
			
			$fields = '';
			$tokken ='';
		
			if(isset($data[$this->request->action])){
				unset($data[$this->request->action]);
			}
			//print_r($data);		
			foreach($data as $k => $v){
				$fields .= ', '.$k;
				$tokken .= ', ?';
				$array_exec[] = $v;
			}
			$fields =  trim($fields, ',');
			$tokken =  trim($tokken, ',');
			//echo $fields.'<br>';

			$req = 'INSERT INTO '.lcfirst(get_class($this)).'s ('.$fields.') VALUES ('.$tokken.')';
			//echo $req.'<br>';
			write($req);
			try{
				$r = Model::$dbi->prepare($req);
				$r->execute($array_exec);
			
				return true;
			}catch(PDOException $e){
				echo 'Error : '.$e->getMessage();
				return false;
			}
		}else{
			return false;
		}
	}



	/**
	*@param $data tableau contenant les données à mettre à jour dans la base
	*@return met à jour les données dans la base
	**/
	public function update($data = array(), $clause = array()){
		
		if($this->beforeSave($data)){
			foreach($data as $k => $v){
				if(preg_match('/^put[a-zA-Z-0-9_\-.]+id$/', $k)){
					$new_value = $v;
					$new_key = substr($k, 3);
					unset($data[$k]);
					if(!empty($new_value)){
						$data[$new_key] = $new_value;
					}
					//debug($k);
					break;
				}
			}
			unset($data[$this->request->action]);
			if(isset($data['max_size'])){
				unset($data['max_size']);
			}
			
			$fields ='';
			foreach($data as $k => $v){
				$fields .= ', '.$k.' = ? ';
				//$tokken .= ', ?';
				$array_exec[] = $v;
				//debug($array_exec);
			}
			$fields = trim($fields, ',');

			if(isset($clause['where'])){
				$cond = $clause['where'];
			}else{
				die('les requetes update necessite une clause where obligatoirement !');
			}
			foreach($cond as $k => $v){
					$filter[] = ' '.$k.' = ?';	
					$array_exec[] = $v;
					//debug($array_exec);
			}
			//echo 'array exec:';
			debug($array_exec);

		$where = 'WHERE'.implode(' AND ', $filter);
			$req = 'UPDATE '.lcfirst(get_class($this)).'s SET '.$fields. $where;
			write($req.'<br>');
			try{
				$r = Model::$dbi->prepare($req);
				$r->execute($array_exec);
			
				return true;
			}catch(PDOException $e){
				echo 'Error : '.$e->getMessage();
				return false;
			}
		}else{
			write('ratééééééééééééééééééééééééééééé');
			return false;
		}

	}


	/**
	*
	**/
	public function delete($param = array()){
	foreach($param as $k => $v){
		$conds[] = ' '.$k.'= ?';
		$array_exec[] = $v;
	}
	$conds = (implode(' AND ', $conds));
	//debug($k);
	
		$req = 'DELETE FROM '.lcfirst(get_class($this)).'s WHERE '.$conds;
		write($req.'<br>');
	debug($array_exec);
	//die('attention !');
		try{
			$r = Model::$dbi->prepare($req);
			$r->execute($array_exec);
			return true;
		}catch(PDOException $e){
			echo 'Error :'.$e->getMessage();
			return false;
		}
		

	}

	/**
	*@return compte le nombre d'occurence de la table
	**/
	public function count($array=null){
		$cond = (isset($array['where']))? $array['where'] : '1=1';

		if($cond !== '1=1'){
			foreach($cond as $k => $v){
				$f1[] = ' '.$k.' = ? ';	
			}
			$m = implode(' AND ', $f1);
		}else{
			$m = '1=1';
		}
		//$where = (isset($param['where']
		$req = 'SELECT COUNT(*) AS compteur FROM '.lcfirst(get_class($this)).'s WHERE '.$m;

		try{
			if($cond !== '1=1'){
				//préparation de la requete ..
				
				$result = Model::$dbi->prepare($req);
					//attribution dynamique des variables de condition
					foreach($cond as  $vv){
						$param[] = $vv;
					}
					//debug($param);
					
				$result->execute($param);
			
			}else{
				// sinon aucun paramètre fourni, execution d'une requête simple
				$result = Model::$dbi->query($req);
			}

		 	while($d = $result->fetch()){
		 		return $d['compteur'];
		 	}

		 	$result->closeCursor();

		}catch(PDOException $e){
			echo 'Erreur :' .$e->getMessage();
		}
	}



	/**
	*La fonction beforeSave ci-dessous permet d'appliquer des conditions de validation au formulaire utilisé par les visiteurs.
	*Cette fonction est appelé à chaque fois que la méthode save est utilisé dans un controlleur
	*Si des restrictions sont à appliquer avant la sauvagrde en base de donnée ,il faut creer un attribut public $validate dans le model voulu qui est un array contenant chaque nom des champs 
	*du formulaire contenant eux même les attributs de validation et leurs valeurs exemple :
	*
	*
	* public $validate = array(
    *   'use_login' => array(
    *    	'alphaNumeric' => true,
    *   	'between' => '3,10',
    *  	'required' => true,
    *  	'message' => 'le login doit etre alphanuméric et etre compris entre 3 et 10 caractères<br><br>'),
    *    'use_mail' => array(
    *    	'email' => true,
    *    	'required' => true,
    *    	'message' => 'format de l\'adresse mail invalide<br><br>'),
    *    'use_password1' => array(
    *    	'alphaNumeric' => true,
    *    	'between' => '6,15',
    *    	'message' => 'password entre 6 et 15 caractères<br><br>'),
    *    'use_password2' => array(
    *    	'alphaNumeric' => true,
    *    	'between' => '6,15',
    *    	'message' => 'password entre 6 et 15 caractères<br><br>')
    * );
	*
	*
	**/

	
	/**
	*@param $data les champs des formulaires à sauvegarder en base de données
	*@return un message d'erreur si les conditions ne sont pas validées
	**/
	public function beforeSave($data = array()){
		if(isset($data[$this->request->action])){
			
			debug($data);
			debug($_SESSION);
			debug($_SESSION[$this->request->action]);
			//die();
			if($data[$this->request->action] == $_SESSION[$this->request->action]){
				unset($data[$this->request->action]);
				if(isset($data['max_size'])){
					unset($data['max_size']);
				}
				debug($data);
				
				if(!empty($this->validate)){
					write('checkpoint');
					foreach($data as $k => $v){
						$champ = (isset($this->validate[$k]))? $this->validate[$k] : null;
						// définition de l'éventuel message d'eereur
						$message = (isset($champ['message']))? $champ['message'] : 'Vous avez fait une erreur de saisie';
						// vérification de la condition alpha numéric
						if(isset($champ['alphaNumeric'])){
							if(!preg_match('/^[a-zA-Z0-9\-_]+$/', $v)){
								$this->session->set($k, $message);
								//header('location:'.$_SERVER['HTTP_REFERER']);
								return false;
							}else{
								$this->session->set($k, '');
							}
						}//echo 'alpha ok<br>';
						// vérification du nombre de caractère
						if(isset($champ['between'])){
							$l = explode(',', $champ['between']);
							//debug($l);
							if(!preg_match('/.{'.$l[0].','.$l[1].'}/', $v)){
								$this->session->set($k, $message);
								//header('location:'.$_SERVER['HTTP_REFERER']);
								return false;
							}else{
								$this->session->set($k, '');
							}
						}//echo 'between ok<br>';
						// vérifie si un champ a bien été rempli
						if(isset($champ['required'])){
							if(empty($v)){
								$this->session->set($k, $message);
								//header('location:'.$_SERVER['HTTP_REFERER']);
								return false;
								
							}else{
								$this->session->set($k, '');
							}
						}
						// vérifie si un champ a bien été rempli
						if(isset($champ['email'])){
							if(!filter_var($v, FILTER_VALIDATE_EMAIL)){
								$this->session->set($k, $message);
								//header('location:'.$_SERVER['HTTP_REFERER']);
								return false;
							}else{
								$this->session->set($k, '');
							}
						}//echo 'email ok<br>';
					}return true;
				}else{
					return true;
				}
			}elseif(!Request::$handMade){
				die('Les données reçu ne proviennt pas d\une source valide, quelque chose ne fonctionne pas normalement !');
			}else{
				return true;
			}
		}elseif(!Request::$handMade){
			die('il n\'existe pas de request action');
		}else{
			return true;
		}
	}
}
