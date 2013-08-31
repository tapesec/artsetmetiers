<?php //debug($list); 

//debug($users);
?>


<table class="table table-condensed table-striped table-bordered table-hover">
	<tr>
		<th>Login</th>
		<th>Inscris le</th>
		<th>Dernière visite</th>
		<th>Editer</th>	
		<th>Actif</th>
	</tr>
	<?php foreach ($users as $k => $v): current($v); ?>
	
	<tr>
		<td><small><?php echo $v['use_login']; ?></small></td>
		<td><small><?php echo $v['use_dateI']; ?></small></td>
		<td><small><?php echo $v['use_dateC']; ?></small></td>
		<td><small><a href="<?php echo BASE_URL.'/backoff/editUser/'.$v['use_id']; ?>"><?php echo Config::accessShow($v['use_statut']); ?></a></td>
		<td><small><?php echo $v['use_checked']; ?></small></td>
	</tr>
	<?php endforeach; ?> 
</table>