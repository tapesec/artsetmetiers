<?php 

class AuthController extends Controller{

	public $helpers = array('Form', 'DateHelper', 'Truncate'); //charge les helpers passé dans le tableau
	

	/**
	*@return affiche un formulaire d'inscription en cas de requete GET
	*@return insert un nouveau usagé apres vérification courante des données saisies
	**/
	public function inscription(){
		$this->request->data = Sanitize::clean($this->request->data);
		if($this->request->is('POST')){
			$this->loadModel('User');
			$this->loadModel('Avatar');
			$check_user = $this->User->find(array(
										'where' => array(
											'use_login' => $this->request->data['use_login'])));

			$check_mail = $this->User->find(array(
										'where' => array(
											'use_mail' => $this->request->data['use_mail'])));

			if(!empty($check_user)){
				$this->session->setFlash('Ce pseudo est déjà pris !', 'error');
				$this->redirect($this->referer);
			}else if(!empty($check_mail)){
				$this->session->setFlash('Cette adresse mail est déjà pris !', 'error');
				$this->redirect($this->referer);
			}else{
				debug($check_user);
				$this->request->data['use_statut'] = 1;
				$this->request->data['use_checked'] = 0;
				$this->request->data['use_dateI'] = DateHelper::now();
				$this->request->data['use_dateC'] = DateHelper::now();
				$tokken = crypt($this->request->data['use_password1'], 'tapesec');
				$tokken = str_replace('.', '', $tokken);
				$this->request->data['use_password1'] = $tokken;
				$this->request->data['use_password2'] = $tokken;
				$link = 'http://www.cnam-it.fr/auth/checked/'.$tokken;
				$this->request->data['use_link'] = $tokken;
				
				if($this->request->data['use_password1'] == $this->request->data['use_password2']){
					if($this->User->save($this->request->data)){
						$use_id = $this->User->find(array('fields' => 'use_id',
												'where' => array('use_login' => $this->request->data['use_login'])));
						Request::$handMade = true;
						$this->Avatar->save(array('ava_url' => 'avatar/default.png', 'ava_id_user' => $use_id[0]['use_id']));

						Request::$handMade = false;
						if(mail($this->request->data['use_mail'], 'Cnam-it.fr - Confirmation de votre inscription', 'Bienvenue chez Cnam-it.fr !'.PHP_EOL.
							'Pour confirmer votre inscription cliquez ici :'.PHP_EOL.
							$link,
							'To: '.$this->request->data['use_mail']."\r\n".'From: webmaster@cnam-it.fr'."\r\n".'Reply-to: webmaster@cnam-it.fr'."\r\n".'X-Mailer:PHP/'.phpversion())){
							$this->session->setFlash('Rendez vous sur votre boite mail pour confirmer votre inscription. Pensez à vérifier vos spams', 'success');
							$this->redirect('blog/index');
						}else{
							$this->session->setFlash('Erreur d\'envoie du mail', 'error');
							$this->redirect('blog/index');
						}

						
					}else{
						die();
						$this->session->setFlash('Veuillez corriger vos erreurs', 'error');
						$this->redirect($this->referer);
					}
				}else{
					$this->session->setFlash('Erreur de mot de passe', 'error');
					$this->redirect($this->referer);
				}
					
			}
		}elseif($this->request->is('GET')){
			$this->layout = 'main';
			$this->render('inscription');
		}
		
	}

	/**
	*@param $tokken le jeton pour confirmer l'inscription d'un utilisateur
	**/
	public function checked($tokken){
		$this->loadModel('User');
		$check_user = $this->User->find(array('fields' => 'use_link', 'where' => array('use_link' => $tokken, 'use_checked' => false)));
		if($check_user){
			$tokken_checked = current(current($check_user));
			if($tokken == $tokken_checked){
				Request::$handMade = true;
				if($this->User->update(array('use_checked' => true), array('where' => array('use_link' => $tokken)))) {
					$this->session->setFlash('Votre compte est bien validé!', 'success');
					$this->redirect('blog/index');

				}else{
					die('une erreur de mise à jour du checked a eu lieu');
				}
				Request::$handMade = false;
			}else{
				$this->session->setFlash('Echec de confirmation de votre inscription', 'error');
				$this->redirect('/blog/index');
			}
		}else{
			$this->session->setFlash('Ce lien n\'est pas ou plus valide', 'error');
			$this->redirect('blog/index');
		}
	}

