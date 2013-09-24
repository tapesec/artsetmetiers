<!doctype html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="description" content="Le forum communautaire de CNAM-IT.fr,
	 Discussions générales, La Scolarité, Les diplômes et certificats BAC + 2, Les diplômes et certificats BAC + 3/4,
	 Les masters et diplômes d'ingénieurs" />
	<title>CNAM-IT.fr</title>
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
			<?php $this->img('design/img/bannertestS2.jpg', array('alt' => 'Bannière du site CNAM-IT.FR')); ?>
			<p class="banner-info" id="bannerInfo"></p>

		</div>	
	</div>
	<div class="container-fluid">
		
		<div class="row-fluid">

			<div class="span12">
				<?php echo $content_for_layout; ?>
			</div>
		</div>		
	</div>
</div>
	<footer class="footer">
			<small>
				<div class="row-fluid container navbar">
					<div class="span2">
						<?php $this->img('design/img/twitter.png', array('class' => 'logo_twitter')); ?>
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
								<?php $this->img('design/img/rss2.png'); ?>
							</div>
						</div>
						
					</div>


				</div>
				<div class="row-fluid">
					<div class="span12 text-center">Artsmetier.com - 2013. Site développé à l'occasion du projet de fin d'études NFA021</div>
				</div>
			</small>
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
