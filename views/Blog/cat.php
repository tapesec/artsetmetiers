<div class="blog_wall">
<?php debug($article); ?>
<?php foreach ($article as $k => $v): ?>
 	<article>
	<h2 class="text-success "><?php echo $v['art_title']; ?></h2>
	<div><small>Par <a href="<?php echo BASE_URL.'/parcours/voir/'.$v['use_id']; ?>"><strong><?php echo $v['use_login'] ?></strong></a>
	<?php echo dateHelper::fr($v['art_dateC'], array('delay' => true)); ?>
	<a href="#"><?php echo $v['cat_name']; ?></a>
	<span class="text-success">
	<?php $nbre_com = $this->layoutLoad('blog', 'countCom', $v['art_id']); ?>
	
	<?php echo $nbre_com;
	echo ($nbre_com <= 1)? ' commentaire' : ' commentaires'; ?>
	</span></small>
	</div>
	<p><?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 50); ?></p>
	<p><a class="btn btn-info"href="<?php echo BASE_URL.'/blog/voir/'.$v['art_id']; ?>">Lire la suite &#9658</a></p>
	</article>
<?php endforeach; ?> 
</div>
<?php echo $this->paginator('blog/cat/'.$article[0]['art_cat_id'], 'pagination'); ?>
<?php //debug(); ?>