<?php debug($posts); ?>
<?php if(isset($posts['edition']) && !empty($posts['edition'])){
	$rep = current($posts['edition']);
}
	$post = current($posts['post']);
?>
<ul class="breadcrumb">
	<li><a href="<?php echo BASE_URL.'/forum/index';?>">Accueil</a> <span class="divider">/</span></li>
	<li><a href="<?php echo BASE_URL.'/forum/section/'.$post['sec_id']; ?>"><?php echo $post['sec_name']; ?></a><span class="divider">/</span></li>
   	<li class="active"><?php echo $post['sub_title']; ?></li>
</ul>

<div class="add_message_area">
	<?php if(empty(Auth::$session['use_checked'])): ?>
		<a class="btn btn-info" href="<?php echo BASE_URL.'/auth/connexion'; ?>">Connectez vous !</a>
	<?php endif; ?>
</div>
<div class="clear"></div>
<div class="wall_reply">
	<table class="table table-striped table-bordered table-hover table-condensed">
		<tr>
			
			<?php echo '<td colspan="2"><span class="date"><small>'.DateHelper::fr($post['sub_dateC'], array('delay' => true)).'</span><span class="title"><h4>'.Sanitize::show($post['sub_title']).'</small></h4></span>'; ?>
				<?php if(isset(Auth::$session['use_checked']) && Auth::$session['use_checked'] == true): ?>
					<?php if(Auth::$session['use_id'] == $post['sub_id_author'] || Auth::$session['use_statut'] >= 2): ?>
					<span class="action"><small><a href="<?php echo BASE_URL.'/forum/addSubject/'.$post['sec_id'].'/'.$post['sub_id'];?>"><?php $this->img('design/img/Comment_Edit', array('class' => 'icone_comment', 'alt' => 'icone edition', 'title' => 'Editer')); ?></a></span><span class="action"><a href="<?php echo BASE_URL.'/forum/delSubject/'
					.$post['sub_id'];?>"><?php $this->img('design/img/Comment_Remove.png', array('class' => 'icone_comment', 'alt' => 'icone suppression', 'title' => 'Supprimer')); ?></a><?php if(Auth::$session['use_statut'] >= 2): ?></span><span class="action"><a href="<?php echo BASE_URL.'/forum/lockSubject/'.$post['sub_id'];?>"><?php if($post['sub_lock'] == false): $this->img('design/img/Lock_Open.png', array('class' => 'icone_lock', 'alt'=> 'cadenas', 'title' => 'Sujet déverouillé')); else: $this->img('design/img/Lock_Closed.png', array('class' => 'icone_lock', 'alt' => 'cadenas', 'title' => 'sujet vérouillé')); endif; ?></a><?php endif; ?></small></span>
					<?php endif; ?>
				<?php endif; ?>
			<?php echo '</td>'; ?>
		</tr>
		<tr>		
			<?php echo '<td>'; ?>
			<?php $this->img($post['ava_url'], array('alt' => 'Avatar de '.$post['use_login'], 'class' => 'img-polaroid img-avatar auto')); ?>
			
			<?php echo '<a class="text-success user_name" href="'.BASE_URL.'/parcours/voir/'.$post['use_id'].'">'.ucfirst($post['use_login'].'</a>'); ?>
			<?php $count = $this->layoutLoad('forum', 'messageUserCount', $post['use_id']); ?>
			<?php echo '<span class="text-info compteur_post"><small>Message : '.$count.'</small></span>'; ?>
			
			<?php echo '</td>'; ?>
			<?php echo '<td>'.$this->Markitup->bbcodeParse(Sanitize::show($post['sub_content'])).'</td>'; ?>
		</tr>
		
	<?php if(!empty($posts['list'][0]['rep_content'])): ?>
		<?php foreach ($posts['list'] as $k => $v): current($v); ?>

			<tr>
				<?php echo '<td colspan="2">'; ?>
				<?php echo '<span class="date"><small>'.DateHelper::fr($v['rep_dateC'], array('delay' => true)).'</span><span class="title"><h4><small>'.Sanitize::show($v['rep_title']).'</small></h4></span>'; ?>
				<?php if(isset(Auth::$session['use_checked']) && Auth::$session['use_checked'] == true): ?>
					<?php if(Auth::$session['use_id'] == $v['rep_id_author'] || Auth::$session['use_statut'] >= 2): ?>
					<span class="action"><a href="<?php echo BASE_URL.'/forum/posts/'.$posts['list'][0]['sub_id'].'/1/'.$v['rep_id']; ?>"><?php $this->img('design/img/Comment_Edit.png', array('class' => 'icone_comment')); ?></a></span><span class="action"><a href="<?php echo BASE_URL.'/forum/delReply/'.$v['rep_id']; ?>"><?php $this->img('design/img/Comment_Remove.png', array('class'=> 'icone_comment', 'alt' => 'supprimer', 'title' => 'Supprimer')); ?></a></span>
					<?php endif; ?>
				<?php endif; ?>
				<?php echo '</td>'; ?>
			</tr>
			<tr>		
				<?php echo '<td>'; ?>
				<?php $this->img($v['ava_url'], array('alt' => 'Avatar de '.ucfirst($v['use_login']), 'class' => 'img-avatar img-polaroid auto')); ?>
			
				<?php echo '<a class="text-success user_name" href="'.BASE_URL.'/parcours/voir/'.$post['use_id'].'">'.ucfirst($v['use_login'].'</a>'); ?>
				<?php $count = $this->layoutLoad('forum', 'messageUserCount', $v['use_id']); ?>
				
				<?php echo '<span class="text-info compteur_post"><small>Message : '.$count.'</small></span>'; ?>
				<?php echo '</td>'; ?>
				<?php echo '<td>'; ?>
				<?php echo $this->Markitup->bbcodeParse(Sanitize::show($v['rep_content'])); ?>
				<?php if(!empty($v['rep_dateM'])): ?>
				<?php echo '<span class="edited"><small><em>Edité le '.DateHelper::fr($v['rep_dateM']).' par <span class="text-warning">'.$v['rep_editor'].'</a></em></small></span>'; ?>
				<?php endif; ?>
				<?php echo '</td>'; ?>

			</tr>
		<?php  endforeach; ?>
	<?php endif; ?>

	<?php if(isset(Auth::$session['use_checked']) && Auth::$session['use_checked'] == true && $post['sub_lock'] == false): ?>
		<td colspan="2"></td>
		<tr>
			<td>
			<?php $this->img(Auth::$session['ava_url'], array('alt' => 'Avatar de '.Auth::$session['use_login'], 'class' => 'img-polaroid img-avatar auto')); ?>
			
			<?php echo '<a class="text-success user_name" href="#">'.ucfirst(Auth::$session['use_login'].'</a>'); ?>
			</td>
			<td>
				
				<?php echo $this->Form->create('forum/posts/'.$post['sub_id'].'/1/'.$id = (isset($rep['rep_id']))? $rep['rep_id'] : '', array('type' => 'POST', 'name' => 'rep_id', 'value' => $id)); ?>
			
				<?php echo $this->Form->input(array('name' => 'rep_title', 'type' => 'text', 'label' => 'titre : (facultatif)', 'value' => $value = (isset($rep['rep_title']))? Sanitize::show($rep['rep_title']) : '', 'message' => true)); ?>
				<div id="emoticons" class="emoticons_area">
	    			<a href="#" onclick="return false;" title=":p"><?php $this->img('design/emoticons/tongue.png');?></a>
					<a href="#" onclick="return false;" title=":("><?php $this->img('design/emoticons/unhappy.png');?></a>
					<a href="#" onclick="return false;" title=":D"><?php $this->img('design/emoticons/wink.png');?></a>
					<a href="#" onclick="return false;" title=">:("><?php $this->img('design/emoticons/hangry.png');?></a>
					<a href="#" onclick="return false;" title=":)"><?php $this->img('design/emoticons/smile.png');?></a>
				</div>
				<?php echo $this->Form->input(array('name' => 'rep_content', 'type' => 'textarea', 'label' => '', 'value' => $value = (isset($rep['rep_content']))? Sanitize::show($rep['rep_content']) : '','rows' => 5, 'cols' => 20, 'class' => 'markitup', 'message' => true)); ?>
			
				<?php $this->Form->end(array('type' => 'submit', 'value' => 'Répondre', 'class' => 'btn btn-info submit')); ?>
				

			</td>
		</tr>
	<?php endif; ?>
	</table>
	<?php echo $this->paginator('forum/posts/'.$posts['post'][0]['sub_id'], 'pagination'); ?>
</div>

<script>
	$(document).ready(function(){
		$('#bannerInfo').text('<?php echo $post['sub_title']; ?>');
	});
</script>
