<?php
class BackoffController extends Controller{

	public $helpers = array('Form', 'DateHelper'); //charge les helpers passé dans le tableau

	/**
	*@return le menu du panneau d'administration du back office
	**/
	public function index(){
		$this->layout='back';
		$this->loadModel('Page');
		$data = $this->Page->find(array('fields' => 'pag_name, pag_url, pag_id, pag_src',
								'where' => array('pag_type' => 'back'),
								'order' => 'pag_id ASC'));
		$this->set('menu', $data);
		$this->render('index');
	}

	/**
	*
	**/
	public function listArticle(){
		$this->layout='back';
		$this->loadModel('Article');
		$data = $this->Article->find(array('order' => 'art_id ASC'));
		$this->set('article', $data);
		$this->render('listArticle');
	}

	/**
	*@param $id l'identifiant de l'article à modifier
	*@return une page contenant un outil d'édition de texte
	**/
	public function addArticle($id=null){
		
		$this->loadModel('Article');
		$this->loadModel('Categorie');

		if($this->request->is('GET')){
			$this->layout = 'back';
			if(isset($id) && !empty($id)){
				$data_article = $this->Article->find(array('fields' => 'art_id, art_title, art_content, art_cat_id, art_online, art_slot, art_dateM, art_dateC',
									   'where' => array('art_id' => $id)));
				$listCat = $this->Categorie->find(array('fields' => 'cat_id, cat_name'));
				if(!empty($data_article)){
					$this->set('articles', array($data_article, $listCat));
				}	
			}else{
				$listCat = $this->Categorie->find(array('fields' => 'cat_id, cat_name'));
				$this->set('listCat', $listCat);
			}
		}elseif($this->request->is('PUT')){
			$this->request->data = Sanitize::clean($this->request->data);
			debug($this->request->data);
			//die('PUT');
			$date = new DateTime('NOW', new DateTimeZone('EUROPE/Paris'));
			$this->request->data['art_dateM'] = $date->format('Y-m-d H:i');
			$this->request->data['art_use_id'] = Auth::$session['use_id'];
			$this->request->data['art_online'] = (isset($this->request->data['art_online']))? $this->request->data['art_online'] : 0;
			if($this->Article->update($this->request->data, array('where' => array(
											'art_id' => $id)))){
				//die();
				$this->session->setFlash('Article bien modifié !', 'success');
			}
			$this->redirect('backoff/listArticle');

			
		}elseif($this->request->is('POST')){
		//die('POST');
			$this->request->data = Sanitize::clean($this->request->data);
			$date = new DateTime('NOW', new DateTimeZone('EUROPE/Paris'));
			$this->request->data['art_dateC'] = $date->format('Y-m-d H:i');
			$this->request->data['art_use_id'] = Auth::$session['use_id'];
			if($this->Article->save($this->request->data)){
				$this->session->setFlash('Article bien enregistré !', 'success');
				$this->redirect('backoff/index');
			}else{
				die('haaaanan');
			}
		}
		$this->render('addArticle');
	}

	
	/**
	*@param $id l'identifiant de l'article à supprimer
	*@return suprrime l'article et redirige vers la liste des articles
	**/
	public function delArticle($id){
		$this->loadModel('Article');
		$this->Article->delete(array('art_id' => $id));
		$this->session->setFlash('Article bien supprimé !', 'success');
		$this->redirect($this->referer);
	}


	/**
	*@param $id l'identifiant de la section à editer
	**/
	public function forum($id=null){
		$this->layout = 'back';
		$this->loadModel('Section');
		if($this->request->is('GET')){
			$data['section'] = $this->Section->find();
			if(isset($id) && !empty($id)){
				$data['edit'] = $this->Section->find(array('where' => array('sec_id' => $id)));
				$this->set('sections', array($data['section'], $data['edit']));
			}else{
				$this->set('sections', $data['section']);
			}
		}elseif($this->request->is('PUT')){
			if(empty($this->request->data['sec_online'])){
				$this->request->data['sec_online'] = 0;
			}
			if($this->Section->update($this->request->data, array('where' => array('sec_id' => $id)))){
				$this->session->setFlash('Section bien modifié !');
				$this->redirect($this->referer);
			}else{
				$this->session->setFlash('Erreur de modification !');
				$this->redirect($this->referer);
			}

		}elseif($this->request->is('POST')){
			if($this->Section->save($this->request->data)){
				$this->session->setFlash('Section bien ajouté !');
				$this->redirect($this->referer);
			}else{
				$this->session->setFlash('Erreur de sauvegarde !');
			}
			
		}
		$this->render('forum');
	}

