<?php

class Dispatcher{

	/**
	*@var instance de la class Request
	**/
	public $request; //instance de la classe request
	public $session;
	private $error_event = false;
	static $controller;

	public function __construct(){
		$this->request = new Request();
		$this->session = new Session();
		Router::checkAccess(Config::$access);
		if(isset($_SESSION['auth']) && !empty($_SESSION['auth'])){
			Auth::start($_SESSION['auth']);
		}
		Router::parse($this->request->url, $this->request, Auth::$session);
		write('dispatcher instancié !<br>');
		$controller = $this->loadController();
		
		if(!method_exists(get_class($controller), $this->request->action)){
			if($this->error_event){
				$this->error('Le controlleur '.$this->request->controller. ', n\'a pas de méthode '.$this->request->action);
			}	
		}else{
			call_user_func_array(array($controller, $this->request->action), $this->request->param);
			if(isset($controller->render)){
				$controller->render($controller->render);
			}else{
				//$controller->render($this->request->action);	
				//obligation de définir un rendu sauf pour l'ajax.	
			}
			
		}
		//if(isset($_SESSION['auth']) && !empty($_SESSION['auth'])){
			
		//}
	}
	/**
	*@return instance du controlleur appelé par l'utilisateur dans l'url sous le format 
	*wwww.nomdedomaine.com/controlleur/action/parametres exemple : ppol.dopc.mi/reportage/voir/1 ou,
	*en cas d'erreur d'url, la fonction error.
	**/
	public function loadController(){
		if(!empty($this->request->controller)){
			$name = ucfirst($this->request->controller).'Controller';
			$file = ROOT.DS.'Controllers'.DS.$name.'.php';
			if(!file_exists($file)){
				return $this->error('Le controlleur '.$this->request->controller.' n\'existe pas.');
				$this->error_event = true;
			}else{
				require $file;
				$this->error_event = true;
				$controller = new $name($this->request, $this->session);
				self::$controller[$name] = $controller;
				//debug(self::$controller);				
				return $controller;
			}
		}else{
			$this->request->controller = Config::$homeController;
			$controller = ucfirst(Config::$homeController).'Controller';
			require ROOT.DS.'Controllers'.DS.ucfirst($this->request->controller).'Controller.php';
			return new $controller($this->request, $this->session);
		}	
	}
	/**
	*@return une vue error 404 avec le message personnalisé à l'erreur
	**/
	public function error($message){
		$controller = new Controller($this->request);
		$controller->e404($message);
	}

}
