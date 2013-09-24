<div class="row-fluid">
	<div class="span12">
	<?php $menu = $this->layoutLoad('Blog', 'page'); ?>
	<?php debug($menu); ?>
	    <div class="navbar">
	    	<div class="navbar-inner">
		<a class="brand" href="<?php echo BASE_URL.$menu['home'][0]['pag_url']; ?>"><?php echo $menu['home'][0]['pag_name']; ?></a>
		    	<ul class="nav">
				<li class="divider-vertical"></li>
				<?php foreach($menu['items'] as $k => $v): ?>
					<li class="">
					<a href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name'];?></a>
					</li>
					<li class="divider-vertical"></li>
				<?php endforeach; ?>
				<?php foreach($menu['user'] as $k => $v): ?>
					<li class="">
					<a href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php echo $v['pag_name'];?></a>
					</li>
					<li class="divider-vertical"></li>
				<?php endforeach; ?>
				<?php if(!empty(Auth::$session)): ?> 
					<li class="dropdown">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<strong><?php echo ucfirst(Auth::$session['use_login']); ?></strong>
					<b class="caret"></b>
					</a>
					<ul class="dropdown-menu">
					<li><a href="<?php echo BASE_URL.'/auth/edit'; ?>">Edition profil</a></li>
					<li><a href="<?php echo BASE_URL.'/auth/logout'; ?>">Déconnection</a></li>
					</ul>
					</li>
					<li class="divider-vertical"></li>
				 <?php endif; ?>
				<?php if(!empty(Auth::$session) && Auth::$session['use_statut'] == 10): ?>
					<li class="">
					<a href="<?php echo BASE_URL.'/backoff/index'; ?>">Administration du site</a>
					</li>
					<li class="divider-vertical"></li>
				<?php endif; ?>
				
		    	</ul>
		    </div>
	      </div>
		<?php echo $this->session->flash(); ?>
	</div>
</div>