	/**
	*@param $id l'identifiant de la section à supprimer
	*@return supprime la section et tous les sujets et réponses des sujets associés à la section 
	**/
	public function delSection($id){
		$this->loadModel('Section');
		$this->loadModel('Subject');
		$this->loadModel('Replie');
		if($this->Section->delete(array('sec_id' => $id))){
			if($this->Subject->delete(array('sub_id_sections' => $id))){
			    $s_id = $this->Subject->find(array('fields' => 'sub_id',
													 'where' => array('sub_id_sections' => $id)));
				debug($s_id);
				
				foreach($s_id as $k => $v){
					foreach($v as $kk => $vv){
						debug($vv);
						if(!$this->Replie->delete(array('rep_id_subjects' => $vv))){
						  	$this->session->setFlash('Suppression des réponses impossibles !');
							$this->redirect($this->referer);

						}
					}
				}
				$this->session->setFlash('Suppression bien accomplie !');
				$this->redirect($this->referer);
				
			}else{
				$this->session->setFlash('Suppression des sujets impossibles !');
				$this->redirect($this->referer);
			}
		}else{
			$this->session->setFlash('Suppression de la sectionimpossible !');
			$this->redirect($this->referer);
		}
	}


	/**
	*@return la liste des utilisateurs du site inscris
	**/
	public function listUsers(){
		
		$this->loadModel('User');
		$data['list'] = $this->User->find();
		$this->layout = 'back';
		$this->set('users', $data['list']);
		$this->render('listUsers');
	}


	/**
	*@param $id l'identifiant de l'utilisateur à éditer
	*@return modifie l'utilisateur
	**/
	public function editUser($id){
		$this->loadModel('User');
		
		if($this->request->is('GET')){
			$this->layout = 'back';
			$user_edit = $this->User->find(array('fields' => 'use_id, use_login, use_statut, use_checked',
											 'where' => array('use_id' => $id)));
		}elseif($this->request->is('PUT')){
			if($this->User->update($this->request->data, array('where' => array('use_id' => $id)))){
				$this->session->setFlash('Modification bien effectué !');
				$this->redirect('backoff/listUsers');
			}
			
			//die();
		}
		$this->set('edit', $user_edit);
		$this->render('editUser');

	}

	/**
	*
	*
	**/
	public function listCat($id=null){
		
		
		$this->loadModel('Categorie');
		if($this->request->is('GET')){
			$this->layout = 'back';
			$data['categorie'] = $this->Categorie->find();
			if(isset($id) && !empty($id)){
				$data['edit'] = $this->Categorie->find(array('where' => array('cat_id' => $id)));
				$this->set('categories', array('list' => $data['categorie'], 'edit' => $data['edit']));
			}else{
				$this->set('categories', $data['categorie']);
			}
		}elseif($this->request->is('PUT')){
			
			if($this->Categorie->update($this->request->data, array('where' => array('cat_id' => $id)))){
				$this->session->setFlash('Catégorie bien modifiée !', 'success');
				$this->redirect('backoff/listCat');
			}else{
				$this->session->setFlash('Erreur de modification !');
				$this->redirect('backoff/listCat');
			}

		}elseif($this->request->is('POST')){
			if($this->Categorie->save($this->request->data)){
				$this->session->setFlash('Catégorie bien ajouté !');
				$this->redirect($this->referer);
			}else{
				$this->session->setFlash('Erreur de sauvegarde !');
			}
			
		}
		$this->render('listCat');
	}

	/**
	*
	**/
	public function delCat($id){
		$this->loadModel('Categorie');
		if($this->Categorie->delete(array('cat_id' => $id))){
			$this->session->setFlash('Catégorie bien supprimé !');
			$this->redirect($this->referer);
		}else{
			$this->session->setFlash('Impossible de supprimer la catégorie !');
			$this->redirect($this->referer);
		}
	}





