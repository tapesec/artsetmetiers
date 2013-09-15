<?php debug($article); ?>

<div class="blog_wall">
<?php debug($article); ?>

<?php foreach ($article as $k => $v): ?>
	
	<div itemscope itemtype="http://schema.org/Article" class="span6">
	<article>
	<h2 itemprop="name" class="text-success"><?php echo $v['art_title']; ?></h2>
	<div><small>Par <a href="<?php echo BASE_URL.'/parcours/voir/'.$v['use_id']; ?>"><strong><span itemprop="author" itemtype="http://schema.org/Person"><?php echo $v['use_login']; ?></span></strong></a>
	 <span itemprop="datePublished" datetime="<?php echo $v['art_dateC']; ?>" > <?php echo dateHelper::fr($v['art_dateC'], array('delay' => true)); ?></span></small>
	</div>
	<p itemprop="articleBody"><?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 40); ?></p>
	</article>
	<div class="clearfix"></div>

	</div>
	
<?php endforeach; ?> 
</div>

