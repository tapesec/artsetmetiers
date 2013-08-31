<!DOCTYPE html>
<html>
<head>
	<title>Arts et métiers</title>
	<meta charset="UTF-8">
	<meta name="description" content="Voici le blog et l'espace carte de visite de Arts et Métiers IT retrouvez y plein d'articles sur les cours du CNAM en informatique, le php, le HTML / CSS, et sur les domaines des nouvelles technologies ainsi que une page de profil totalement configurable pour faire apparaitre les diplomes et unités d'enseignement que vous avez obtenus" />
	<?php echo $this->link('css', 'bootstrap.min'); ?>
	<?php echo $this->link('markitup/skins/simple', 'style', 'css'); ?>
	<?php echo $this->link('markitup/sets/bbcode', 'style', 'css'); ?>
	<?php echo $this->link('css', 'shCore'); ?>
	<?php echo $this->link('css', 'shThemeDefault'); ?>
	<?php echo $this->link('css', 'layout'); ?>
	<?php echo $this->link('javascript', 'modernizer'); ?>
	<?php echo $this->link('javascript', 'jquery'); ?>
	<?php echo $this->link('markitup', 'jquery.markitup', 'javascript'); ?>
	<?php echo $this->link('markitup/sets/bbcode', 'set', 'javascript'); ?>
	<?php echo $this->link('javascript', 'shCore'); ?>
	<?php echo $this->link('javascript', 'shBrushPhp'); ?>
	<?php echo $this->link('javascript', 'style'); ?>
	<?php echo $this->link('javascript', 'plugs'); ?>
	<?php echo $this->link('javascript', 'bootstrap.min'); ?>
	<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  		ga('create', 'UA-42223274-1', 'frienddcop.com');
		ga('send', 'pageview');
	</script>
