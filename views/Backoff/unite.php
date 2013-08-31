<?php debug($unites);?>
<?php $value2 = (isset($unites['dip_unite'][0]['dun_dip_id']))? $unites['dip_unite'][0]['dun_dip_id'] : ''; ?>


<?php
$value2 = array();
if(isset($unites['dip_unite'])){
	foreach ($unites['dip_unite'] as $k => $v) {
		$value2[] = $v['dun_dip_id'];
	}
}
?>



<?php $listD = $unites['listD']; ?>

<?php if(isset($unites['edit'])){
	$edit = $unites['edit'][0];
}?>
<?php if(isset($unites['list'])){
	$unites = $unites['list'];
} ?>
<?php if(isset($unites['listU'])){
	$unites = $unites['listU'];
}?>


<table class="table table-condensed table-striped table-bordered table-hover">
	<th>Code</th>
	<th>Nom de l'UV</th>
	<th>Action</th>
	<?php foreach ($unites as $k => $v): ?>
		<tr>
			<?php echo '<td><small>'.$v['uni_code'].'</small></td>'; ?>
			<?php echo '<td><small>'.$v['uni_name'].'</small></td>'; ?>
			<?php echo '<td><small><a href="'.BASE_URL.'/backoff/unite/'.$v['uni_id'].'">Editer</a>'; ?>
			<?php echo '<a href="'.BASE_URL.'/backoff/delUnite/'.$v['uni_id'].'">Supprimer</a></small></td>'; ?>
		</tr>
	<?php endforeach; ?>
</table>


<div class="row-fluid">
<div class="span4">


<?php echo $this->Form->create('backoff/unite/'.$id= (isset($edit['uni_id']))? $edit['uni_id'] : false, array('type' => 'POST', 'name' => 'uni_id', 'value' =>  $id)); ?>

<?php echo $this->Form->input(array('name' => 'uni_code', 'type' => 'text', 'label' => 'Code', 'value' => $value = (isset($edit['uni_code']))? $edit['uni_code'] : '')); ?>
<?php echo $this->Form->input(array('name' => 'uni_name', 'type' => 'text', 'label' => 'Unité d\'enseignement', 'value' => $value = (isset($edit['uni_name']))? $edit['uni_name'] : '')); ?>
<?php echo $this->Form->input(array('name' => 'dun_dip_id[]', 'type' => 'select', 'label' => 'Appartient à ..', 'value' => $value2 , 'list' => $listD, 'multiple' => true, 'class' => 'large')); ?>
<?php $this->Form->end(array('type' => 'submit', 'value' => 'Valider', 'class' => 'btn btn-info submit')); ?>

<?php if(isset($edit['uni_name'])): ?>

	<?php echo $this->Form->create('backoff/UEavatar/'.$id= (isset($edit['uni_id']))? $edit['uni_id'] : false, array('type' => 'FILE', 'name' => 'uni_id', 'value' => $id)); ?>
	<?php echo $this->Form->input(array('type' => 'file', 'label' => 'Icone de l\'unité d\'enseignement :' ,'name' => 'uniImage')); ?>
	<?php echo $this->Form->input(array('type' => 'submit', 'value' => 'uploadez', 'class' => 'btn btn-info submit')); ?>
</div>

	<div class="span4">
		<?php $this->img($edit['uni_img_url'], array('alt' => $edit['uni_name'], 'title' => $edit['uni_name'], 'class' => 'img-polaroid')); ?>
	</div>

<?php else: ?>
	</div>
<?php endif; ?>
	</div>