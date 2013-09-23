<div class="formulaire">
<?php 
if(isset($user)){
	debug(current($user));
	$user = current($user);
}

?>
<h2>Profil</h2>
<p>Renseigner un maximum d'informations peut vous aider à faciliter les échanges entre utilisateurs du site.</p>

<?php $this->img($user['ava_url'], array('alt' => 'avatar', 'class' => 'img-polaroid img-avatar')); ?><br>
<?php $this->Form->create('auth/uploadAvatar/'.$user['use_id'], array('type' => 'FILE', 'name' => 'ava_id', 'value' => $user['ava_id'], 'class' => '')); ?>
<?php $this->Form->input(array('type' => 'file', 'name' => 'avatar')); ?>
<?php $this->Form->end(array('type' => 'submit', 'value' => 'Uploadez !', 'class' => 'btn btn-info submit'));    ?>


<?php $checked = ($user['use_mail_show'] == 1)? true : false; ?>
<p>Vous êtes : <?php echo Config::accessShow(Auth::$session['use_statut']); ?></p>		
<?php $this->Form->create('auth/edit/'.$user['use_id'], array('type' => 'POST', 'name' => 'use_id', 'value' => $id = (isset($user['use_id']))? $user['use_id'] : '', 'class' => '')); ?>

	<?php $this->Form->input(array('name' => 'use_mail', 'type' => 'text', 'label' => 'Email : <em>(Utile en cas de perte de votre mot de passe)</em>  ', 'value' => $value = (isset($user['use_mail']))? $user['use_mail'] : '', 'message' => true)); ?>

	<?php $this->Form->input(array('name' => 'use_mail_show', 'type' => 'checkbox', 'label' => 'Afficher mon adresse mail dans ma carte de visite ?', 'value' => $user['use_mail_show'], 'checked' => $checked, 'class' => 'checkbox', 'message' => true)); ?>
	
	<?php $this->Form->input(array('name' => 'use_prenom', 'type' => 'text', 'label' => 'Prénom :', 'value' => $value = (isset($user['use_prenom']))? $user['use_prenom'] : '', 'message' => true)); ?>
	
	<?php $this->Form->input(array('name' => 'use_age', 'type' => 'text', 'label' => 'Age :', 'value' => $value = (isset($user['use_age']))? $user['use_age'] : '', 'message' => true)); ?>	

	<?php $this->Form->input(array('name' => 'use_profession', 'type' => 'text', 'label' => 'Profession', 'value' => $value = (isset($user['use_profession']))? $user['use_profession'] : '', 'message' => true)); ?>
	
	<?php $this->Form->input(array('name' => 'use_residence', 'type' => 'text', 'label' => 'Ville', 'value' => $value = (isset($user['use_residence']))? $user['use_residence'] : '', 'message' => true)); ?>

	<?php $this->Form->input(array('name' => 'use_etudes', 'type' => 'text', 'label' => 'Etudes', 'value' => $value = (isset($user['use_etudes']))? $user['use_etudes'] : '', 'message' => true)); ?>

	<h3>Changez le mot de passe :</h3>

	<?php $this->Form->input(array('name' => 'use_password1', 'type' => 'password', 'label' => 'Nouveau mot de passe', 'message' => true)); ?>

	<?php $this->Form->input(array('name' => 'use_password2', 'type' => 'password', 'label' => 'Confirmer',  'message' => true)); ?>

	<?php $this->Form->end(array('type' => 'submit', 'value' => 'Modifiez', 'class' => 'btn btn-info submit'));    ?>

</div>
