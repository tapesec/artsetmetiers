<?php if(isset($articles)){
	debug($articles);
	debug($articles[1]);
	$listCat = $articles[1];
	$article = current(current($articles));
	debug($listCat);
	debug($article);
        	
} ?>


<?php $checked =''; ?>
<?php  if(isset($article['art_online'])): ?>
	<?php $checked = ($article['art_online'] == 1)? true : false; ?>
<?php endif; ?>

<div class="addArticle">
	
	<?php echo $this->Form->create('backoff/addArticle/'.$id= (isset($article['art_id']))? $article['art_id'] : false, array('type' => 'POST', 'name' => 'art_id', 'value' =>  $id)); ?>
		
	<?php echo $this->Form->input(array('name' => 'art_cat_id', 'type' => 'select', 'label' => 'Catégorie de l\'article', 'value' => $value = (isset($article['art_cat_id']))? $article['art_cat_id'] : '', 'list' => array($listCat))); ?>

	<?php echo $this->Form->input(array('name' => 'art_title', 'type' => 'text', 'label' => 'Titre de l\'article', 'value' => $value = (isset($article['art_title']))? $article['art_title'] : '')); ?>

	<?php echo $this->Form->input(array('name' => 'art_youtube',
					'type' => 'textarea',
					'label' => 'Code youtube',
					'value' => $value = (isset($article['art_youtube']))? Sanitize::show($article['art_youtube']): '')); ?>

<div id="emoticons" class="emoticons_area">


    						<a href="#" onclick="return false;" title=":p"><?php $this->img('design/emoticons/tongue.png');?></a>
							<a href="#" onclick="return false;" title=":("><?php $this->img('design/emoticons/unhappy.png');?></a>
							<a href="#" onclick="return false;" title=":D"><?php $this->img('design/emoticons/wink.png');?></a>
							<a href="#" onclick="return false;" title=">:("><?php $this->img('design/emoticons/hangry.png');?></a>
							<a href="#" onclick="return false;" title=":)"><?php $this->img('design/emoticons/smile.png');?></a>
						</div>
	<?php $this->Form->input(array('name' => 'art_content', 'type' => 'textarea','value' => $value = (isset($article['art_content']))? Sanitize::show($article['art_content']) : '' , 'class' => 'markitup', 'rows' => 15, 'message' => true)); ?>

	<?php $this->Form->input(array('name' => 'art_slot', 'type' => 'select', 'label' => 'Selectionnez l\'emplacement', 'value' => $value = (isset($article['art_slot']))? $article['art_slot'] : '', 'list' => array('blog' => 'Blog', 'accueil' => 'Accueil', 'tuto' => 'Tutoriel vidéo'), 'message' => true)); ?>

	<?php $this->Form->input(array('name' => 'art_online', 'type' => 'checkbox', 'label' => 'Mettre en ligne ?', 'value' => 1, 'checked' => $checked,  'class' => 'checkbox', 'message' => true)); ?>

	<?php $this->Form->end(array('type' => 'submit', 'value' => 'Valider', 'class' => 'btn btn-info submit')); ?>
</div>
<script type="text/javascript">

   		$(document).ready(function() { 
   						
   			mySettings = {
   				nameSpace: "bbcode",
   				markupSet: [
	   				{name:'Bold', key:'B', openWith:'[b]', closeWith:'[/b]'}, 
	     	 		{name:'Italic', key:'I', openWith:'[i]', closeWith:'[/i]'}, 
	      			{name:'Underline', key:'U', openWith:'[u]', closeWith:'[/u]'},
	      			{separator:'---------------' },
	      			{name:'Link', key:'L', openWith:'[url=[![Url]!]]', closeWith:'[/url]', placeHolder:'Your text to link here...'},
	      			{name:'Quotes', openWith:'[quote]', closeWith:'[/quote]'}, 
      				{name:'Code', openWith:'[code]', closeWith:'[/code]'},
				{name:'Picture', key:'P', replaceWith:'[img][![Url]!][/img]'} 
   				]
   			}

     		$(".markitup").markItUp(mySettings);
     		$('#emoticons a').click(function() {
        		emoticon = $(this).attr("title");
        		$.markItUp( { replaceWith:emoticon } );
    		});
    		SyntaxHighlighter.config.stripBrs = true;
    		SyntaxHighlighter.defaults['wrap-lines'] = true;
    		SyntaxHighlighter.all();
  		});

</script>
