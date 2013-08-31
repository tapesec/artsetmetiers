<?php //debug($section); ?>

    <ul class="breadcrumb">
    	<li class="active">Accueil <span class="divider">/</span></li>
    <!--<li><a href="#">Library</a> <span class="divider">/</span></li>
    <li class="active">Data</li>-->
    </ul>


	<table class="table table-striped table-bordered table-hover">
		<tr>
			<th>Forums</th>
			<th>Sujets</th>
			<th>Posts</th>
			<th>Derniers messages</th>
		</tr>
	<?php foreach ($section as $k => $v): current($v); ?>
		<tr>
			<td><a href="<?php echo BASE_URL.'/forum/section/'.$v['sec_id']; ?>"><?php echo Sanitize::show($v['sec_name']); ?></a></td>
			<td>
				<?php $sub_count = $this->layoutLoad('forum', 'subCount', $v['sec_id'] ); ?>
				<?php echo $sub_count; ?>
			</td>
			<td>
				<?php $rep_count = $this->layoutLoad('forum', 'repCount', $v['sec_id'] ); ?>
				<?php echo $rep_count[0]['rep_count']; ?>
			</td>
			<td>
				<?php $last = $this->layoutLoad('forum', 'lastSubject', $v['sec_id']); ?>
				<?php if(!empty($last[0]['rep_dateC'])): ?>
				<?php echo DateHelper::fr($last[0]['rep_dateC']). ' par <a class="text-success" href="'. BASE_URL.'/parcours/voir/'.$v['sec_id'].'">'.ucfirst($last[0]['use_login']).'</a>'; ?>
				<?php else: ?>
				<?php echo '-'; ?>
				<?php endif; ?>
			</td>
		</tr>
	<?php endforeach; ?>
</table>