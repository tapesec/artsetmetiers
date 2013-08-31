<?php 
debug($menu);
?>
<div class="span2">
</div>
<nav>
	<?php  $i=0; ?>
	<div class="span8 bouton_admin">
		
			
			<ul class="thumbnails"><div class="row-fluid">
				<?php foreach($menu as $k => $v): current($v)?>
					<?php if($v['pag_id'] != 5): ?>
						<?php if($i<4): ?>
							<?php $i++; ?>
							<li class="span3">
								<a class="" href="<?php echo BASE_URL.$v['pag_url']; ?>">
									<?php $this->img($v['pag_src'], array('alt' => $v['pag_name'], 'title' => $v['pag_name'])); ?>
								</a>
							</li>
						<?php else: ?>
							</div>
							<div class="row-fluid">
							<li class="span3"><a class="" href="<?php echo BASE_URL.$v['pag_url']; ?>"><?php $this->img($v['pag_src'], array('alt' => $v['pag_name'], 'title' => $v['pag_name'])); ?></a></li>
							<?php $i=0; ?>	
						<?php endif; ?>
					<?php endif; ?><?php //$i=0; ?>		
				<?php endforeach; ?> 
			</div></ul>
			
		
	</div>
</nav>
<div class="span2">
</div>