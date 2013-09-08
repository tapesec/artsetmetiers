<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Vous êtes sur la page d'accueil du site CNAM-IT.fr, le site communautaire des étudiants du CNAM en Technologies de l'Information et de la Communication." />
	<title>Bienvenue chez CNAM-IT.fr</title>
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
	<?php echo $this->link('javascript', 'bootstrap.min'); ?>
	<?php //echo $this->link('javascript', 'tinymce/tinymce.min'); ?>
	<script>
  		(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
 		(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  		m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  		})(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  		ga('create', 'UA-42223274-1', 'cnam-it.fr');
		ga('send', 'pageview');
	</script>
</head>
<body>
	<div id="wrap">
	<div class="row-fluid">
		<div class="span12">
				
			<?php $data['pages'] = $this->layoutLoad('Blog', 'page'); ?>
		    <div class="navbar">
			    <div class="navbar-inner">
		    		<a class="brand" href="#"><h1><?php echo ucfirst($this->request->controller); ?></h1></a>
		    		<ul class="nav">
		    			<li class="divider-vertical"></li>
		    			<li class="active"><a href="<?php echo BASE_URL.$data['pages'][3]['pag_url']; ?>"><?php echo $data['pages'][3]['pag_name'] ?></a></li>
		    			<li class="divider-vertical"></li>
		    			<?php foreach ($data['pages'] as $k => $v): current($v); ?>
		    				<?php if($v['pag_name'] != 'Accueil') :?>
		    					<?php if($v['pag_name'] != 'Carte de visite' || isset(Auth::$session)): ?>
				    				<?php if($v['pag_name'] == ucfirst($this->request->controller)): ?>
				    					<li class="active"><a  href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name']; ?></a></li>
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
	<div class="row-fluid banner_area">
		<div class="span12 banner">
			<?php $this->img('design/img/new_banner.jpg', array('alt' => 'Bannière du site CNAM-IT.FR')); ?>
		</div>	
	</div>

	<div class="container-fluid">
		
				<div class="row-fluid">
				<div class="span12">
				    <ul class="thumbnails">
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.'/blog/index'; ?>" class="thumbnail">
	    					<?php $this->img('design/img/loupe.png', array('alt' => 'image représentant une loupe pour acceder au blog')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Un Blog</h2>
								<p>Retrouvez y l'actualité du CNAM mais aussi des articles relatif à la programmation informatique et plus générlament aux nouvelles technologies</p>
								<p>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/blog/index'; ?>">Lisez !</a>
								</p>
							</div>
    					</li>
    					<?php $url = (isset(Auth::$session))?  '/parcours/voir' : '/auth/connexion' ; ?>
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.$url; ?>" class="thumbnail">
	    					<?php $this->img('design/img/cv.png', array('alt' => 'image représentant une carte de visite pour acceder à la partie carte de visite')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Votre carte de visite</h2>
								<p>Vous pouvez parametrez tout un tas d'information relatif à votre parcours au CNAM, les matieres suivis les diplômes obtenus, votre milieu professionnel et plein d'autres choses pour vous reconnaitre.</p>
								<p>
								
								<a class="btn btn-info" href="<?php echo BASE_URL.$url; ?>">Montrez !</a>
								</p>
							</div>
    					</li>
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.'/forum/index'; ?>" class="thumbnail">
	    					<?php $this->img('design/img/foruma.png', array('alt' => 'image représentant l\'acces au forum du site')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Le Forum</h2>
								<p>Formez une vrai communauté des étudiants du CNAM en département informatique, posez vos questions ou répondez à vos camarades. Echangez vos réalisations, retrouvez vous pour progressez plus facilement ensemble.</p>
								<p>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/forum/index'; ?>">Participez !</a>
								</p>
							</div>
    					</li>
    					<?php $exo_id = $this->layoutLoad('blog', 'findTest'); ?>
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.'/blog/voir/'.$exo_id['art_id']; ?>" class="thumbnail">
	    					<?php $this->img('design/img/test.png', array('alt' => 'image représentant l\'acces à la partie testez vous')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Testez vous</h2>
								<p>Régulièrement des exercices de programmation serons proposés, repondez-y en donnant la solution la plus élégante possible. <blockquote>"Il y a le bon codeur et le mauvais codeur".</blockquote></p>
								<p>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/blog/voir/'.$exo_id['art_id']; ?>">Essayez !</a>
								</p>
							</div>
    					</li>
    				</ul>
				</div>
			</div>
		</div>
		<footer class="footer">
			
				<div class="row-fluid container navbar">
					<div class="span2">
						<?php $this->img('design/img/twitter.png', array('class' => 'logo_twitter', 'alt' => 'logo de twitter')); ?>
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

						<p>.. spécifique web : <a title="Lien national" href="http://www.grafikart.fr/‎">Grafikart</a>,
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
								<?php $this->img('design/img/rss2.png', array('alt' => 'icône du flux rss')); ?>
							</div>
						</div>
						
					</div>


				</div>
				<div class="row-fluid">
					<div class="span12 text-center">Artsmetier.com - 2013. Site développé à l'occasion du projet de fin d'études NFA021</div>
				</div>
			
		</footer>
	</div>
</body>

</html>
