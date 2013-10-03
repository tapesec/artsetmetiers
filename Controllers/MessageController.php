<?php
class MessageController extends Controller{
	
	
	public $helpers = array('Form', 'DateHelper', 'Truncate'); //charge les helpers passé dans le tableau

	/**
	*
	*@return la page d'accueil des messages privées
	**/
	public function index(){
		$this->layout="forum";
		$this->loadModel('Message');
		$message = $this->Message->find(array('fields' => 'use_id, use_login, mes_id, mes_title, mes_content, mes_id_author, mes_id_dest, mes_dateC, mes_auth_del, mes_dest_del, ava_url',
						      'join' => array(
						      		'type' => 'LEFT OUTER JOIN',
						  		'table' => array('users', 'avatars'),
								'condition' => array('mes_id_author = use_id', 'ava_id_user = use_id')),
						      'where' => array('mes_id_dest' => Auth::$session['use_id'], 'OR' => true, 'mes_id_author' => Auth::$session['use_id']),
						      'order' => 'mes_dateC ASC'));

		
		if(isset($message) && !empty($message)):
		foreach($message as $k => $v){
			if($v['mes_id_author'] == Auth::$session['use_id'] && $v['mes_auth_del'] == true ) {
				unset($message[$k]);
			}
			if($v['mes_id_dest'] == Auth::$session['use_id'] && $v['mes_dest_del'] == true ) {
				unset($message[$k]);
			}
		}
		endif;

		$this->set('list_message', $message);
		$this->render('index'); 
	}

	/**
	 *
	 * */
	public function mesCount() {
		$this->loadModel('Message');
		
		$mes_author = $this->Message->count(array('where' => array('mes_auth_show' => false,
		       				 	  'mes_id_author' => Auth::$session['use_id'])));
		$mes_dest =  $this->Message->count(array('where' => array('mes_dest_show' => false,
						          'mes_id_dest' => Auth::$session['use_id'])));

		$result =  $mes_author + $mes_dest;
		return $result;

	
	}


	/**
	 *@param $id, l'identifiant du message à consulter
	 *@return $conversation la conversation
	 * */
	public function voir($id) {
		$this->layout = 'forum';
		$this->loadModel('Message');
		$this->loadModel('Reponse');
		$message = $this->Message->find(array('fields' => 'use_id, use_login, mes_id,mes_title, mes_content, mes_id_author, mes_id_dest, mes_dateC, mes_auth_show, mes_dest_show, ava_url',
						      'join' => array(
						      		'type' => 'LEFT OUTER JOIN',
						  		'table' => array('users', 'avatars'),
								'condition' => array('mes_id_author = use_id', 'ava_id_user = use_id')),
						      'where' => array('mes_id' => $id), 		     		            			        'order' => 'mes_dateC ASC'));
				
		if($message[0]['mes_id_author'] != Auth::$session['use_id'] &&  $message[0]['mes_id_dest'] != Auth::$session['use_id']):
			$this->e404('Vous n\'êtes pas autorisé à acceder à cette page ou celle-ci n\'existe pas suivez les liens de navigation');
		endif;

		$reponses = $this->Reponse->find(array('fields' => 'rep_id, rep_content, rep_dateC, use_id, use_login, ava_url',
						       'join' => array(
							       'type' => 'LEFT OUTER JOIN',
							       'table' => array('users', 'avatars'),
							       'condition' => array('rep_id_author = use_id', 'ava_id_user = use_id')),
						       'where' => array('rep_id_mes' => $id),
						       'order' => 'rep_dateC ASC'));

		Request::$handMade = true;
		if($message[0]['mes_id_author'] == Auth::$session['use_id']) {
			$this->Message->update(array('mes_auth_show' => true), array('where' => array('mes_id' => $id)));
		}else{
			$this->Message->update(array('mes_dest_show' => true), array('where' => array('mes_id' => $id)));	
		}
		Request::$handMade = false;

		$this->set('conversation', array('message' => $message,'reponse' => $reponses));
		$this->render('voir');
	}

	/**
	 *@param $id, l'identifiant du message initiale
	 *@return sauvegarde la réponse dans la base de données
	 * */
	public function repondre($id){
		$this->loadModel('Message');
		$this->loadModel('Reponse');
		if($this->request->is('POST') && !empty($this->request->data)) {
			$this->request->data['rep_dateC'] = DateHelper::now();
			$this->request->data['rep_id_mes'] = $id;
			$this->request->data['rep_id_author'] = Auth::$session['use_id'];
			if($this->Reponse->save($this->request->data)) {
				Request::$handMade = true;
				$this->Message->update(array('mes_dest_del' => false, 'mes_auth_del' => false, 'mes_auth_show' => false, 'mes_dest_show' => false), array('where' => array('mes_id' => $id)));
				Request::$handMade = false;	
				$this->session->setFlash('Votre réponse a bien été envoyé', 'success');
				$this->redirect($this->referer);
			}else{
				$this->session->setFlash('Votre réponse n\'a pas pu être envoyé retentez l\'opération ou contacter l\'administrateur du site', 'error');
				$this->redirect($this->referer);

			}

		}
	}

