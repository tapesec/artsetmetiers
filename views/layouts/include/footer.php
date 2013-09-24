<div class="row-fluid">
	<div class="span12">
	<?php $menu = $this->layoutLoad('Blog', 'page'); ?>
	<?php debug($menu); ?>
	    <div class="navbar">
	    	<div class="navbar-inner">
		<a class="brand" href="<?php echo BASE_URL; ?>"></a>
		    	<ul class="nav">
		    		<li class="divider-vertical"></li>
				<li class="">
				<a href="<?php echo BASE_URL; ?>"><?php echo  ?></a>
				</li>
				<li class="divider-vertical"></li>
		    		<?php foreach ($var as $k => $v): ?>
	    				<?php if($v['pag_name'] != 'Accueil') :?>
	    					<?php if($v['pag_name'] != 'Carte de visite' || isset(Auth::$session)): ?>
				    			<?php if($v['pag_name'] == ucfirst($this->request->controller)): ?>
								<li class="active">
								<a href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name']; ?></a>
								</li>
					    			<li class="divider-vertical"></li>
					    		<?php else: ?>
								<li>
								<a href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name']; ?></a>
								</li>
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

