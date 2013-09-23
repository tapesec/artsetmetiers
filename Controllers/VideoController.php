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
		$this->loadModel('Categorie');
		$this->layout = 'forum';
		$data = $this->Article->find(array('fields' => 'art_id,
		       						art_title,
								art_content,
								art_cat_id,
								art_dateC,
								art_cov,
								art_youtube,
								art_level,
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
		$listCat = $this->Categorie->find(array('where' => array('cat_type' => 'tutoriel')));
		$this->set('article', array('video' => $data, 'listCat' => $listCat));
		$this->render('index');
	}

	/**
	 *@name getCat
	 *@description fonction qui récupère les tutos vidéo par catégorie
	 *@param $id l'identifiant de la catégorie
	 *@return les tuiles en fonction de la catégorie choisie
	 **/
	public function getCat($id) {
		$this->loadModel('Article');
		$data = $this->Article->find(array('fields' => 'art_id,
		       						art_title,
								art_content,
								art_cat_id,
								art_dateC,
								art_cov,
								art_youtube,
								art_level,
								cat_id,
								cat_name,
								use_id,
							       	use_login',
							'where' => array(
							 	'art_slot' => 'Tutoriel vidéo',
								'art_online' => true,
								'art_cat_id' => $id),
							 'join' => array(
								'type' => 'LEFT OUTER JOIN',
								'table' => array('categories', 'users'),
								'condition' => array('art_cat_id = cat_id',
								'art_use_id = use_id'))));?>
	
	<div class="row-fluid">
	<?php $i = 0;	
	foreach ($data as $k => $v):
		if($i == 4): ?>
	</div>
	<div class="row-fluid">	
	<?php $i =0; endif; ?>
	<div data-cat="<?php echo $v['cat_name']; ?>" itemscope itemtype="http://schema.org/Article" class="span3 video-tuile">
	<article>
	<img class="cover" src="<?php echo BASE_URL.$v['art_cov']; ?>" alt="image d\'illustration">
	<h4 itemprop="name" class="text-success"><?php echo $v['art_title']; ?></h4>
	<p itemprop="articleBody" class="description">
	<?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 15); ?>
	</p><a href="<?php echo BASE_URL.'/video/voir/'.$v['art_id']; ?>">
	<div class="cover_hover">
		<p><?php $this->img('/design/img/button_play.png',array('class' => 'button_play')); ?></p>	
		<p class="category"><?php echo '#'.$v['cat_name']; ?></p>
		<p class="date"><?php echo DateHelper::fr($v['art_dateC']); ?></p>	
		<p class="level"><?php echo ucfirst($v['art_level']); ?></p>
	</div></a>
	</article>
	</div>
	<?php $i++; 
	endforeach;?>
        </div>	
<?php
	}


	/**
	*@name voir
	*@description affiche la page pour visionner le tutoriel vidéo
	*@param $id, l'identifiant du tutoriel à regarder
	*@return la page pour voir le tutoriel
	* */
	public function voir($id, $id_com=null, $com_id_user=null){
		
		$this->loadModel('Article');
		$this->loadModel('Comment');
		
		if(!$id){
			$this->e404('Il y a une erreur dans votre url');
		}
		if($this->request->is('GET')){
			$data = $this->Article->find(array('fields' => 'art_id, art_title, art_youtube, art_level, art_content, art_dateC, cat_name, use_login, use_id',
									 'where' => array(
									 	'art_slot' => 'Tutoriel vidéo',
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
			$this->layout = 'forum';
		}elseif($this->request->is('PUT')){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->request->data['com_name_editor'] = Auth::$session['use_login'];
			$this->request->data['com_dateM'] = DateHelper::now();
			if($this->Comment->update($this->request->data, array('where' => array('com_id' => $id_com)))){
				$this->session->setFlash('Message bien edité !', 'success');
				$this->redirect('video/voir/'.$id);

			}else{
				$this->session->setFlash('Erreur lors de l\'édition de votre commentaire', 'error');
				$this->redirect('video/voir/'.$id);
			}

		}elseif($this->request->is('POST')){
			$this->request->data = Sanitize::clean($this->request->data);
			$this->request->data['com_dateC'] = DateHelper::now();
			$this->request->data['com_id_user'] = Auth::$session['use_id'];
			$this->request->data['com_id_article'] = $id;
			if($this->Comment->save($this->request->data)){
				$this->session->setFlash('Commentaire sauvegardé !', 'success');
				$this->redirect('video/voir/'.$id);
			}else{
				$this->session->setFlash('Veuillez corriger vos erreurs !', 'error');
				$this->redirect('video/voir/'.$id);
			}
		}
		
		$this->render('voir');
	}

}
