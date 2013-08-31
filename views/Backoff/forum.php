<?php debug($sections);
if(count($sections) == 2){
	$section = $sections[0];
	$edit = current($sections[1]);

}else{
	$section = $sections;
}
?>

<table class="table table-condensed table-striped table-bordered table-hover">
	<th>Nom de la section</th>
	<th>Action</th>
	<?php foreach ($section as $k => $v):  ?>
		<tr>
			<?php echo '<td><small>'.$v['sec_name'].'</small></td>'; ?>
			<?php echo '<td><small><a href="'.BASE_URL.'/backoff/forum/'.$v['sec_id'].'">Editer</a>'; ?>
			<?php echo '<a href="'.BASE_URL.'/backoff/delSection/'.$v['sec_id'].'">Supprimer</a></small></td>'; ?>
		</tr>
	<?php endforeach; ?>
</table>


<?php echo $this->Form->create('backoff/forum/'.$id= (isset($edit['sec_id']))? $edit['sec_id'] : false, array('type' => 'POST', 'name' => 'sec_id', 'value' =>  $id)); ?>

<?php echo $this->Form->input(array('name' => 'sec_name', 'type' => 'text', 'label' => 'Intitulé de la section', 'value' => $value = (isset($edit['sec_name']))? $edit['sec_name'] : '')); ?>

<?php $this->Form->input(array('name' => 'sec_online', 'type' => 'checkbox', 'label' => 'Mettre en ligne ?', 'value' => $value = (isset($edit['sec_online']))? $edit['sec_online'] : 1, 'class' => 'checkbox', 'message' => true)); ?>

<?php $this->Form->end(array('type' => 'submit', 'value' => 'Valider', 'class' => 'btn btn-info')); ?>