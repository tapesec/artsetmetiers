<?php debug($article); ?>

<div class="video_wall">
<?php debug($article); ?>

<?php foreach ($article as $k => $v): ?>
		
	<div data-cat="<?php echo $v['cat_name']; ?>" itemscope itemtype="http://schema.org/Article" class="span3">
	<article>
	<img class="cover" src="<?php echo BASE_URL.$v['art_cov']; ?>">
	<h4 itemprop="name" class="text-success"><?php echo $v['art_title']; ?></h4>
	<p itemprop="articleBody">
	<?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 40); ?>
	</p>
	<div class="cover_hover"><img class="button_play" src="<?php //echo BASE_URL.'/design/img/button_play.png'; ?>">
		<?php $this->img('/design/img/'); ?>	
		<p class="category"><?php echo $v['cat_name']; ?></p>
		<p class="date"><?php echo DateHelper::fr($v['art_dateC']); ?></p>	
		<p class="level"><?php echo ucfirst($v['art_level']); ?></p>
	</div>
	</article>
	</div>
	
<?php endforeach; ?>


</div>

