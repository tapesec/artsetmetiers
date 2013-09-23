<?php 
class ForumController extends Controller{

	public $helpers = array('Form', 'DateHelper', 'Markitup'); //charge les helpers pass� dans le tableau

	
	//


	/**
	*@return la page d'accueil avec la liste des sections du forum
	**/
	public function index(){
		$this->layout = 'forum';
		$this->loadModel('Section');
		$data['section'] = $this->Section->find(array('where' => array('sec_online' => true), 'order' => 'sec_name'));
		$this->set('section', $data['section']);
		$this->render('index');
	}

	/**
	*@param $id l'identifiant de la section. Utilis� pour afficher tous les sujets qui lui sont associ�s
	*@return la liste des sujets de ce num�ro de section 
	**/
	public function section($id, $page=1){
		$this->layout = 'forum';
		$this->loadModel('Subject');

		$postit = $this->Subject->find(array('fields' => 'sub_id, sub_title, sub_lock, sub_dateC, sub_postit , sec_id, sec_name, use_id, use_login',
														'join' => array(
									 					'type' => 'LEFT OUTER JOIN',
									 					'table' => array('sections', 'users'),
									 					'condition' => array('sub_id_sections = sec_id', 'sub_id_author = use_id')),
													  'where' => array('sec_id' => $id,
													  				   'sub_online' => true,
													  				   'sub_postit' => true)));

		$limit = $this->paginate($page, array('table' => 'Subject', 'limit' => 10, 'cond' => array('sub_id_sections' => $id, 'sub_online' => true)));
		$data['subject'] = $this->Subject->find(array('fields' => 'sub_id, sub_title, sub_dateC, sec_id, sec_name, use_id, use_login',
														'join' => array(
									 					'type' => 'LEFT OUTER JOIN',
									 					'table' => array('sections', 'users'),
									 					'condition' => array('sub_id_sections = sec_id', 'sub_id_author = use_id')),
													  'where' => array('sec_id' => $id,
													  				   'sub_online' => true,
													  				   'sub_postit' => false ),
													  'limit' => $limit));
		


		if(empty($data['subject'])){
			$this->loadModel('Section');
			$data['subject'] = $this->Section->find(array('fields' => 'sec_id, sec_name',
														  'where' => array('sec_id' => $id)));
			//debug($data['subject']);
			if(empty($data['subject'])){
				$this->e404('Page introuvable, cette page n\'exite pas ou plus, veuillez suivre les liens de navigation');
			}
			
		}
		
		//debug($data['subject']);
		
		$this->set('subjects', array('subject' => $data['subject'], 'postit' => $postit));
		$this->render('sujets');
	}

