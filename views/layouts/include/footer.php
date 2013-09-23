<div class="row-fluid">
	<div class="span12">
	<?php $data['pages'] = $this->layoutLoad('Blog', 'page'); ?>
	    <div class="navbar">
	    	<div class="navbar-inner">
			<a class="brand" href="#"><h1><?php echo ucfirst($this->request->controller); ?></h1></a>
		    	<ul class="nav">
		    		<li class="divider-vertical"></li>
				<li class="">
				<a href="<?php echo BASE_URL.$data['pages'][3]['pag_url']; ?>"><?php echo $data['pages'][3]['pag_name'] ?></a>
				</li>
				<li class="divider-vertical"></li>
		    		<?php foreach ($data['pages'] as $k => $v): current($v); ?>
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

