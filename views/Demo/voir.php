<pre>
<?php $article = current($article); ?>
</pre>
<div style="width:500px; margin:auto;">
	<h2 style="color:blue;"><?php echo $article['title']; ?></h2>
	<p><?php echo $article['content']; ?></p>
	<p><?php echo $article['date_article']; ?></p>
</div>