	/**
	*@return le nom et l'url pour retourner en page d'accueil (layout)
	**/
	public function home(){
		$this->loadModel('Page');
		$data['home'] = $this->Page->find(array('fields' => 'pag_name, pag_url',
									'where' => array('pag_type' => 'back',
													 'pag_name' => 'Interface administration')));
		return $data['home'];
	}

	/**
	*@param $id l'identifiant du diplome à editer
	**/
	public function diplome($id=null){
		$this->loadModel('Diplome');
		if($this->request->is('GET')){
			$this->layout = 'back';
			$data['diplome'] = $this->Diplome->find();
			if(isset($id) && !empty($id)){
				$data['edit'] = $this->Diplome->find(array('where' => array('dip_id' => $id)));
				$this->set('diplomes', array('list' => $data['diplome'], 'edit' => $data['edit']));
			}else{
				$this->set('diplomes', $data['diplome']);
			}
		}elseif($this->request->is('PUT')){
			
			if($this->Diplome->update($this->request->data, array('where' => array('dip_id' => $id)))){
				$this->session->setFlash('Diplome bien modifiée !', 'success');
				$this->redirect('backoff/diplome');
			}else{
				$this->session->setFlash('Erreur de modification !');
				$this->redirect('backoff/diplome');
			}

		}elseif($this->request->is('POST')){
			$this->request->data['dip_img_url'] = '/parcours/diplome/default.jpg';
			if($this->Diplome->save($this->request->data)){
				$this->session->setFlash('Diplome bien ajouté !', 'success');
				$this->redirect($this->referer);
			}else{
				$this->session->setFlash('Erreur de sauvegarde !', 'error');
			}
			
		}
		$this->render('diplome');
	}

	/**
	*@param $id l'identifiant du diplome à supprimer
	**/
	public function delDiplome($id){
		$this->loadModel('Diplome');
		$this->loadModel('Udiplome');
		if($this->Diplome->delete(array('dip_id' => $id))){
			$this->Udiplome->delete(array('udi_dip_id' => $id));
			$this->session->setFlash('Diplome bien supprimé !', 'success');
			$this->redirect($this->referer);
		}else{
			$this->session->setFlash('Impossible de supprimer ce diplome !', 'error');
			$this->redirect($this->referer);
		}

	}


