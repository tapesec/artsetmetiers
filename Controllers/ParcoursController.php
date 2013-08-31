<?php

class ParcoursController extends Controller{

	public $helpers = array('Form', 'Truncate', 'DateHelper', 'Markitup');


	/**
	*@param $id l'identifiant de la carte de visite à regarder
	*@return la carte de visite de l'utilisateur connecté
	**/
	public function voir($identifiant=null){
		//si pas d'intentifiant passé en paramètre alors on affichera la page de l'utilisateur connecté
			
		$this->loadModel('User');
		$this->loadModel('Udiplome');
		$this->loadModel('Uunite');
		$id = (isset($identifiant))? $identifiant : Auth::$session['use_id'];
		
		$check = $this->User->find(array('where' => array('use_id' => $id)));
		if(empty($check)){
			$this->e404('Cette page n\'existe pas veuillez suivre les liens de navigation');
		}
		$user = $this->User->find(array('join' => array(
											'type' => 'LEFT OUTER JOIN',
											'table' => array('udiplomes', 'diplomes', 'avatars'),
											'condition' => array('use_id = udi_use_id', 'dip_id = udi_dip_id', 'use_id = ava_id_user')),
										'where' => array('use_id' => $id)));
			
		$diplomes = $this->Udiplome->find(array('join' => array(
													'type' => 'LEFT OUTER JOIN',
													'table' => array('diplomes', 'dunites', 'unites'),
													'condition' => array('udi_dip_id = dip_id', 'dun_dip_id = dip_id', 'dun_uni_id = uni_id')),
												'where' => array('udi_use_id' => $id)));


		$unite_get = $this->Uunite->find(array('join' => array(
													'type' => 'LEFT OUTER JOIN',
													'table' => 'unites',
													'condition' => 'uun_uni_id = uni_id'),
												'where' => array('uun_use_id' => $id, 'uun_uni_statut' => true)));
		
		$unite_progress = $this->Uunite->find(array('join' => array(
													'type' => 'LEFT OUTER JOIN',
													'table' => 'unites',
													'condition' => 'uun_uni_id = uni_id'),
												'where' => array('uun_use_id' => $id, 'uun_uni_statut' => false)));

		$this->layout = 'main';
		$this->set('visite', array('user' => $user, 'diplomes' => $diplomes, 'unite_get' => $unite_get, 'unite_progress' => $unite_progress));
		$this->render('voir');
	}

