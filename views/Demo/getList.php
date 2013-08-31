<?php
/*echo '<pre>';
print_r($liste);
echo '</pre>';*/

foreach($liste as $article): ?>
<div style="width:500px;margin:10px auto;">
	<h3><?php echo $article['title']; ?></h3>
	<p><?php echo $article['content']; ?></p>
	<p><?php echo $article['date_article']; ?></p>
</div>
<?php endforeach ?>