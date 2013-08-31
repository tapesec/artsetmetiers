<?php debug($categories);?>
<?php if(isset($categories['edit'])){
	$edit = $categories['edit'][0];
}?>
<?php if(isset($categories['list'])){
	$categories = $categories['list'];
} ?>

<table class="table table-condensed table-striped table-bordered table-hover">
	<th>Nom de la section</th>
	<th>Action</th>
	<?php foreach ($categories as $k => $v): current($v); ?>
		<tr>
			<?php echo '<td><small>'.$v['cat_name'].'</small></td>'; ?>
			<?php echo '<td><small><a href="'.BASE_URL.'/backoff/listCat/'.$v['cat_id'].'">Editer</a>'; ?>
			<?php echo '<a href="'.BASE_URL.'/backoff/delCat/'.$v['cat_id'].'">Supprimer</a></small></td>'; ?>
		</tr>
	<?php endforeach; ?>
</table>


<?php echo $this->Form->create('backoff/listCat/'.$id= (isset($edit['cat_id']))? $edit['cat_id'] : false, array('type' => 'POST', 'name' => 'cat_id', 'value' =>  $id)); ?>

<?php echo $this->Form->input(array('name' => 'cat_name', 'type' => 'text', 'label' => 'Catégorie', 'value' => $value = (isset($edit['cat_name']))? $edit['cat_name'] : '')); ?>

<?php $this->Form->end(array('type' => 'submit', 'value' => 'Valider', 'class' => 'btn btn-info submit')); ?>