	/**
	*@param $id l'identifiant du diplome à editer
	*@return crée, modifie ou supprime une unité et lie ou délie l'unité à un ou plusieurs diplômes
	**/
	public function unite($id=null){
		$this->loadModel('Unite');
		$this->loadModel('Dunite');
		$this->loadModel('Diplome');
		if($this->request->is('GET')){
			$this->layout = 'back';
			$data['unite'] = $this->Unite->find(array('order' => 'uni_code ASC'));
			$listDiplome = $this->Diplome->find(array('fields' => 'dip_id, dip_name'));
			if(isset($id) && !empty($id)){
				$data['edit'] = $this->Unite->find(array('where' => array('uni_id' => $id)));
				$data['dip_unite'] = $this->Dunite->find(array('where' => array('dun_uni_id' => $id)));
				$this->set('unites', array('listU' => $data['unite'], 'edit' => $data['edit'], 'dip_unite' => $data['dip_unite'], 'listD' => $listDiplome));
			}else{
				$this->set('unites', array('listU' => $data['unite'], 'listD' => $listDiplome));
			}
		}elseif($this->request->is('PUT')){
			Request::$handMade = true;
			
			$dun_dip_id = $this->request->data['dun_dip_id'];
			unset($this->request->data['dun_dip_id']);

			if($this->Unite->update($this->request->data, array('where' => array('uni_id' => $id)))){
				if(!empty($dun_dip_id)){	
					
					$list_dip_unite = array();	
					
					$list = $this->Dunite->find(array('fields' => 'dun_dip_id','where' => array('dun_uni_id' => $id)));	
					foreach ($list as $k => $v) {
						$list_dip_unite[] = $v['dun_dip_id'];
					}
					
					debug($list_dip_unite);
					debug($dun_dip_id);
					
					$diff = array_diff($list_dip_unite, $dun_dip_id);
					debug($diff);
					if(!empty($diff)){
						foreach ($diff as $k => $v) {
							$this->Dunite->delete(array('dun_uni_id' => $id, 'dun_dip_id' => $v));
						}
					}
					$diff = array_diff($dun_dip_id, $list_dip_unite);
					debug($diff);
					if(!empty($diff)){
						foreach ($diff as $k => $v) {
							$this->Dunite->save(array('dun_uni_id' => $id, 'dun_dip_id' => $v));
						}
					}
					
				}else{
					$this->session->setFlash('Une unité d\'enseignement doit être reliée à un diplome', 'error');
					$this->redirect($this->referer);
				}	
					Request::$handMade = false;
					$this->session->setFlash('Unite d\'enseignement bien modifiée !', 'success');
					$this->redirect('backoff/unite');
			}else{
				$this->session->setFlash('Erreur de modification !', 'error');
				$this->redirect('backoff/unite');
			}

		}elseif($this->request->is('POST')){
			Request::$handMade = true;
			
			$dun_dip_id = $this->request->data['dun_dip_id'];
			unset($this->request->data['dun_dip_id']);
			
			//on check si il existe ou non déjà cette UV
			$check = $this->Unite->find(array('where' => array('uni_name' => $this->request->data['uni_name'])));
			debug($check);
			
			// si il existe pas
			if(empty($check)){
				$this->request->data['uni_img_url'] = '/parcours/UE/default.jpg';
				if($this->Unite->save($this->request->data)) {
					//on récupère l'id de l'unité fraichement inseré en bdd
					$uni_id = $this->Unite->find(array(
						'fields' => 'uni_id', 
						'where' => array('uni_code' => $this->request->data['uni_code']))); 
					$uni_id = current(current($uni_id));
					foreach ($dun_dip_id as $k => $v) {
						if(!$this->Dunite->save(array('dun_dip_id' => $v, 'dun_uni_id' => $uni_id))){
							$this->session->setFlash('Erreur de sauvegarde', 'error');
							$this->redirect($this->referer);
							break;
						}
					}
				$this->session->setFlash('UV bien sauvegardé', 'success');
				$this->redirect($this->referer);
				}else{
					$this->session->setFlash('Erreur de sauvegarde !', 'error');
				}
				
			}else{
				$this->session->setFlash('Cet Unité d\'enseignement existe déjà dans votre base de données', 'error');
				$this->redirect($this->referer);
			}
			Request::$handMade = false;
			
		}
			
		$this->render('unite');	
		
		
	}

	/**
	*@param $id l'identifiant du diplome à supprimer
	**/
	public function delUnite($id){
		$this->loadModel('Unite');
		$this->loadModel('Dunite');
		if($this->Unite->delete(array('uni_id' => $id))){
			if($this->Dunite->delete(array('dun_uni_id' => $id))){
				$this->session->setFlash('UV bien supprimé !', 'success');
				$this->redirect('backoff/unite');
			}
			
		}else{
			$this->session->setFlash('Impossible de supprimer ceT UV !', 'error');
			$this->redirect($this->referer);
		}

	}

	/**
	*@param $id l'identifiant du diplome auquel rattaché l'image uploadé
	**/
	public function DIPavatar($id){
		$this->loadModel('Diplome');
		$dip = $this->Diplome->find(array('fields' => 'dip_code', 'where' => array('dip_id' => $id)));
		$dipcode = current(current($dip));
		$img_diplome = (!empty($this->request->file['dipImage']))? $this->request->file['dipImage'] : '';
		debug($this->request->data);
		debug($img_diplome);
		
		
		if(preg_match('/[.jpg|.png|.gif]$/', $img_diplome['name']) && $img_diplome['size'] <= $this->request->data['max_size'] && !$img_diplome['error']){
			$ext = explode('.', $img_diplome['name']);
			$file ='parcours'.DS.'diplome'.DS.$dipcode.'.'.end($ext);
			$dest = WEBROOT.DS.'img'.DS;
			if(move_uploaded_file($img_diplome['tmp_name'], $dest.$file)){
				$this->request->data['dip_img_url'] = preg_replace('#\\\#', '/', $file);
				debug($this->request->data);
				
				if($this->Diplome->update($this->request->data, array('where' => array('dip_id' => $id)))) {
					
					$this->session->setFlash('Image bien uplodé !', 'success');
					$this->redirect($this->referer);
				}else{
					die();
					$this->session->setFlash('L\'image n\'a pas pu être inseré correctment', 'error');
					$this->redirect($this->referer);
				}
			}else{
				die('L\'image n\'a pas été déplacé');
			}

		}else{
			$this->session->setFlash('Format de l\'image doit etre jpg, jpeg ou png');
			$this->redirect($this->referer);
		}
	}