	/**
	*@return affiche un formulaire de connexion
	**/
	public function connexion(){
		if($this->request->is('GET')){
			$this->layout = 'main';
			$this->render('connexion');
		}elseif($this->request->is('POST')){
			$this->loadModel('User');
			$password = crypt($this->request->data['use_password1'], 'tapesec');
			$password = str_replace('.', '', $password);
			//echo $password;

			$check_user = $this->User->find(array('join' => array('type' => 'LEFT OUTER JOIN',
												  				  'table' => 'avatars',
												  				  'condition' => 'use_id = ava_id_user'),
													'where' => array(
														'use_login' => $this->request->data['use_login'],
														'use_checked' => true,
														'use_password1' => $password) ));
			debug($check_user);
			
				if($check_user){

					Request::$handMade = true;
					if(!$this->User->update(array('use_dateC' => DateHelper::now()), array('where' => array('use_login' => $this->request->data['use_login'])))) {
						$this->session->setFlash('Connexion impossible veuillez retenter ou contacter l\'administrateur');
						$this->redirect($this->referer());
					}
					Request::$handMade = false;
					Auth::load($check_user);
					$this->session->setFlash('BONJOUR '.$this->request->data['use_login'].' !', 'success');
					$this->redirect('blog/index');
				}else{
					$this->session->setFlash('login ou mot de passe incorrect !', 'error');
					$this->redirect($this->referer);
				}
				
		}
	}

	/**
	*@return detruit la super variable de session auth et redirige en page d'accueil
	**/
	public function logout(){
		Auth::destroy();
		$this->session->setFlash('AU REVOIR !', 'success');
		
		$this->redirect('blog/index');
	}


	/**
	*@param $id l'identifiant du profil à éditer
	*return met à jour la base de données si des données sont modifié dans le formulaire
	**/
	public function edit(){
		$this->request->data = Sanitize::clean($this->request->data);
		$this->loadModel('User');
	
		if($this->request->is('GET')){
			
			$user_data = $this->User->find(array('fields' => 'use_id, use_login, use_mail, use_mail_show, use_prenom, use_age, use_profession,
															 use_residence, use_etudes, use_password1, use_password2,
															  use_dateI, use_dateC, use_statut, ava_id, ava_url, ava_id_user',
													'join' => array('type' => 'LEFT OUTER JOIN',
																	'table' => 'avatars',
																	'condition' => 'use_id = ava_id_user'),
													'where' => array(
													'use_id' => Auth::$session['use_id'])));
			if(!empty($user_data)){
				$this->set('user', $user_data);
			}
			$this->layout = 'main';
			$this->render('edit');	
		}elseif($this->request->is('PUT')){
			//die('ca fonctionne !');
			if($this->request->data['use_password1'] == $this->request->data['use_password2']){
				if(empty($this->request->data['use_password1'])) {
					unset($this->request->data['use_password1']);
					unset($this->request->data['use_password2']);
				}else{
					$tokken = crypt($this->request->data['use_password1'], 'tapesec');
					$tokken = str_replace('.', '', $tokken);
					$this->request->data['use_password1'] = $tokken;
					$this->request->data['use_password2'] = $tokken;
				}
				if(empty($this->request->data['use_mail_show'])){
					$this->request->data['use_mail_show'] = 0;
				}
				if($this->User->update($this->request->data, array('where' => array('use_id' => Auth::$session['use_id'])))){
					$this->session->setFlash('Informations mises à jour merci !', 'success');
					$this->redirect($this->referer);
				}else{
					$this->session->setFlash('Une erreur est survenu veuillez réessayer ou contacter l\'administrateur');
					$this->redirect($this->referer);
				}
				//die();
			}			

		}					
	}