</head>
<body>
<div id="notificationAjax" class="notification"><?php $this->img(Auth::$session['ava_url'], array('class' => 'img-polaroid, img-notif', 'alt' => Auth::$session['use_login'])); ?><span class="notif-text">test de notification</span></div>	
	<div class="row-fluid">
		<div class="span12">
				
			<?php $data['pages'] = $this->layoutLoad('Blog', 'page'); ?>
		    <div class="navbar">
			    <div class="navbar-inner">
		    		<a class="brand" href="#"><h1><?php echo ucfirst($this->request->controller); ?></h1></a>
		    		<ul class="nav">
		    			<li class="divider-vertical"></li>
		    			<li class=""><a href="<?php echo BASE_URL.$data['pages'][3]['pag_url']; ?>"><?php echo $data['pages'][3]['pag_name'] ?></a></li>
						<li class="divider-vertical"></li>
		    			<?php foreach ($data['pages'] as $k => $v): current($v); ?>

		    				<?php if($v['pag_name'] != 'Accueil') :?>
		    					<?php if($v['pag_name'] != 'Carte de visite' || isset(Auth::$session)): ?>
					    			<?php if($v['pag_name'] == ucfirst($this->request->controller)): ?>
					    				<li class="active"><a href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name']; ?></a></li>
					    				<li class="divider-vertical"></li>
					    			<?php else: ?>
					    				<li><a href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name']; ?></a></li>
										<li class="divider-vertical"></li>
									<?php endif; ?>
								<?php endif; ?>
							<?php endif; ?>

						<?php endforeach; ?>
						<?php if(!empty(Auth::$session) && Auth::$session['use_statut'] == 10): ?>
							<li><a href="<?php echo BASE_URL.'/backoff/index'; ?>">Administration du site</a></li>
						<?php endif; ?>	
		    		</ul>
		    	</div>
			</div>
			<?php echo $this->session->flash(); ?>
		</div>
	</div>
	
	<div class="container-fluid">
		
		<div class="row-fluid">	
			<div class="span8">
					<?php echo $content_for_layout; ?>
			</div>
			<div class="span3 offset1 main_aside">
				<div class="row-fluid">
					<div class="span12">
						<div class="main_aside_user">
							<?php //echo 'débugage de auth session'; debug(Auth::$session, true); ?>
							<?php if(!empty(Auth::$session['use_checked']) && Auth::$session['use_checked'] == true): ?>
								<?php echo $this->img(Auth::$session['ava_url'], array('class' => 'img-polaroid img-avatar auto', 'alt' => 'l\'avatar de '.Auth::$session['use_login'])); ?>
								<span class="text-success user_statut"><?php echo strtoupper(Auth::$session['use_login']); ?></span>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/auth/edit/'.Auth::$session['use_id']; ?>">Editer profil</a><a class="btn btn-info" href="<?php echo BASE_URL.'/auth/logout'; ?>">Deconnexion</a>
							<?php else: ?>
								<?php echo $this->img('design/img/avatar.png', array('class' => 'img-polaroid img-avatar auto', 'alt' => 'avatar par défaut')); ?>
								<span class="text-error user_statut">Déconnecté</span>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/auth/inscription'; ?>">Inscription</a><a class="btn btn-info" href="<?php echo BASE_URL.'/auth/connexion'; ?>">Connexion</a>
							<?php endif; ?>
						</div>
						<div class="main_aside_categories">
							<?php $data['categories'] = $this->layoutLoad('Blog', 'listCat'); ?>
							<?php //debug($data['categories']); ?>
							<ul class="nav nav-list nav-stacked">
								<li class="nav-header">Thèmes</li>
							    <?php foreach ($data['categories'] as $k => $v): current($v); ?>
							    	<?php if(isset($this->request->param[0]) && $this->request->param[0] == $v['cat_id']): ?>
										<li class="info active"><a href="<?php echo BASE_URL.'/blog/cat/'.$v['cat_id']; ?>"><?php echo $v['cat_name']; ?></a></li>	
									<?php else: ?>
										<li class="info"><a href="<?php echo BASE_URL.'/blog/cat/'.$v['cat_id']; ?>"><?php echo $v['cat_name']; ?></a></li>
									<?php endif; ?>
								<?php endforeach; ?>
							</ul>
						</div>
						<div class="main_aside_test">
							<h4>testez vous sur ..</h4>
							<?php $this->img('design/img/php.png', array('class' => 'matiere', 'alt' => 'logo de php')); ?>
							<?php $exo_id = $this->layoutLoad('blog', 'findTest'); ?>
							<?php //debug($exo_id); ?>
							<a class="btn btn btn-success" href="<?php echo BASE_URL.'/blog/voir/'.$exo_id['art_id']; ?>">Essayez !</a>
						</div>
						<div>
							<h4>Sur le forum</h4>
							<?php $last = $this->layoutLoad('forum', 'lastReplies'); ?>
							<?php //debug($last); ?>
							<?php foreach ($last as $k => $v): ?> 
								<p><small><?php echo DateHelper::fr($v['rep_dateC'], array('delay' => true)); ?></small><br>
								<a href="<?php echo BASE_URL.'/forum/posts/'.$v['rep_id_subjects']; ?>"><small><em><?php echo $this->Truncate->fragment(Sanitize::show($v['rep_content']), 10); ?></em></small></a></p>
							<?php endforeach; ?>
						</div>
					</div>
				</div>
			</div>
		</div>		
	</div>

	<footer class="footer">
			
				<div class="row-fluid container navbar">
					<div class="span2">
						<?php $this->img('design/img/twitter.png', array('class' => 'logo_twitter', 'alt' => 'logo_twitter')); ?>
					</div>
					<div class="span6 offset1">
						<h4><i class="icon-white icon-wrench"></i> Liens utiles</h4>
						<p>Liens du CNAM : <a title="Lien national" href="http://formation-paris.cnam.fr">CNAM</a>,
								   <a title="Centre de Paris" href="http://formation-paris.cnam.fr">CNAM PARIS</a>,
								   <a title="Lien vers le laboratoire CEDRIC du CNAM" href="http://cedric.cnam.fr/">Laboratoire CEDRIC</a>,
								   <a title="Département informatique du CNAM" href="http://deptmedia.cnam.fr/new/">Département informatique du CNAM</a>.
								   </p>

						<p>Bibliographie .. <a title="Le site du zéro" href="http://siteduzero.com">Le site du zéro</a>,
								   <a title="Centre de Paris" href="http://www.developpez.com">Développez.com</a>,
								   <a title="Lien national" href="http://www.commentcamarche.net/">Comment ça marche</a>.
								   </p>

						<p>.. spécifique web : <a title="Lien national" href="http://www.grafikart.fr/?">Grafikart</a>,
								   <a title="Centre de Paris" href="http://www.alsacreations.com">Alsacréation</a>,
								   <a title="Lien national" href="http://www.lafermeduweb.net">La ferme du web</a>.
								   </p>
						<div class="text-center hyper">		   
						<a class="btn btn-warning text-center" target="_blank" href="http://emploi-du-temps.cnam.fr/emploidutemps2">Consultez<br>L'HYPERPLANNING</a>		   
						</div>
					</div>
					<div class="span3">
						<div class="row-fluid">
							<div class="span12">
								<address>
									<small>
										<strong>CNAM Paris</strong><br>
										292 Rue Saint-Martin<br>
										75003 Paris<br>
										<abbr title="Numéro de téléphone">Tel : </abbr>01 40 27 20 00
									</small>
								</address>
							</div>
						</div>
						<div class="row-fluid">
							<div class="span 8">
								<address><small>
									<strong>Contact Webmaster</strong><br>
									<abbr title="Adresse mail">@ : </abbr>artsetmetiers@gmail.com
								</small></address>
							</div>
						
							<div class="span4">
								<?php $this->img('design/img/rss2.png', array('alt' => 'icone flux RSS')); ?>
							</div>
						</div>
						
					</div>


				</div>
				<div class="row-fluid">
					<div class="span12 text-center">Artsmetier.com - 2013. Site développé à l'occasion du projet de fin d'études NFA021</div>
				</div>
			
		</footer>
	<script type="text/javascript" >
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
      				{name:'Code', openWith:'[code]', closeWith:'[/code]'} 
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
</body>

</html>
