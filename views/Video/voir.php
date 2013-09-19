<?php debug($wall); ?>


<div class="row-fluid">
	<div class="span12">
		<?php //debug($v); ?>
		<?php $art = $wall['article'][0]; ?>
	
		<article>
		<h1 class="text-success text-center"><?php echo $art['art_title']; ?></h1>
		<iframe class="video-window span10 offset1" height="537" src="<?php echo $art['art_youtube']; ?>" frameborder="0" allowfullscreen></iframe>	<div class="span10 offset1">

		<div><small>Par <a href="<?php echo BASE_URL.'/parcours/voir/'.$art['use_id']; ?>">
		<span class="label label-info"><strong><?php echo $art['use_login']; ?></strong></span></a>
		<?php echo dateHelper::fr($art['art_dateC'], array('delay' => true)); ?>
		<span class="auteur"><a href=""> <span class="label label-warning"><?php echo '#'.$art['cat_name']; ?></span></a></span>
		<span class="text-success label label-success">
		<?php $nbre_com = $this->layoutLoad('blog', 'countCom', $art['art_id']); ?>
		<?php echo $nbre_com; echo ($nbre_com <= 1)? ' commentaire' : ' commentaires'; ?>
		</span>
		</small></div>
				<p><?php echo $this->Markitup->bbcodeParse(Sanitize::show($art['art_content'])); ?></p>
		</div>
		<div class="clearfix"></div>
		</article>
		<div class="wall_comment span10 offset1">
			
			<?php if(isset($wall['comment']) && !empty($wall['comment'])): ?>
				<?php foreach($wall['comment'] as $k => $v): ?>
					<div class="row-fluid block_com">
						<div class="span2">
							<?php $this->img($v['ava_url'], array('class' => 'img-avatar img-polaroid auto')); ?>
						</div>
						<div class="span10">	
							<small><span><?php echo DateHelper::fr($v['com_dateC'], array('delay' => true)); ?></span>
							<span><a href="<?php echo BASE_URL.'/parcours/voir/'.$v['use_id']; ?>"><strong><?php echo $v['use_login'].'</strong></a> a écrit :'; ?></small></span>
							<?php if(isset(Auth::$session) && Auth::$session['use_id'] == $v['com_id_user'] || Auth::$session['use_statut'] >= 2): ?>
								<a href="<?php echo BASE_URL.'/video/voir/'.$art['art_id'].'/'.$v['com_id'].'/'.$v['com_id_user']; ?>"><div class="edit pull-right"></div></a><a href="<?php echo BASE_URL.'/blog/delete/'.$v['com_id']; ?>"><div class="delete pull-right"></div></a>
							<?php endif; ?>
							<?php echo $this->Markitup->bbcodeParse(Sanitize::show($v['com_content']));?>
							<?php if(!empty($v['com_name_editor'])): ?>
								<span class="edited"><small><?php echo 'Édité '.DateHelper::fr($v['com_dateM'], array('delay' => true)).' par <a href="">'.$v['com_name_editor'].'</a>'; ?></span></small>
							<?php endif; ?>
							
							</span>
						</div>
					</div>
				<?php endforeach ?>
			<?php endif; ?>
		

		<?php if(isset(Auth::$session)): ?>
			<?php $edit = (isset($wall['edit'][0]))? $wall['edit'][0] : ''; ?>
			<div class="row-fluid form_comment_area">
				<div class="row-fluid">
					<div class="12"><h4>Écrire un commentaire</h4></div>
				</div>
				<div class="row-fluid">
					<div class="span2">
						<?php $this->img(Auth::$session['ava_url'], array('class' => 'img-avatar img-polaroid auto')); ?>
					</div>
					<div class="span10">
						<div id="emoticons" class="emoticons_area">
    						<a href="#" onclick="return false;" title=":p"><?php $this->img('design/emoticons/tongue.png');?></a>
							<a href="#" onclick="return false;" title=":("><?php $this->img('design/emoticons/unhappy.png');?></a>
							<a href="#" onclick="return false;" title=":D"><?php $this->img('design/emoticons/wink.png');?></a>
							<a href="#" onclick="return false;" title=">:("><?php $this->img('design/emoticons/hangry.png');?></a>
							<a href="#" onclick="return false;" title=":)"><?php $this->img('design/emoticons/smile.png');?></a>
						</div>

						<?php echo $this->Form->create('video/voir/'.$art['art_id'].'/'.$id = (isset($edit['com_id']))? $edit['com_id'] : '', array('type' => 'POST', 'name' => 'com_id', 'value' => $id, 'id' => 'comment')); ?>

						<?php echo $this->Form->input(array('name' => 'com_content',
															'type' => 'textarea',
															'rows' => 4,
															'value' => $value = (isset($edit['com_content']))? Sanitize::show($edit['com_content']) : '',
															'class' => 'markitup',
															'id' => 'com_content',
															'message' => array('class' => 'text-error'))); ?>

						<?php echo $this->Form->input(array('type' => 'submit', 'value' => 'Envoyer', 'class' => 'btn btn-info submit'));?>
					</div>

				</div>
				
				
			</div>


			



		<?php else: ?>
			<div class="row-fluid login_comment_area">
				<div class="row-fluid">
					<div class="12"><h4>Identifiez vous</h4></div>
				</div>
				<div class="row-fluid">
					<div class="span2">
						<?php $this->img('design/img/avatar.png', array('class' => 'img-polaroid img-avatar auto')); ?>
					</div>
					<div class="span10">
						<a class="btn btn-info" href="<?php echo BASE_URL.'/auth/inscription'; ?>">S'inscrire</a><a class="btn btn-info" href="<?php echo BASE_URL.'/auth/connexion'; ?>">Se connecter</a>
					</div>
				</div>
			</div>
		<?php endif; ?>
		</div>
	</div>
</div>
