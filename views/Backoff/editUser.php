<?php debug($edit); ?>
<?php $edit = $edit[0]; ?>
<?php debug(Config::accessShow()); ?>


	<?php echo $this->Form->create('backoff/editUser/'.$id= (isset($edit['use_id']))? $edit['use_id'] : false, array('type' => 'POST', 'name' => 'use_id', 'value' =>  $id)); ?>
	
	<?php echo $this->Form->input(array('name' => 'use_statut', 'type' => 'select', 'label' => 'Statut de '.$edit['use_login'], 'value' => $value = (isset($edit['use_statut']))? $edit['use_statut'] : '', 'list' => Config::accessShow())); ?>
	
	<?php $this->Form->end(array('type' => 'submit', 'value' => 'changez', 'class' => 'btn btn-info submit')); ?>