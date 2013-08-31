<div class="formulaire">
<h2>Connexion</h2>
<p>Seul les visiteurs inscris et connectés peuvent écrire un message ou un commentaire sur le site.</p>	
<?php //debug(Auth::$auth['use_login']); ?>

<?php //$auth = ($auth); ?>
<?php //debug(Auth::$session['use_login']); ?>
<?php $this->Form->create('auth/connexion', array(
							'type'=>'POST',
							'class' => '',
							'id' => 'connexion'));    ?>
	
<?php $this->Form->input(array(
							'name' => 'use_login',
							'type' => 'text',
							'label' => 'Login :',
							'message' => array('class' => 'text-error'),
							'id' => 'login')); ?>
	
<?php $this->Form->input(array(
							'name' => 'use_password1',
							'type' => 'password',
							'label' => 'Mot de passe :',
							'message' => array('class' => 'text-error'),
							'id' => 'password')); ?>
	
<?php $this->Form->end(array('type' => 'submit',
							 'value' => 'connexion',
							 'class' => 'btn btn-info submit'));    ?>



<p>J'ai perdu mon mot de passe ..</p>	
<?php //debug(Auth::$auth['use_login']); ?>

<?php //$auth = ($auth); ?>
<?php //debug(Auth::$session['use_login']); ?>
<?php $this->Form->create('auth/lostPassword', array(
							'type'=>'POST',
							'class' => '',
							'id' => 'lost'));    ?>
	
<?php $this->Form->input(array(
							'name' => 'use_mail',
							'type' => 'text',
							'label' => 'Adresse mail du compte :',
							'message' => array('class' => 'text-error'),
							'id' => 'mail')); ?>
	
	
<?php $this->Form->end(array('type' => 'submit',
							 'value' => 'Envoyez moi un nouveau mot de passe !',
							 'class' => 'btn btn-warning submit'));    ?>	

</div>