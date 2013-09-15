<?php
class VideoController extends Controller{
	
	public $helpers = array('Truncate', 'DateHelper', 'Form', 'Markitup');

	/**
	 *@name index
	 *@description liste toutes les vidéos de la plus récente à la plus ancienne
	 *@return (array)$listVideo la liste des videos
	 * */
	public function index(){
		$this->loadModel('Article');
		$this->layout = 'forum';
		$data = $this->Article->find(array('fields' => 'art_id,
		       						art_title,
								art_content,
								art_dateC,
								art_youtube,
								cat_id,
								cat_name,
								use_id,
							       	use_login',
							'where' => array(
							 	'art_slot' => 'Tutoriel vidéo',
							 	'art_online' => true),
							 'join' => array(
								'type' => 'LEFT OUTER JOIN',
								'table' => array('categories', 'users'),
								'condition' => array('art_cat_id = cat_id',
							       			     'art_use_id = use_id'))));
		
		$this->set('article', $data);
		$this->render('index');
	}
}
