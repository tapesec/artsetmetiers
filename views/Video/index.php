<?php debug($article); ?>

<div class="video_wall">
<?php debug($article); ?>

<?php foreach ($article as $k => $v): ?>
		
	<div data-cat="<?php echo $v['cat_name']; ?>" itemscope itemtype="http://schema.org/Article" class="span3 video-tuile">
	<article>
	<img class="cover" src="<?php echo BASE_URL.$v['art_cov']; ?>">
	<h4 itemprop="name" class="text-success"><?php echo $v['art_title']; ?></h4>
	<p itemprop="articleBody" class="description">
	<?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 40); ?>
	</p>
	<div class="cover_hover">
		<p><?php $this->img('/design/img/button_play.png',array('class' => 'button_play')); ?></p>	
		<p class="category"><?php echo '#'.$v['cat_name']; ?></p>
		<p class="date"><?php echo DateHelper::fr($v['art_dateC']); ?></p>	
		<p class="level"><?php echo ucfirst($v['art_level']); ?></p>
	</div>
	</article>
	</div>
	
<?php endforeach; ?>


</div>
<script>
$(document).ready(function(){
	$('div[class*="cover_hover"]').css('opacity', 0);
	$('.video-tuile').hover(function(){
		$('.video-tuile').css('opacity', 0.3).css('border-bottom', '5px solid #49AFCD');
		$(this).css('opacity', 1).css('cursor', 'pointer');
		$(this).children('article').children('div[class="cover_hover"]').css('opacity', 1);
		$(this).children('article').children('p').css('color','rgba(0,0,0,0.25)');
		$(this).children('article').children('h4').css('color','rgba(0,0,0,0.25)');


	}, function(){
		$('.video-tuile').css('opacity', 1).css('border-bottom', 'none');
		$(this).children('article').children('div[class="cover_hover"]').css('opacity', 0);
		$(this).children('article').children('p').css('color','#333333');
		$(this).children('article').children('h4').css('color','#468847');

	});
});
</script>

