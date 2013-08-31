<?php

class Controller{
	public $request;
	public $session;
	public $vars = array();
	public $layout = 'default';
	protected $referer;
	private $rendered = false;
	static $helperloaded = false;


	/**
	*@param object $request instance de la classe Request
	**/
	public function __construct(Request $request=null, Session $session=null){
		write(get_class($this).' instancié !<br>');
		$this->request = $request;
		$this->session = $session;
		$this->referer = (isset($_SERVER['HTTP_REFERER']))? $_SERVER['HTTP_REFERER']: '';	
		if(!Controller::$helperloaded){
			if(isset($this->helpers)){
				$this->helperLoad($this->helpers);
				Controller::$helperloaded = true;
			}
		}
		
	}
	
	/**
	*@param string $view : la vue désirée (doit exister dans /views/(nom du controller)/nom du fichier.php.
	*@return $content_for_layout : contient $view + le layout spécifié ou default.
	**/
	public function render($view){
		if($this->rendered){
			//echo 'rendered';
			return false;
		}
		extract($this->vars);
		if(strpos($view,'/') === 0){
			$view = ROOT.DS.'views'.$view.'.php';
		}else{
			
			$view = ROOT.DS.'views'.DS.ucfirst($this->request->controller).DS.$view.'.php';
		}
		ob_start();
		require_once $view;
		$content_for_layout = ob_get_clean();
		if($this->request->isAjax()){
			$this->layout = 'ajax';
		}
		require_once ROOT.DS.'views'.DS.'layouts'.DS.$this->layout.'.php';
		
		$this->rendered = true;	
	}

	/**
	 *@return les données au format json
	 * */
	public function ajaxRender() {
		
	}

	/**
	*@param mixed $key, $value : clé et valeur (peut etre null)
	**/
	public function set($key, $value=null){
		if(is_array($key)){
			$this->vars += $key;
		}else{
			$this->vars[$key] = $value;
		}
		
	}
	/**
	*@param $model nom du model à charger
	**/
	public function loadModel($model){
		$file = ROOT.DS.'Models'.DS.ucfirst($model).'.php';
		if(file_exists($file)){
			require_once $file;
			if(!isset($this->$model)){	
				$this->$model =  new $model($this->session, $this->request);
			}
		}else{
			die('error, le chemin: '.$file. 'n\'existe pas.');
		}
	}


	/** 
	*@param $controller nom du controller à appeler
	*@param $action nom de l'action à appeller dans le controller ci dessus
	*@return $data les données à afficher dans le layout qui a a appelé la fonction. 
	**/
	public function layoutLoad($controller, $action, $id=null){
		$controller_name = $controller.'Controller';
		$file = ROOT.DS.'Controllers'.DS.ucfirst($controller_name).'.php';
		require_once $file;
		if(!isset(Dispatcher::$controller[$controller_name])){
			$c = new $controller_name($this->request, $this->session);
			Dispatcher::$controller[$controller_name] = $c;
		}
		$data = Dispatcher::$controller[$controller_name]->$action($id);
		return $data;
		//debug($data, false);
		
	}

	/**
	*@return $message message d'erreur dans la vue 404
	**/
	public function e404($message){
		header("HTTP/1.1 404 Not Found");
		$controller = new Controller($this->request);
		$this->set('message', $message);
		$this->layout = 'error';
		$this->render('/Errors/e404');
		die();
	}


	/**
	*@param $url l'url où redirigé l'internaute
	*@return redirige vers l'url specifié
	**/
	public function redirect($url){
		$url2 = explode('/', $url);
		if(filter_var($url, FILTER_VALIDATE_URL)){
			return header('location:'.$url);
		}else{
			return header('location:'.BASE_URL.'/'.$url);
		}
		
	}

	/**
	*@return $link un lien spécifique vers un fichier css ou javascript
	**/
	public function link($dir, $file, $type=null){
		if($dir == 'css' || $type == 'css'){
			$link = '<link rel="stylesheet" type="text/css" href="'.BASE_URL.'/'.$dir.'/'.$file.'.css">'.PHP_EOL;
		}elseif($dir == 'javascript' || $type == 'javascript'){
			$link = '<script type="text/javascript" src="'.BASE_URL.'/'.$dir.'/'.$file.'.js"></script>'.PHP_EOL;
		}
		return $link;
	}

	/**
	*
	**/
	public function img($file, $param=null){
		$class = (isset($param['class']))? $param['class'] : '';
		$alt = (isset($param['alt']))? $param['alt'] : '';
		$title = (isset($param['title']))? $param['title'] : '';
		$id = (isset($param['id']))? 'id="'.$param['id'].'"' : '';

		$img = '<img src="'.BASE_URL.'/img/'.$file.'" class="'.$class.'" '.$id.' alt="'.$alt.'" title="'.$title.'">';
		echo $img;
	}

	/**
	*@param un tableau contenant la liste des $helpers à charger
	*@return un attribut contenant l'instance du helper appelé
	**/
	public function helperLoad($helpers = array()){
		foreach($helpers as $helper){
			$file = ROOT.DS.'Helpers'.DS.$helper.'.php';
			require_once $file;
			if(!isset($this->$helper)){
				$this->$helper = new $helper();
			}
		}
	}


	/**
	*@param un tableau contenant la liste des composants à charger
	*@return un attribut contenant l'instance du composant appelé
	**/
	public function componentLoad($components = array()){
		foreach($components as $component){
			$file = ROOT.DS.'Components'.DS.$component.'.php';
			require_once $file;
			$this->$component = new $component();
		}
	}

	/**
	*@param $id retourne un parametre de pagination quand le nombre d'item à afficher est trop long
	*@return $page la condition limit dans la requete sql
	**/
	public function paginate($id=1, $param = array()) {
		$table = $param['table'];
		$limit = $param['limit'];
		$cond = (isset($param['cond']))? $param['cond'] : '';

		if(!empty($cond)){
			foreach ($cond as $k => $v) {
				$conds[$k] = $v;
			}
			$number = $this->$table->count(array('where' => $conds));
		}else{
			$number = $this->$table->count();
		}

		
		$this->counter = ceil($number / $limit);

		/*if(!is_numeric($id) || $this->counter < $id){
			$this->e404('Cette url est incorrect, suivez les liens du site pour naviguer');
		}*/
		if($id <= 1){
			$page = 'LIMIT '.$limit;
		}else{
			$offset = (($limit*$id)-$limit);	 
			$page = 'LIMIT '.$limit.' OFFSET '.$offset;
		}
		return $page;
	}


	/**
	*@param $url, $table, $class (optionnel) l'url vers l'action qui doit traiter le changement de page, la table concerné par la pagination, une class pour styliser la pagination
	**/
	public function paginator($url, $class=null){
		
		$c = $this->counter;
		echo '<div class="'.$class.'">';
		echo '<ul>';
		for($i=1;$i<=$c;$i++){
			echo '<li><a href="'.BASE_URL.'/'.$url.'/'.$i.'">'.$i.'</a></li>';
		}
		echo '</ul>';
		echo '</div>';
		
	}
}