	/**
	*met à jour les informations de la carte de visite de l'utilisateur
	**/
	public function edit(){
		$this->loadModel('Udiplome');
		$this->loadModel('Uunite');
		$this->loadModel('Diplome');
		$this->loadModel('Unite');
		$this->loadModel('User');
		
		$user = $this->Udiplome->find(array('where' => array('udi_use_id' => Auth::$session['use_id'])));
		$user2 = $this->Uunite->find(array('where' => array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_statut' => true)));
		$user3 = $this->Uunite->find(array('where' => array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_statut' => false)));
		$diplome = $this->Diplome->find();
		$unite = $this->Unite->find();
		$obs = $this->User->find(array('fields' => 'use_obs', 'where' => array('use_id' => Auth::$session['use_id'])));
		//$obs = Sanitize::show($obs);
		$this->set('enseignement', array('diplome' => $diplome, 'Unite' => $unite, 'diplome_user' => $user, 'unite_user_success' => $user2, 'unite_user_progress' => $user3, 'obs' => $obs));
		$this->layout='main';
		$this->render('edit');
	}

	/**
	*@return sauvegarde ou met à jour les diplomes obtenu par l'utilisateur connecté en fonction des checkboxs des diplomes du cnam cochés ou non
	**/
	public function addDiplome(){
		$this->loadModel('Udiplome');
		//on récupère tous les diplomes obtenus par l'user
		$listDiplome = $this->Udiplome->find(array('fields' => 'udi_dip_id',
												   'where' => array('udi_use_id' => Auth::$session['use_id']),
												   'order' => 'udi_id ASC'));
		
		//conversion du tableau associatif $listdiplome en tableau simple pour pouvoir comparer avec les cases coché ou non dans le formulaire
		foreach ($listDiplome as $k => $v) {
			$check[] = $v['udi_dip_id'];
		}
		Request::$handMade = true;
		//si l'utilisateur a obtenu des diplomes ..
		if(!empty($check)){
			/* ..on verifie que des cases été cochés quand le visiteur a validé le formulaire de selection des diplomes dans la page edit
			sinon on transphorme son formulaire en tableau vide pour comparer avec les diplomes stocké en base de données*/
			$this->request->data['udi_dip_id'] = (!isset($this->request->data['udi_dip_id']) || empty($this->request->data['udi_dip_id']))? array() : $this->request->data['udi_dip_id']; 
			// .. on effectue la comparaison dabord dans un sens pour voir si il y a moins de case cohé dans le formulaire des diplomes que de diplome en BDD
			$diff = array_diff($check, $this->request->data['udi_dip_id']);
			//debug($diff);

			// $diff return les ids des diplomes qu'il y a en + dans la bdd
			// .. si il y a plus de diplomes attribué à l'user en BDD que dans son formulaire ..
			if(!empty($diff)){
				foreach ($diff as $k => $v) {
					//on supprime les diplomes en trop
					//debug($v);
					
					$this->Udiplome->delete(array('udi_use_id' => Auth::$session['use_id'], 'udi_dip_id' => $v));
				}
			}
			// on fait la comparaison à présent dans l'autre sens
			$diff = array_diff($this->request->data['udi_dip_id'], $check);
			// $diff renvoie cette fois les diplomes en plus dans le formulaire que ce qu'il possede dans la BDD
			//debug($diff);
			//die();
			if(!empty($diff)){
				//si il y en a on les insere donc en BDD
				foreach ($diff as $k => $v) {
					$this->Udiplome->save(array('udi_use_id' => Auth::$session['use_id'], 'udi_dip_id' => $v));
				}
			}
		}else{
		//si l'utilisateur n'a pas de diplome obtenus en base de données ..	
			if(!empty($this->request->data['udi_dip_id'])){
				// et si des diplomes sont coché dans le formulaire
				$data = $this->request->data['udi_dip_id'];
				foreach ($data as $k => $v) {
					//on les inseres
					$this->Udiplome->save(array('udi_use_id' => Auth::$session['use_id'], 'udi_dip_id' => $v));	
				}
			}
		}
		
		Request::$handMade = false;
		
		$this->session->setflash('Merci d \'avoir completez vos informations', 'success');
		$this->redirect($this->referer);
	}
	/**
	 *@name getDiplomes
	 *@description charge en ajax la liste des diplomes de la base de données
	 *@param (mixed)$keyUp, les caractères tapés dans le formulaire par l'utilisateur
	 *@return la liste des resultats dans des balises options
	 * */
	public function getDiplomes($keyUp) {

		$this->loadModel('Diplome');
		$diplome = $this->Diplome->search(array('fields' => 'dip_id, dip_name, dip_code',
						   'like' => array('dip_name' => '%'.$keyUp.'%', 'OR' => true, 'dip_code' => '%'.$keyUp.'%'),
						   'order' => 'dip_name ASC'));

		foreach($diplome as $k => $v): ?>
			<option value="<?php echo $v['dip_id']; ?>"><?php echo $v['dip_code'].' '.$v['dip_name']; ?></option><?php echo PHP_EOL; ?>
		<?php endforeach; 
		
	}


	/**
	 *@name getUnites
	 *@description charge en ajax la liste des UEs de la base de données
	 *@param (mixed)$keyUp, les caractères tapés dans le formulaire par l'utilisateur
	 *@return la liste des resultats dans des balises options
	 * */
	public function getUnites($keyUp) {

		$this->loadModel('Unite');
		$unite = $this->Unite->search(array('fields' => 'uni_id, uni_name, uni_code',
						   'like' => array('uni_name' => '%'.$keyUp.'%', 'OR' => true, 'uni_code' => '%'.$keyUp.'%'),
						   'order' => 'uni_name ASC'));

		foreach($unite as $k => $v): ?>
			<option value="<?php echo $v['uni_id']; ?>"><?php echo $v['uni_code'].' '.$v['uni_name']; ?></option><?php echo PHP_EOL; ?>
		<?php endforeach; 
		
	}

	/**
	 *@name getUnitesIP
	 *@description charge en ajax la liste des UEs en cours d'obtentino de la base de données
	 *@param (mixed)$keyUp, les caractères tapés dans le formulaire par l'utilisateur
	 *@return la liste des resultats dans des balises options
	 * */
	public function getUnitesIP($keyUp) {

		$this->loadModel('Unite');
		$unite = $this->Unite->search(array('fields' => 'uni_id, uni_name, uni_code',
						   'like' => array('uni_name' => '%'.$keyUp.'%', 'OR' => true, 'uni_code' => '%'.$keyUp.'%'),
						   'order' => 'uni_name ASC'));

		foreach($unite as $k => $v): ?>
			<option value="<?php echo $v['uni_id']; ?>"><?php echo $v['uni_code'].' '.$v['uni_name']; ?></option><?php echo PHP_EOL; ?>
		<?php endforeach; 
		
	}



	/**
	 *@name showDiplome
	 *@description fonction qui affiche les diplomes de l'utilisateur en ajax
	 *@return
	 * */
	public function showDiplome() {
		$this->loadModel('Udiplome');
		$data = $this->Udiplome->find(array('fields' => 'dip_id, dip_name, dip_code',
							'join' => array(
								'type' => 'LEFT OUTER JOIN',
								'table' => 'diplomes',
								'condition' => 'dip_id=udi_dip_id'),
							'where' => array('udi_use_id' => Auth::$session['use_id'])));
		
		if(!empty($data)) {
			foreach($data as $k => $v) {
				echo '<div id="dipTicket" class="alert alert-success">
					<button type="button" class="close">&times;</button>
					<span data-id="'.$v['dip_id'].'"> '.$v['dip_code'].' '.$v['dip_name'].'</span></div>';
			}
				
		}else {
			echo '<p id="noDiplome">Aucun diplôme</p>';
		}

	}

	/**
	 *@name showUnite
	 *@description fonction qui affiche les Unités d'enseignement de l'utilisateur en ajax
	 *@return
	 * */
	public function showUnite() {
		$this->loadModel('Uunite');
		$data = $this->Uunite->find(array('fields' => 'uni_id, uni_name, uni_code',
							'join' => array(
								'type' => 'LEFT OUTER JOIN',
								'table' => 'unites',
								'condition' => 'uni_id=uun_uni_id'),
							'where' => array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_statut' => true)));
		
		if(!empty($data)) {
			foreach($data as $k => $v) {
				echo '<div id="uniTicket" class="alert alert-success">
					<button type="button" class="close">&times;</button>
					<span data-id="'.$v['uni_id'].'"> '.$v['uni_code'].' '.$v['uni_name'].'</span></div>';
			}
				
		}else {
			echo '<p id="noUnite">Aucune Unité d\'Enseignement</p>';
		}

	}

	
	/**
	 *@name showUniteIP
	 *@description fonction qui affiche les Unités d'enseignement en cours de l'utilisateur en ajax
	 *@return
	 * */
	public function showUniteIP() {
		$this->loadModel('Uunite');
		$data = $this->Uunite->find(array('fields' => 'uni_id, uni_name, uni_code',
							'join' => array(
								'type' => 'LEFT OUTER JOIN',
								'table' => 'unites',
								'condition' => 'uni_id=uun_uni_id'),
							'where' => array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_statut' => false)));
		
		if(!empty($data)) {
			foreach($data as $k => $v) {
				echo '<div id="uniTicketIP" class="alert alert-success">
					<button type="button" class="close">&times;</button>
					<span data-id="'.$v['uni_id'].'"> '.$v['uni_code'].' '.$v['uni_name'].'</span></div>';
			}
				
		}else {
			echo '<p id="noUniteIP">Aucune Unité d\'Enseignement</p>';
		}

	}


	/**
	 *@name saveDiplomes
	 *@description fonction ajax qui sauvegarde un nouveau diplome obtenu par l'utilisateur
	 *@param (int)$id
	 *@return (string)$info le message de réussite ou d'erreur
	 * */	
	public function saveDiplomes($id) {
		$this->loadModel('Udiplome');
		Request::$handMade = true;
		if(!$this->Udiplome->find(array('where' => array('udi_use_id' => Auth::$session['use_id'],
								'udi_dip_id' => $id)))) {
			if($this->Udiplome->save(array('udi_use_id' => Auth::$session['use_id'],
							'udi_dip_id' => $id))){
				echo 'saveSuccess';
			}else{
				echo 'saveError';
			}
		}else{	
			echo "saved";
		}
	}

	
	/**
	 *@name saveUnites
	 *@description fonction ajax qui sauvegarde une nouvelle UE obtenu par l'utilisateur
	 *@param (int)$id
	 *@return (string)$info le message de réussite ou d'erreur
	 * */	
	public function saveUnites($id) {
		$this->loadModel('Uunite');
		Request::$handMade = true;
		if(!$this->Uunite->find(array('where' => array('uun_use_id' => Auth::$session['use_id'],
								'uun_uni_id' => $id, 'uun_uni_statut' => true)))) {
			if($this->Uunite->save(array('uun_use_id' => Auth::$session['use_id'],
							'uun_uni_id' => $id, 'uun_uni_statut' => true))){
				echo 'saveSuccess';
			}else{
				echo 'saveError';
			}
		}else{	
			echo "saved";
		}
		Request::$handMade = false;

	}

	/**
	 *@name saveUnitesIP
	 *@description fonction ajax qui sauvegarde une nouvelle UE en cours d'obtention par l'utilisateur
	 *@param (int)$id
	 *@return (string)$info le message de réussite ou d'erreur
	 * */	
	public function saveUnitesIP($id) {
		$this->loadModel('Uunite');
		Request::$handMade = true;
		if(!$this->Uunite->find(array('where' => array('uun_use_id' => Auth::$session['use_id'],
								'uun_uni_id' => $id)))) {
			if($this->Uunite->save(array('uun_use_id' => Auth::$session['use_id'],
							'uun_uni_id' => $id, 'uun_uni_statut' => false))){
				echo 'saveSuccess';
			}else{
				echo 'saveError';
			}
		}else{	
			echo "saved";
		}
		Request::$handMade = false;

	}


	/**
	 *@name delDiplome
	 *@description fonction Ajax qui retire un diplome de la carte de l'utilisateur en cliquant sur la croix
	 *@param (int)$id, l'identifiant du diplome à supprimer
	 *@return (string)statut , le résultat de la requete en base de données.
	 * */
	public function delDiplome($id) {
		$this->loadModel('Udiplome');
		if($this->Udiplome->delete(array('udi_use_id' => Auth::$session['use_id'], 'udi_dip_id' => $id))) {
			echo "delSuccess";
		}else {
			echo "delError";
		}
	}


	/**
	 *@name delUnite
	 *@description fonction Ajax qui retire une UE de la carte de l'utilisateur en cliquant sur la croix
	 *@param (int)$id, l'identifiant de l'UE à supprimer
	 *@return (string)statut , le résultat de la requete en base de données.
	 * */
	public function delUnite($id) {
		$this->loadModel('Uunite');
		if($this->Uunite->delete(array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_id' => $id))) {
			echo "delSuccess";
		}else {
			echo "delError";
		}
	}


	/**
	 *@name delUniteIP
	 *@description fonction Ajax qui retire une UE en cours d'obtention de la carte de l'utilisateur en cliquant sur la croix
	 *@param (int)$id, l'identifiant de l'UE à supprimer
	 *@return (string)statut , le résultat de la requete en base de données.
	 * */
	public function delUniteIP($id) {
		$this->loadModel('Uunite');
		if($this->Uunite->delete(array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_id' => $id))) {
			echo "delSuccess";
		}else {
			echo "delError";
		}
	}






	/**
	*@return sauvegarde ou met à jour les UV obtenus par l'utilisateur connecté en fonction des checkboxs des UV du cnam cochés ou non
	**/
	public function addUniteValid($bool){
		debug($bool);
		$bool = ($bool==1)? true : false;
		
		$this->loadModel('Uunite');
		//on récupère tous les diplomes obtenus par l'user
		$listUnite = $this->Uunite->find(array('fields' => 'uun_uni_id',
												   'where' => array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_statut' => $bool),
												   'order' => 'uun_id ASC'));
		
		//conversion du tableau associatif $listdiplome en tableau simple pour pouvoir comparer avec les cases coché ou non dans le formulaire
		foreach ($listUnite as $k => $v) {
			$check[] = $v['uun_uni_id'];
		}
		Request::$handMade = true;
		//si l'utilisateur a obtenu des diplomes ..
		if(!empty($check)){
			/* ..on verifie que des cases été cochés quand le visiteur a validé le formulaire de selection des diplomes dans la page edit
			sinon on transphorme son formulaire en tableau vide pour comparer avec les diplomes stocké en base de données*/
			$this->request->data['uun_uni_id'] = (!isset($this->request->data['uun_uni_id']) || empty($this->request->data['uun_uni_id']))? array() : $this->request->data['uun_uni_id']; 
			// .. on effectue la comparaison dabord dans un sens pour voir si il y a moins de case cohé dans le formulaire des diplomes que de diplome en BDD
			$diff = array_diff($check, $this->request->data['uun_uni_id']);
			//debug($diff);

			// $diff return les ids des diplomes qu'il y a en + dans la bdd
			// .. si il y a plus de diplomes attribué à l'user en BDD que dans son formulaire ..
			if(!empty($diff)){
				foreach ($diff as $k => $v) {
					//on supprime les diplomes en trop
					//debug($v);
					
					$this->Uunite->delete(array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_id' => $v, 'uun_uni_statut' => $bool));
				}
			}
			// on fait la comparaison à présent dans l'autre sens
			$diff = array_diff($this->request->data['uun_uni_id'], $check);
			// $diff renvoie cette fois les diplomes en plus dans le formulaire que ce qu'il possede dans la BDD
			//debug($diff);
			//die();
			if(!empty($diff)){
				//si il y en a on les insere donc en BDD
				foreach ($diff as $k => $v) {
					$this->Uunite->save(array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_id' => $v, 'uun_uni_statut' => $bool));
				}
			}
		}else{
		//si l'utilisateur n'a pas de diplome obtenus en base de données ..	
			if(!empty($this->request->data['uun_uni_id'])){
				// et si des diplomes sont coché dans le formulaire
				$data = $this->request->data['uun_uni_id'];
				foreach ($data as $k => $v) {
					//on les inseres
					$this->Uunite->save(array('uun_use_id' => Auth::$session['use_id'], 'uun_uni_id' => $v, 'uun_uni_statut' => $bool));	
				}
			}
		}
		
		Request::$handMade = false;
		//die();
		$this->session->setflash('Merci d \'avoir completez vos informations', 'success');
		$this->redirect($this->referer);

	}

	/**
	*@return met à jour le message de présentation de l'utilisateur
	**/
	public function addObservation(){
		$this->loadModel('User');
		
		$this->request->data = Sanitize::clean($this->request->data);
		/*debug($this->request->data);
		die();*/

		if($this->User->update($this->request->data, array('where' => array('use_id' => Auth::$session['use_id'])))) {
			$this->session->setflash('Modification bien effectué '.Auth::$session['use_login'], 'success');
			$this->redirect($this->referer);
		}else{
			$this->session->setflash('La modification a échoué');
			$this->redirect($this->referer);
		}
	}







}
