<?php
class DemoController extends Controller{
	

	public function index(){

		
	}

	public function hello($name){
		$this->set('name', $name);
		$this->render('hello');
	}

	public function voir($id){
		$this->loadModel('Article');
		$data = $this->Article->find(array('where' => array('id' => $id)));
		if(!empty($data)){
			$this->set('article', $data);
			$this->render('voir');
		}else{
			$this->e404('Article introuvable');
		}
	}

	public function getList(){
		$this->loadModel('Article');
		new model();
		/*$data = $this->Article->find(array('limit' => ' LIMIT 10'));
		$this->set('liste', $data);
		$this->render('getList');*/
	}
	
	public function	add($request){
		$request =array('title'  => 'Mon premier titre avec la méthode save',
						'content' 	  => 'un premier contenu avec insert',
					    'date_article' => Date('d/m/y'));
		$this->loadModel('Article');
		$this->Article->save($request);
	}
}