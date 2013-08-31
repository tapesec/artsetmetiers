<?php

class ErrorController extends Controller{

	public function e404(){
		$this->set(array('controller' => $this->request->controller,
						 'action' 	  => $this->request->action));
		$this->layout = 'error';
		$this->render('e404');
	}
}