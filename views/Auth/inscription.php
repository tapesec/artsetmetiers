<div class="formulaire">
<h2>Inscription</h2>
<p>L'adresse mail demandé vous servira à recevoir un lien pour confirmer votre inscription. Surveillez votre boite de spam si vous ne le recevez pas rapidement.</p>	

	<?php $this->Form->create('auth/inscription', array('type' => 'POST', 'id' => 'inscription'));    ?>
	
		<?php $this->Form->input(array(
							'name' => 'use_login',
							'type' => 'text',
							'label' => 'Login :',
							'id' => 'login',
							'message' => array('class' => 'error'))); ?>
	
	
		<?php $this->Form->input(array(
							'name' => 'use_mail',
							'type' => 'text',
							'label' => 'Mail :',
							'id' => 'mail',
							'message' => array('class' => 'error'))); ?>

	
		<?php $this->Form->input(array(
							'name' => 'use_password1',
							'type' => 'password',
							'label' => 'Mot de passe :',
							'id' => 'pass1',
							'message' => array('class' => 'error'))); ?>
	
	
		<?php $this->Form->input(array(
							'name' => 'use_password2',
							'type' => 'password',
							'label' => 'Confirmer :',
							'id' => 'pass2',
							'message' => array('class' => 'error'))); ?>
	
	
		<?php $this->Form->end(array('type' => 'submit', 'value' => 'Je m\'inscris !', 'class' => 'btn btn-info submit'));  ?>
</div>