	/**
	*@param
	**/
	public function UEavatar($id){
		$this->loadModel('Unite');
		$ue = $this->Unite->find(array('fields' => 'uni_code', 'where' => array('uni_id' => $id)));
		$unicode = current(current($ue));
		$img_unite = (!empty($this->request->file['uniImage']))? $this->request->file['uniImage'] : '';
		debug($this->request->data);
		debug($img_unite);
		
		
		if(preg_match('/[.jpg|.png|.gif]$/', $img_unite['name']) && $img_unite['size'] <= $this->request->data['max_size'] && !$img_diplome['error']){
			$ext = explode('.', $img_unite['name']);
			$file ='parcours'.DS.'UE'.DS.$unicode.'.'.end($ext);
			$dest = WEBROOT.DS.'img'.DS;
			if(move_uploaded_file($img_unite['tmp_name'], $dest.$file)){
				$this->request->data['uni_img_url'] = preg_replace('#\\\#', '/', $file);
				debug($this->request->data);
				
				if($this->Unite->update($this->request->data, array('where' => array('uni_id' => $id)))) {
					
					$this->session->setFlash('Image bien uplodé !', 'success');
					$this->redirect($this->referer);
				}else{
					
					$this->session->setFlash('L\'image n\'a pas pu être inseré correctment', 'error');
					$this->redirect($this->referer);
				}
			}else{
				die('L\'image n\'a pas été déplacé');
			}

		}else{
			$this->session->setFlash('Format de l\'image doit etre jpg, jpeg ou png');
			$this->redirect($this->referer);
		}

	}
	/**
	 *@name fileExplorer
	 *@description explorateur de fichier sur le serveur web
	 *@param (string)$folder vaut stories par défaut
	 *@return (array)folder_content
	 * */
	public function fileExplorer($folder='stories'){
		if($this->request->is('GET')){
			$this->layout = 'back';
			$prev = explode('|', $folder);
			$i = count($prev);
			unset($prev[$i-1]);
			unset($prev[$i]);
			$back = implode('|',$prev);
			$folder = str_replace('|','/',$folder);
			$dir = WEBROOT.'/'.$folder;
			$folder = str_replace('/', '|',$folder);
			$list = array();
			if(is_dir($dir)){
				if($dir_content = opendir($dir)){
					while(($file = readdir($dir_content)) !== false){
						if($file !== '.' && $file !== '..'){
						/*echo "<a href=".BASE_URL.'/backoff/fileExplorer/'.$folder.'|'.$file.">fichier : $file : type : ". filetype($dir .'/'.$file).'</a><br>';*/
							$list[] = $file;
						}
					}
					closedir($dir_content);
				}
	
			}else{
				$this->session->setFlash('Erreur d\'url veuillez suivre les liens de navigations','error');
				$this->redirect($this->referer);
			}
		}else if($this->request->is('POST')){
			debug($folder);
			debug($this->request->data);
			debug($this->request->file);
			$nfile = (!empty($this->request->file['new_file']))? $this->request->file['new_file'] : '';
			$dest = WEBROOT.DS;
			$folder = str_replace('|', '/', $folder);
			//die();
			if(move_uploaded_file($nfile['tmp_name'], $dest.$folder.DS.$nfile['name'])){
				$this->session->setFlash('Fichier bien ajouté', 'success');
				$this->redirect($this->referer);
				exit();
			}
		}
		$this->set('explorer', array('file' => $list, 'folder' => $folder, 'back' => $back));
		$this->render('explorer');
	}	
}
