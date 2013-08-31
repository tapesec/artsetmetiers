<?php
class AccueilController extends Controller{


	/**
	*@return la page d'index
	**/
	public function index(){
		$this->layout = 'home';
		$this->render('index');
	}

}