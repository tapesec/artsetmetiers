<?php
class BlogController extends Controller{
	
	public $helpers = array('Truncate', 'DateHelper', 'Form', 'Markitup');
	//public $components = array('Auth');
	
	/**
	*@return $data['article'] l'article à mettre en page d'accueil
	*@return $data['carrousel'] les 4 photos du carrousel en page d'accueil
	**/
	public function index($page=1){
		//chargement du helper pour afficher un extrait d'article dans la page d'accueil du blog
		

		$this->loadModel('Article');
		$this->layout = 'main';
		$limit = $this->paginate($page, array('table' => 'Article', 'limit' => 5, 'cond' => array('art_slot' => 'blog', 'art_online' => true)));
		$data = $this->Article->find(array('fields' => 'art_id, art_title, art_content, art_dateC, cat_id, cat_name, use_id, use_login',
									 'where' => array(
									 	'art_slot' => 'blog',
									 	'art_online' => true),
									 'join' => array(
									 	'type' => 'LEFT OUTER JOIN',
									 	'table' => array('categories', 'users'),
									 	'condition' => array('art_cat_id = cat_id', 'art_use_id = use_id')),
									 'limit' => $limit));
		
		$this->set('article', $data);
		$this->render('index');
	}
	
	/**
	*@return le nombre de commentaire par post dans les entetes d'articles
	**/
	public function countCom($id){
		$this->loadModel('Comment');
		$nbre_com = $this->Comment->find(array('fields' => 'count(com_id) as com_id',
								   'where' => array('com_id_article' => $id)));
		$nbre_com = current(current($nbre_com));
		return $nbre_com;
	}
	
	
	/**
	*@param $id affiche l'intégralité de l'article spécifié par l'id
	**/
	public function voir($id, $id_com=null, $com_id_user=null){
		
		$this->loadModel('Article');
		$this->loadModel('Comment');
		
		if(!$id){
			$this->e404('Il y a une erreur dans votre url');
		}
		if($this->request->is('GET')){
			$data = $this->Article->find(array('fields' => 'art_id, art_title, art_content, art_dateC, cat_name, use_login, use_id',
									 'where' => array(
									 	'art_slot' => 'blog',
									 	'art_online' => true,
									 	'art_id' => $id),
									 'join' => array(
									 	'type' => 'LEFT OUTER JOIN',
									 	'table' => array('categories', 'users'),
									 	'condition' => array('art_cat_id = cat_id', 'art_use_id = use_id'))));
			if(empty($data)){
				$this->e404('La page n\'existe pas ou plus');
			}
			$com = $this->Comment->find(array('fields' => 'com_id, com_id_user, com_name_editor, com_content, com_dateC, com_dateM, use_id, use_login, ava_id, ava_url',
										  'join' => array(
										  	'type' => 'LEFT OUTER JOIN',
										  	'table' => array('users', 'avatars'),
										  	'condition' => array('use_id = com_id_user', 'ava_id_user = com_id_user')),
										  'where' => array('com_id_article' => $id),
										  'order' => 'com_id ASC'));
			if(isset($id_com) && !empty($id_com)){
				$edit = $this->Comment->find(array('fields' => 'com_content, com_id, com_id_user',
											   'where' => array('com_id' => $id_com)));
				if(!empty($edit)){
					$this->set('wall', array('article' => $data, 'comment' => $com, 'edit' => $edit));
				}
			}else{
				$this->set('wall', array('article' => $data, 'comment' => $com));
			}
			$this->layout = 'main';
		}elseif($this->request->is('PUT')){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->request->data['com_name_editor'] = Auth::$session['use_login'];
			$this->request->data['com_dateM'] = DateHelper::now();
			if($this->Comment->update($this->request->data, array('where' => array('com_id' => $id_com)))){
				$this->session->setFlash('Message bien edité !', 'success');
				$this->redirect('blog/voir/'.$id);

			}else{
				$this->session->setFlash('Erreur lors de l\'édition de votre commentaire', 'error');
				$this->redirect('blog/voir/'.$id);
			}

		}elseif($this->request->is('POST')){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->request->data['com_dateC'] = DateHelper::now();
			$this->request->data['com_id_user'] = Auth::$session['use_id'];
			$this->request->data['com_id_article'] = $id;
			if($this->Comment->save($this->request->data)){
				$this->session->setFlash('Commentaire sauvegardé !', 'success');
				$this->redirect('blog/voir/'.$id);
			}else{
				$this->session->setFlash('Veuillez corriger vos erreurs !', 'error');
				$this->redirect('blog/voir/'.$id);
			}
		}
		
		$this->render('voir');
	}

	/**
	*@param $id l'identifiant du commentaire à supprimer
	**/
	public function delete($id){
		$this->loadModel('Comment');
		
		if($this->Comment->delete(array('com_id' => $id))){
			$this->session->setFlash('Commentaire bien supprimé', 'success');
			$this->redirect($this->referer);
		}else{
			$this->session->setFlash('Impossible de supprimer votre commentaire, ressayez ou contactez l\'administrateur du site', 'error');
			$this->redirect($this->referer);
		}
		$this->render('voir');
	}


	/**
	*@param $category, le nom de la catégorie
	**/
	public function cat($cat_id, $page=1){
		$this->loadModel('Article');
		$this->layout = 'main';
		$limit = $this->paginate($page, array(
						'table' => 'Article',
						'limit' => 2,
						'cond' => array('art_slot' => 'blog',
										'art_online' => true,
										'art_cat_id' => $cat_id)));
		
		$data = $this->Article->find(array('fields' => 'art_id, art_title, art_cat_id, art_content, art_dateC, cat_name, use_login, use_id',
									 'where' => array(
									 	'art_slot' => 'blog',
									 	'art_online' => true,
									 	'art_cat_id' => $cat_id),
									 'join' => array(
									 	'type' => 'LEFT OUTER JOIN',
									 	'table' => array('categories', 'users'),
									 	'condition' => array('art_cat_id = cat_id', 'art_use_id = use_id')),
									 'limit' => $limit));

		


		
		$this->set('article', $data);
		$this->render('cat');

	}


	/**
	*@return redirige vers l'action voir avec en parametre l'identifiant de l'article test du moment.
	*cette article appartient à la catégorie test et doit être le seul en ligne.
	**/
	public function findTest(){
		$this->loadModel('Article');
		$id_article = $this->Article->find(array('fields' => 'art_id',
												 'where' => array('art_online' => true,
													'art_slot' => 'blog',
													'art_cat_id' => 4)));
		return current($id_article);
	}



	/** (methode de layout)
	*@return la liste des catégories à afficher
	**/
	public function listCat(){
		$this->loadModel('Categorie');
		$data['categories'] = $this->Categorie->find(array('where' => array('cat_type' => 'blog')));
		return $data['categories'];
	}

	/** (methode de layout)
	*@return la liste des liens vers les différentes pages de mon site
	**/
	public function page(){
		$this->loadModel('Page');
		$data['pages'] = $this->Page->find(array('where' => array('pag_type' => 'front'),
												 'order' => 'pag_id ASC'));
		return $data['pages'];
	}

	public function ajaxTest(){
		
		$data = 'hello';
		$this->set('test', $data);
		return $data;
	}	
}