	/**
	*
	**/
	public function posts($id, $page=1, $id_edit=null){
		
		$this->loadModel('Subject');
		$this->loadModel('Replie');
		$this->loadModel('Visit');

		

		$limit = $this->paginate($page, array('table' => 'Replie', 'limit' => 10, 'cond' => array('rep_id_subjects' => $id)));
		if($this->request->is('GET')){
			
			Request::$handMade = true;
			$ip_visit = $_SERVER['REMOTE_ADDR'];
			$this->Visit->save(array('vis_ip' => $ip_visit, 'vis_type' => 'posts', 'vis_type_id' => $id));
			Request::$handMade = false;

			$data['posts'] = $this->Subject->find(array('fields' => 'sub_content, sub_id_author, sub_id, sub_lock, sub_dateC, sec_id, sec_name, use_login, use_id, sub_title, ava_id, ava_url',
														'join' => array(
															'type' => 'LEFT OUTER JOIN',
															'table' => array( 'sections', 'users', 'avatars'),
															'condition' => array('sub_id_sections = sec_id', 'sub_id_author = use_id', 'ava_id_user = use_id')),
														'where' => array('sub_id' => $id)));

			$data['rep'] = $this->Replie->find(array('fields' => 'sub_id, rep_id, rep_id_author, rep_editor , rep_id_subjects, rep_content, rep_title, rep_dateC, rep_dateM, use_id, use_login, ava_id, ava_url',
													 'join' => array(
													 	'type' => 'LEFT OUTER JOIN',
													 	'table' => array('subjects', 'users', 'avatars'),
													 	'condition' => array('sub_id = rep_id_subjects', 'rep_id_author = use_id', 'ava_id_user = use_id')),
													 'where' => array('rep_id_subjects' => $id),
													 'limit' => $limit,
													 'order' => 'rep_id ASC'));
			
			if(isset($id_edit) && !empty($id_edit)){
			$data['edit'] = $this->Replie->find(array('fields' => 'rep_id, rep_title, rep_content',
													  'where' => array('rep_id' => $id_edit)));
			$this->set('posts', array('post' => $data['posts'], 'list' => $data['rep'], 'edition' => $data['edit']));
			
			}else{
				if(empty($data['posts'])){
					$this->e404('Ce sujet n\'existe pas.. ');
				}else{
					$this->set('posts', array('post' => $data['posts'], 'list' => $data['rep']));
				}
				
			}
			$this->layout = 'forum';
			$this->render('posts');
		}
		
		if($this->request->is('PUT')){
			$this->request->data = Sanitize::clean($this->request->data);

			$this->request->data['rep_editor'] = Auth::$session['use_login'];
			$this->request->data['rep_dateM'] = DateHelper::now();
			if($this->Replie->update($this->request->data, array('where' => array('rep_id' =>$id_edit)))){
				$this->session->setFlash('Votre réponse a bien été modifié', 'success');
				//$this->layout = 'default';
			}else{
				$this->session->setFlash('Corrigez vos érreurs !');
			}
			$this->redirect('forum/posts/'.$id);
		}elseif($this->request->is('POST')){
			$this->request->data = Sanitize::clean($this->request->data);

			$this->request->data['rep_id_author'] = Auth::$session['use_id'];
			$this->request->data['rep_id_subjects'] = $id;
			$this->request->data['rep_dateC'] = DateHelper::now();
			if($this->Replie->save($this->request->data)){
				//$this->layout = 'default';
				$this->session->setFlash('Votre réponse a bien été posté !', 'success');
			}else{
				
				$this->session->setFlash('Corrigez vos érreurs !');
			}
			$this->redirect('forum/posts/'.$id);
		}
	}
	
	/**
	*@param $sec_id, $sub_id l'identifiant de la section où rattacher le sujet, et l'identifiant du sujet à éditer
	*@return un formulaire pour rédiger et sauvegarder un nouveau message ou l'editer
	**/
	public function addSubject($sec_id, $sub_id=null){
		$this->loadModel('Subject');
		$this->loadModel('Section');
		if($this->request->is('GET')){
			if(isset($sub_id) && !empty($sub_id)){
				$sub = $this->Subject->find(array('fields' => 'sub_id, sub_title, sub_content, sub_id_sections',
												  'where' => array('sub_id' => $sub_id)));
				$this->set(array('section' => array('edit' => $sub, 'sec_id' => $sec_id)));
			}else{
				$sec_id = $this->Section->find(array('fields' => 'sec_id',
												 'where' => array('sec_id' => $sec_id)));
				if(empty($sec_id)){
					$this->e404('Cette Url n\'est pas valide, veuillez suivre les liens de navigation', 'error');
				}
				$this->set('section', $sec_id);
			}
			$this->layout = 'forum';
			$this->render('addSubject');
		}elseif($this->request->is('PUT')){
			$this->request->data = Sanitize::clean($this->request->data);
			if($this->Subject->update($this->request->data, array('where' => array('sub_id' => $sub_id)))){
				
				$this->session->setFlash('Sujet bien mis à jour !', 'success');
				$this->redirect('forum/posts/'.$sub_id);

			}else{
				$this->session->setFlash('Veuillez corriger vos erreurs !', 'error');
				$this->redirect($this->referer);
			}
		}elseif($this->request->is('POST')){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->request->data['sub_dateC'] = DateHelper::now();
			$this->request->data['sub_online'] = true;
			$this->request->data['sub_id_author'] = Auth::$session['use_id'];
			$this->request->data['sub_id_sections'] = intval($this->request->param[0]);
			if($this->Subject->save($this->request->data)){
				$this->session->setFlash('Nouveau message bien enregistré !', 'success');
				$this->redirect('forum/section/'.$sec_id);
			}else{
				
				$this->session->setFlash('Veuillez corriger vos erreurs !', 'error');
				$this->redirect($this->referer);
			}
		}
	}
	
	
	/**
	*@param $id l'identifiant du sujet été supprimer
	*@return supprime un sujet
	**/