	/**
	*@param $id l'identifiant de l'utilisateur 
	*@return upload un nouvel avatar à l'utilisateur
	**/
	public function uploadAvatar($id){
		$this->layout='';
		$this->loadModel('Avatar');
		echo 'request action';
		debug($this->request->data);
		echo 'request file';
		debug($this->request->file);
		echo 'session :';
		debug($_SESSION);
		$avatar = (!empty($this->request->file['avatar']))? $this->request->file['avatar'] : '';
		
		if(preg_match('/(.jpg)|(.png)|(.gif)$/', $avatar['name'])
		  && $avatar['size'] <= $this->request->data['max_size']
		  && !$avatar['error']){
			$ext = explode('.', $avatar['name']);
		  	$file = 'avatar'.DS.Auth::$session['use_login'].'.'.end($ext);
			$dest = WEBROOT.DS.'img'.DS;
			//echo $dest.$file;	
			if(move_uploaded_file($avatar['tmp_name'], $dest.$file)){
				$this->request->data['ava_url'] = preg_replace('#\\\#', '/', $file);
				debug($this->request->data);
				
				if($this->Avatar->update($this->request->data, array('where' => array('ava_id_user' => $id)))){
					debug($this->request->data['ava_url']);
					
					Auth::load($this->request->data);
					$this->session->setFlash('Avatar bien mis à jour !', 'success');
					$this->redirect($this->referer);
				}else{
					$this->session->setFlash('La mise à jour de votre avatar a échoué');
					$this->redirect($this->referer);
				}
			}else{
				$this->session->setFlash('Probleme lors de l\'enregistrement de votre image veuillez réessayer ou contacter l\'administrateur du site');
				$this->redirect($this->referer());
			}
		}else{
			$this->session->setFlash('format d\'image incorrect !', 'error');
			$this->redirect($this->referer);
		}
		die();
	}

	/**
	*@param $mail l'adresse mail du compte qui a perdu son mot de passe
	*@return renvoie un nouveau mot de passe sur la boite mail de l'utilisateur apres lavoir effectué la mise à jour dans la base de données
	**/
	public function lostPassword(){
		$this->loadModel('User');
		$mail = $this->request->data['use_mail'];
		$check = $this->User->find(array('fields' => 'use_mail, use_login, use_link',
										 'where' => array('use_mail' => $mail, 'use_checked' => true)));

		if($check){
			$link = 'http://www.frienddcop.com/auth/changePassword/'.$check[0]['use_link'];
			if(mail($mail, 'Arts et Métiers - Envoie de votre nouveau mot de passe', 
				'Si vous avez bien demandé un nouveau mot de passe car vous avez oublié le votre'.PHP_EOL.
				'cliquez sur ce lien changera votre mot de passe et vous renverra le nouveau dans votre boite mail.'.PHP_EOL.$link.PHP_EOL,
				'From: webmaster@cnam-it.fr')){
				$this->session->setFlash('Rendez vous dans votre boite mail pour confirmer le changement de votre mot de passe', 'success');
				$this->redirect('auth/connexion');
			}else{
				$this->session->setFlash('Erreur d\'envoie du mail', 'error');
				$this->redirect('blog/index');
			}
		}else{
			$this->session->setFlash('Cette adresse mail n\'est associé à aucun compte !', 'error');
			$this->redirect($this->referer);
		}
	}

	public function changePassword($link){
		$this->loadModel('User');
		$random = rand(1,10000);
		$password = crypt($random, 'tapesec');
		$password = str_replace('.', '', $password);
		$check_user = $this->User->find(array('fields' => 'use_id, use_mail', 'where' => array('use_link' => $link)));
		$mail = $check_user[0]['use_mail'];
		Request::$handMade = true;
		if($this->User->update(array('use_password1' => $password, 'use_password2' => $password), array('where' => array('use_id' => $check_user[0]['use_id'])))) {
			if(mail($mail, 'Arts et Métiers - Envoie de votre nouveau mot de passe', 'Voici votre nouveau mot de passe '.$random.PHP_EOL.
				'Rendez vous vite dans votre profil pour le modifier par un nouveau plus facile à retenir'.PHP_EOL.
				$random,
				'From: webmaster@cnam-it.fr')){
				$this->session->setFlash('Un nouveau mot de passe a bien été envoyé dans votre boite mail', 'success');
				$this->redirect('auth/connexion');
			}else{
				$this->session->setFlash('Erreur d\'envoie du mail', 'error');
				$this->redirect('blog/index');
			}
		}
		Request::$handMade = false;	

	}

}
