<?php
/**
* classe de configuration du model de connexion aux bases de données et des routes de l'application
**/
class Config{

	/**
<<<<<<< HEAD
	* configurez ici l'adresse de votre site internet.
	**/
	static $website_adress = 'http://localhost';
=======
	* configurez ici l'adresse vers la page de connexion (url appelé en ca de tentative d'acces a une page à privilège.
	**/
	static $website_adress = 'http://localhost/artsetmetiers/webroot/auth/connexion';
>>>>>>> dev


	static $homeController = 'accueil'; //définissez un controller par défaut pour votre page d'acceuil, ce controlleur devra avoir une méthode par défaut nommé index
	//par exemple pour $homeController définit à Demo et contenant une méthode index, un site tel que www.monsite.com sera équivalent à www.monsite.com/demo/index

	static $debug_level = 0; // définit le niveau d'information affiché en cas d'erreur dans vos interactions en base de données : 
	//									0 = aucune info, juste un message générique du type "service momentanément indisponnible (mode production),
	//									1 = affiche les erreurs sql ou de connexion à PDO.


	static $maxFileSize = 1048576; // (en octets) la taille max par défaut des fichiers à uploader dans vos formulaires

	static $database_name = 'artsetmetiers';  // C'est ici qu'il faut changer défault par le nom de la base souhaité apres l'avoir rajouté au tableau ci-dessous.


	/**
	*configurer ici votre connexion à PDO et votre compte mysql
	**/
	static $database = array('default' => array(
						'type'		=> 'mysql',
						'host' 		=> 'localhost',
						'database'	=> 'artsetmetiers',
						'user'		=> 'root',
						'password'	=> 'wolf1umip')
	     				#decommenter le code ci dessous pour creer une connexion à une nouvelle base de donnée
		   			    ,'artsetmetiers' => array(
		   			     'type'		=> 'mysql',
						'host' 		=> '82.237.225.65',
						'database'	=> 'artsetmetiers',
						'user'		=> 'devuser',
						'password'	=> 'wolf1umip')

	);

	/**
	* la proprieté statique Config::$acces permet de configurer les droits des utilisateurs pour chaque action de chaque
	* controlleur, completer le tableau ci dessous pour chaque action necessitant un niveau d'authentification, ne remplissez pas
	*pour les actions ouvertes au public comme la page d'accueil etc .. Il faudra dans votre table utilisateur créer un champ "statut"
	*et lui donner des possibilités de valeur identique à ce tableau. Pour l'exemple le controlleur mycontrollerController laisse
	*tous les utilisateurs ayant le champ statut qui a comme valeur membre acceder à l'action1. 
	*
	*
	*
	**/
	static $access  = array(/*'mycontroller' (Nom du controller sans le suffixe Controller) => array(
								'action1' => 'membre,
								'action2' => 'niveau necessaire pour acceder au service'),*/
							'auth' => array(
								'edit' => 1,
								'logout' => 1),
							'forum' => array(
								'addSubject' => 1,
								'delReply' => 1,
								'lockSubject' => 2),
<<<<<<< HEAD
=======
							'message' => array(
								'index' => 1,
								'voir' => 1,
								'repondre' => 1,
								'getLogin' => 1,
								'ecrire' => 1,
								'delete' => 1

							),
>>>>>>> dev
							'parcours' => array(
								'edit' => 1),
							'backoff' => array(
								'index' => 10,
								'addArticle' => 10,
								'listArticle' => 10,
								'delArticle' => 10,
								'forum' => 10,
								'listUsers' => 10,
								'unite' => 10,
								'diplome' => 10,
<<<<<<< HEAD
								'listCat' => 10));
=======
								'listCat' => 10,
								'fileExplorer' => 10));
>>>>>>> dev

	
	/**
	*@param le niveau d'acces de l'utilisateur sous forme numérique
	*@return son niveau d'acces sous forme de chaine de caractère explicite
	*Configurer le nom explicite du rang de vos utilisateur en fonction du rang numérique que vous avez configuré ci dessus
	*sachant que celui qui a le niveau le plus haut peut faire tout ce que fait le niveau d'en dessous
	**/
	static function accessShow($lvl=null){
		$rank[1] = 'membre';
		$rank[2] = 'modérateur';
		$rank[10] = 'administrateur';
		
		if(isset($lvl) && !is_null($lvl) && !empty($lvl)){
			return $rank[$lvl];
		}else{
			$c = count($rank);
			foreach($rank as $k => $v) {
				$list[$k] = $rank[$k];
			}
			return $list;
		}		
	}


	

}
