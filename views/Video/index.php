<!-- bouton triage par catégorie -->
<ul class="nav nav-pills">
	<li class="dropdown">
		<a class="dropdown-toggle" data-toggle="dropdown" href="#">
		Trier
		<b class="caret"></b>
		</a>
		<ul class="dropdown-menu" id="listCat">
		<?php foreach($article['listCat'] as $k => $v): ?>
		<li id="<?php echo $v['cat_id']; ?>"><a href="#" onclick="return false";><?php echo $v['cat_name']; ?></a></li>
		<?php endforeach; ?>
		</ul>
	</li>
</ul>
<!-- end -->
<div class="video_wall" id="zone-tuile">
<?php debug($article); ?>
<div class="row-fluid" >
<?php $i=0;
foreach ($article['video'] as $k => $v): ?>
	<?php if($i == 4): ?>
	</div>
	<div class="row-fluid">	
	<?php $i =0; endif; ?>
	<div data-cat="<?php echo $v['cat_name']; ?>" itemscope itemtype="http://schema.org/Article" class="span3 video-tuile">
	<article>
	<img class="cover" src="<?php echo BASE_URL.$v['art_cov']; ?>" alt="image d\'illustration">
	<h4 itemprop="name" class="text-success"><?php echo $v['art_title']; ?></h4>
	<p itemprop="articleBody" class="description">
	<?php echo $this->Truncate->fragment(Sanitize::show($this->Markitup->bbcodeParse($v['art_content'])), 15); ?>
	</p><a href="<?php echo BASE_URL.'/video/voir/'.$v['art_id']; ?>">
	<div class="cover_hover">
		<p><?php $this->img('/design/img/button_play.png',array('class' => 'button_play')); ?></p>	
		<p class="category"><?php echo '#'.$v['cat_name']; ?></p>
		<p class="date"><?php echo DateHelper::fr($v['art_dateC']); ?></p>	
		<p class="level"><?php echo ucfirst($v['art_level']); ?></p>
	</div></a>
	</article>
	</div>
	<?php $i++; ?>
<?php endforeach; ?>
</div>
</div>

<script>
$(document).ready(function(){
	$('div[class*="cover_hover"]').css('opacity', 0);
	$('div#zone-tuile').on('mouseenter', '.video-tuile', function(){
		$('.video-tuile').css('opacity', 0.3);
		$(this).css('border-bottom', '5px solid #49AFCD').css('opacity', 1).css('cursor', 'pointer');
		$(this).children('article').children('a').children('div[class="cover_hover"]').css('opacity', 1);
		$(this).children('article').children('p, h4').css('color','rgba(0,0,0,0.25)');
		
	}).on('mouseleave', '.video-tuile', function(){
		$('.video-tuile').css('opacity', 1).css('border-bottom', '5px solid lightgrey');
		$(this).children('article').children('a').children('div[class="cover_hover"]').css('opacity', 0);
		$(this).children('article').children('p').css('color','#333333');
		$(this).children('article').children('h4').css('color','#468847');
	});
	$('#listCat li').click(function(){
			var cat_id = $(this).attr('id');
			$.ajax({
				type : "GET",
				url :  "<?php echo BASE_URL.'/video/getCat/'?>"+cat_id,
				success : function(data) {
					if(data !="") {
						$('div#zone-tuile div.row-fluid').remove();		
						$(data).appendTo('div#zone-tuile');
						$('div[class*="cover_hover"]').css('opacity', 0);

					}else{
						alert('lol');
					}	
				},
				error : function(data) {

				}	
			});
	});
});
</script>