	/**
	*@return envoie un message à l'utilisateur selectionné dans le formulaire
	* */
	public function ecrire() {
		$this->layout='forum';
		$this->loadModel('Message');
		$this->loadModel('User');
		if($this->request->is('POST')) {
			$login = $this->request->data['use_login'];
			$id = $this->User->find(array('fields' => 'use_id',
						      'where' => array('use_login' => $login)));
			$id = current(current($id));
			if($id == Auth::$session['use_id']){
				$this->session->setFlash('Vous tentez de vous envoyer un message privée', 'error');
				$this->redirect($this->referer);
				exit(0);
			}
			if(isset($id)) {
				$this->request->data['mes_dateC'] = DateHelper::now();
				$this->request->data['mes_id_dest'] = $id;
				$this->request->data['mes_id_author'] = Auth::$session['use_id'];
				unset($this->request->data['use_login']);
				if($this->Message->save($this->request->data)) {
					
					$this->session->setFlash('Message bien envoyé à '.$login, 'success');
					$this->redirect($this->referer);
				}else{
					
					$this->session->setFlash('Echec dans l\'envoie du message veuillez réessayer ou contacter l\'administrateur du site', 'error');
					$this->redirect($this->referer);
				}
			}	
		}else{
			$this->session->setFlash('Erreur dans l\'envoie du message veuillez réessayer', 'error');
			$this->redirect($this->referer);
		}
	}


	/**
	 *@param $id, l'identifiant du message à supprimer
	 *@return supprime le message et toute la conversation associée
	 * */
	public function delete() {
		$this->loadModel('Message');
		$this->loadModel('Reponse');
		Request::$handMade = true;
		debug($this->request->data);
		if(!isset($this->request->data['mes_dest_del']) && !isset($this->request->data['mes_auth_del'])):
			$this->redirect('message/index');
			$this->session->setFlash('vous ne pouvez pas faire ça ! attention','error');
			exit();
		endif;

		if(isset($this->request->data['mes_dest_del'])) {
			$dest_del = $this->request->data['mes_dest_del'];
			foreach($dest_del as $k => $v) {
				if(!$this->Message->update(array('mes_dest_del' => true), 
				array('where' => array('mes_id' => $v)))) {
					$this->session->setFlash('Une erreur est survenu, veuillez réessayer ou contacter l\'administrateur du site', 'error');
					$this->redirect($this->referer);
					exit();
				}else{  }
			}
		}
		if(isset($this->request->data['mes_auth_del'])) {
			$auth_del = $this->request->data['mes_auth_del'];
			foreach($auth_del as $k => $v) {
				if(!$this->Message->update(array('mes_auth_del' => true), 
				array('where' => array('mes_id' => $v)))) {
					$this->session->setFlash('Une erreur est survenu, veuillez réessayer ou contacter l\'administrateur du site', 'error');
					$this->redirect($this->referer);
					exit();
				}
			}
		}
		
		Request::$handMade = false;
		$mes2del = $this->Message->find(array('fields' => 'mes_id',
		       				      'where' => array('mes_dest_del' => true,
						      'mes_auth_del' => true)));

			
		$this->Message->delete(array('mes_dest_del' => true, 'mes_auth_del' => true));

		if(!empty($mes2del)) {
			foreach($mes2del as $k => $v) {
				$this->Reponse->delete(array('rep_id_mes' => $v['mes_id']));
			}
		}
		$this->session->setFlash('Journal des MP bien mis à jour', 'success');
		$this->redirect($this->referer);	

	}

	/** (methode ajax !)
	 *@param mixed $keyUp, les lettres tapées dans le champ de recherche d'un pseudo (minimum 2)
	 *@return les pseudos trouvées dans la base de données du site 
	 * */
	public function getLogin($keyUp){
		$this->loadModel('User');
				
		$users = $this->User->search(array('fields' => 'use_login',
						   'like' => array('use_login' => $keyUp.'%'),
						   'order' => 'use_login ASC'));
		foreach($users as $k => $v): ?>
			<option value="<?php echo $v['use_login']; ?>"><?php echo $v['use_login']; ?></option><?php echo PHP_EOL; ?>
		<?php endforeach; 
		
	}
}


?>
