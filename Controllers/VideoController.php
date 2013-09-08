<?php
class VideoController extends Controller{
	
	public $helpers = array('Truncate', 'DateHelper', 'Form', 'Markitup');

	/**
	 *@name index
	 *@description liste toutes les vidéos de la plus récente à la plus ancienne
	 *@return (array)$listVideo la liste des videos
	 * */
	public function index(){
		$this->layout = 'forum';
		$this->loadModel('Video');
		$listVideo = $this->Video->find(array('where' => array('vid_statut' => true)));
		$this->set('listVid', $listVideo);
		$this->render('index');
	}
}