	public function delSubject($id){
		$this->loadModel('Subject');
		if($this->Subject->delete(array('sub_id' => $id))){
			$this->session->setFlash('Sujet bien supprimé !', 'success');
			$this->redirect('forum/index');
		}else{
			$this->session->setFlash('Erreur de suppression !', 'error');
			$this->redirect($this->referer);
		}

	}
	
	/**
	*@param $id l'identifiant du sujet à vérrouiller
	*@return vérouille le sujet
	**/
	public function lockSubject($id){
		$this->loadModel('Subject');
		$check = $this->Subject->find(array('fields' => 'sub_lock', 'where' => array('sub_id' => $id)));
		$lock = current(current($check));
		$lock = ($lock == 0)? 1 : 0;
		Request::$handMade = true;
		if($this->Subject->update(array('sub_lock' => $lock), array('where' => array('sub_id' => $id)))){
			$this->session->setFlash('Sujet bien verouillé !', 'success');
			$this->redirect($this->referer);
		}else{
			$this->session->setFlash('Impossible de vérouillé', 'success');
			$this->redirect($this->referer);
		}
		Request::$handMade = false;
	}

	/**
	*@param $id l'identifiant du sujet à mettre en postit
	*@return met le sujet en postit
	**/
	public function postitOn($id){
		$this->loadModel('Subject');
		Request::$handMade = true;
		if($this->Subject->update(array('sub_postit' => true), array('where' => array('sub_id' => $id)))) {
		Request::$handMade = false;	
			$this->session->setFlash('Sujet bien mis en postit !', 'success');
			$this->redirect($this->referer);
		}else{
		Request::$handMade = false;	
			$this->session->setFlash('Erreur de mise en postit du sujet', 'error');
			$this->redirect($this->referer);
		}
	}

	/**
	*@param $id l'identifiant du sujet à ne plus mettre en postit
	*@return met le sujet en postit
	**/
	public function postitOff($id){
		$this->loadModel('Subject');
		Request::$handMade = true;
		if($this->Subject->update(array('sub_postit' => false), array('where' => array('sub_id' => $id)))) {
		Request::$handMade = false;	
			$this->session->setFlash('Sujet bien retiré !', 'success');
			$this->redirect($this->referer);
		}else{
		Request::$handMade = false;	
			$this->session->setFlash('Erreur de mise en postit du sujet', 'error');
			$this->redirect($this->referer);
		}
	}

	

	/**
	*@param $id l'identifiant de la réponse à supprimer
	*@return supprimer une réponse
	**/
	public function delReply($id){

		$this->loadModel('Replie');
		$rep_id_author = $this->Replie->find(array('fields' => 'rep_id_author',
												   'where' => array('rep_id' => $id)));
		$rep_id_author = current(current($rep_id_author));
		if(Auth::$session['use_id'] != $rep_id_author && Auth::$session['use_statut'] != 10){
			$this->session->setFlash('Vous n\'avez pas le droit d\'effectuer cette action, suivez les liens du site pour naviguer', 'error');
			$this->redirect($this->referer);

		}elseif($this->Replie->delete(array('rep_id' => $id))){
			$this->session->setFlash('Votre message a bien été supprimé !', 'success');
			
		}else{
			$this->session->setFlash('Une erreur est survenu', 'error');
		}
		$this->redirect($this->referer);
		
	}
	

