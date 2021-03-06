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
	<!-- zone navigation principale -->
	<?php require ROOT.DS.'views'.DS.'layouts'.DS.'include'.DS.'mainNav.php'; ?>
	<!-- end -->

	<div class="row-fluid banner_area">
		<div class="span12 banner">
			<?php $this->img('design/img/bannertest.jpg', array('alt' => 'Bannière du site CNAM-IT.FR')); ?>
		</div>	
	</div>

	<div class="container-fluid">
		
				<div class="row-fluid">
				<div class="span12">
				    <ul class="thumbnails">
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.'/blog/index'; ?>" class="thumbnail">
	    					<?php $this->img('design/img/loupe.png', array('alt' => 'image loupe blog')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Un Blog</h2>
								<p>Retrouvez y l'actualité du CNAM mais aussi des articles relatifs à la programmation informatique et plus généralement aux nouvelles technologies</p>
								<p>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/blog/index'; ?>">Lisez !</a>
								</p>
							</div>
    					</li>
    					<?php $url = (isset(Auth::$session))?  '/parcours/voir' : '/auth/connexion' ; ?>
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.$url; ?>" class="thumbnail">
	    					<?php $this->img('design/img/cv.png', array('alt' => 'image carte de visite')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Votre carte de visite</h2>
								<p>Vous pouvez parametrer tout un tas d'informations relatif à votre parcours au CNAM, les matières suivies les diplômes obtenus, votre secteur d'activité et plein d'autres choses pour vous reconnaitre.</p>
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
								<p>Formez une vrai communauté des étudiants du CNAM en nouvelles technologies, posez vos questions ou répondez à vos camarades. Echangez vos réalisations, retrouvez vous pour progresser plus facilement ensemble.</p>
								<p>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/forum/index'; ?>">Participez !</a>
								</p>
							</div>
    					</li>
    					<?php $exo_id = $this->layoutLoad('blog', 'findTest'); ?>
    					<li class="span3">
	    					<a href="<?php echo BASE_URL.'/video/index'; ?>" class="thumbnail">
	    					<?php $this->img('design/img/tutovideo.jpg', array('alt' => 'image représentant l\'acces à la partie testez vous')); ?>
	    				</a>
					    	<div class="caption">
								<h2>Tutoriels vidéo</h2>
								<p>Retrouvez dans cette rubrique toutes les vidéos à thème sur la programmation ou l'administration système, des compléments d'explication de cours etc..
								<p>
								<a class="btn btn-info" href="<?php echo BASE_URL.'/video/index'; ?>">Regardez !</a>
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
