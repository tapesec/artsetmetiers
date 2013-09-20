<div class="blog_wall">
<?php debug($article); ?>

<?php foreach ($article as $k => $v): ?>
 	<div itemscope itemtype="http://schema.org/Article">
	<article>
	<h2 itemprop="name" class="text-success"><?php echo $v['art_title']; ?></h2>
	<div><small>Par <a href="<?php echo BASE_URL.'/parcours/voir/'.$v['use_id']; ?>"><strong><span itemprop="author" itemtype="http://schema.org/Person"><?php echo $v['use_login']; ?></span></strong></a>
	 <span itemprop="datePublished" datetime="<?php echo $v['art_dateC']; ?>" > <?php echo dateHelper::fr($v['art_dateC'], array('delay' => true)); ?></span>
	<a href="<?php echo BASE_URL.'/blog/cat/'.$v['cat_id']; ?>"><span itemprop="articleSection"> <?php echo $v['cat_name']; ?></span></a>
	<span class="text-success">
	<?php $nbre_com = $this->layoutLoad('blog', 'countCom', $v['art_id']); ?>
	
	<?php echo $nbre_com;
	echo ($nbre_com <= 1)? ' commentaire' : ' commentaires'; ?>
	</span></small>
	</div>
	<p itemprop="articleBody"><?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 50); ?></p>
	<p><a itemprop="url" class="btn btn-info" href="<?php echo BASE_URL.'/blog/voir/'.$v['art_id']; ?>">Lire la suite &#9658;</a></p>
	<div class="clearfix"></div>
	</article>
	</div>
<?php endforeach; ?> 
</div>
<?php echo $this->paginator('blog/index', 'pagination'); ?>
<script>
	$(document).ready(
		function(){
			$('#bannerInfo').text('Le Blog');	
		}	
	);	
</script>