	/** 
	*@param $id tous les sujet qui ont comme clé étrangère l'id de la section (methode de layout) pour action index
	*@return le nombre de sujet correspondant à la section identifié par l'id fourni en paramètre
	**/
	public function subCount($id){
		$this->loadModel('Subject');
		$count = $this->Subject->count(array('where' => array('sub_id_sections' => $id)));
		return $count;
	}

	/**
	*@param $id l'identifiant de la section pour compter le nombre de réponse affiliée (methode de layout) pour action index
	*@return le nombre de réponses correspondant à la section identifié par l'id fourni en paramètre
	**/
	public function repCount($id){
		$this->loadModel('Subject');
		$count = $this->Subject->find(array('fields' => 'count(rep_id) as rep_count',
														'join' => array(
															'type' => 'LEFT OUTER JOIN',
															'table' => array('replies','sections' ),
															'condition' => array('rep_id_subjects = sub_id', 'sub_id_sections = sec_id')),
														'where' => array('sec_id' => $id)));
		return $count;
	}

	/** 
	*@param $id tous les sujet qui ont comme clé étrangere l'id de la section (methode de layout) pour action section
	*@return le nombre de sujet correspondant à la section identifié par l'id fourni en paramètre
	**/
	public function repCount2($id){
		$this->loadModel('Replie');
		$count = $this->Replie->count(array('where' => array('rep_id_subjects' => $id)));
		return $count;
	}

	/**
	*@param $id l'identifiant de section auquel afficher son dernier post
	**/
	public function lastSubject($id){
		$this->loadModel('Section');
		$last = $this->Section->find(array('fields' => 'rep_dateC, rep_title, use_login',
										   'join' => array('type' => 'LEFT OUTER JOIN',
										   				   'table' => array('subjects', 'replies', 'users'),
										   				   'condition' => array('sec_id = sub_id_sections',
										   				   						'sub_id = rep_id_subjects',
										   				   						'use_id = rep_id_author')),
										   'where' => array('sec_id' => $id),
										   'limit' => 'LIMIT 1'));
		return $last;

	}

	/**
	*@param $id l'identifiant 
	**/
	public function lastSubject2($id){
		$this->loadModel('Subject');
		$last = $this->Subject->find(array('fields' => 'rep_dateC, rep_title, use_login',
										   'join' => array('type' => 'LEFT OUTER JOIN',
										   				   'table' => array('replies', 'users'),
										   				   'condition' => array('sub_id = rep_id_subjects',
										   				   						'use_id = rep_id_author')),
										   'where' => array('sub_id' => $id),
										   'order' => 'rep_id DESC',
										   'limit' => 'LIMIT 1'));
		return $last;	
	}
	
	/**
	*@param l'identifiant de l'utilisateur
	*@return le nombre de message + le nombre de réponse que l'utilisateur a posté avec son compte
	**/
	public function messageUserCount($id){
		$this->loadModel('Subject');
		$this->loadModel('Replie');
		$nbreS = $this->Subject->find(array('fields' => 'count(sub_id) as sub_count',
										   'where' => array('sub_id_author' => $id)));
		$nbreR = $this->Replie->find(array('fields' => 'count(rep_id) as rep_count',
										   'where' => array('rep_id_author' => $id)));
		
		$total = current(current($nbreS)) + current(current($nbreR));
			
		return $total;										
	}

	/**
	*@param $nbre le nombre de dernières réponses du forum à afficher
	**/
	public function lastReplies($nbre){
		$this->loadModel('Replie');
		$nbre = $this->Replie->find(array('fields' => 'rep_content, rep_id_subjects, rep_dateC',
										  'order' => 'rep_id DESC',
										  'limit' => 'LIMIT 2'));
		//$nbre = $nbre;
		return $nbre;
	}



	/**
	*@param $id l'identifiant du sujet pour compter le nombre de vues
	*@return le nombre de vues
	**/
	public function viewposts($id){
		$this->loadModel('Visit');
		$nbre = $this->Visit->count(array('where' => array('vis_type' => 'posts', 'vis_type_id' => $id)));
		return $nbre;
	}
}
