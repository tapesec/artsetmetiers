<?php //debug($article); ?>

<div class="add_message_area">
	<a class="btn btn-info" href="<?php echo BASE_URL.'/backoff/addArticle'; ?>">Ajouter un article</a>
</div>
<table class="table table-condensed table-striped table-bordered table-hover">
	<tr>
		<th>Id</th>
		<th>Titre</th>
		<th>Crée le</th>
		<th>Modifié le</th>
		<th>Action</th>
		<th>Statut</th>
	</tr>
	<?php foreach($article as $k => $v): current($v); ?>
	<tr>
		<td><small><?php echo $v['art_id']; ?></small></td>
		<td><small><?php echo $v['art_title']; ?></small></td>
		<td><small><?php echo DateHelper::fr($v['art_dateC']); ?></td>
		<td><small><?php echo (!empty($v['art_dateM']))? DateHelper::fr($v['art_dateM']) : '-'; ?></small></td>
		<td><small><?php echo '<a href="'.BASE_URL.'/backoff/addArticle/'.$v['art_id'].'">Editer</a>'; ?>
		<?php echo '<a href="'.BASE_URL.'/backoff/delArticle/'.$v['art_id'].'">Supprimer</a>'; ?></small></td>
		<td><small><?php echo $v['art_online']; ?></small></td>	
	</tr>
	<?php endforeach; ?>

</table>