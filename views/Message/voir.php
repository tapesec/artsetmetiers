<?php debug($conversation);?>
<div class="row-fluid">
	<div class="span3">

	</div>
	<div class="span9">
		<?php $conv = current($conversation['message']); ?>
		<div class="row-fluid lignes_mes">
			<div class="span2"></div>
			<div class="span10"><h2><?php echo $conv['mes_title']; ?></h2></div>
		</div>

		<div class="row-fluid lignes_mes">
		
			<div class="span2"><?php $this->img($conv['ava_url'], array('class' => 'img-avatar img-polaroid')); ?></div>
			<div class="span10">
					<small>Message de <a href="<?php echo BASE_URL.'/parcours/voir/'.$conv['use_id']; ?>"><strong><?php echo $conv['use_login']; ?></strong></a> <?php echo dateHelper::fr($conv['mes_dateC'], array('delay' => true)); ?></small>
			<p><?php echo $conv['mes_content']; ?></p>
			</div>
		</div>

<?php

	if(isset($conversation['reponse']) && !empty($conversation['reponse'])) : ?>
	<?php foreach($conversation['reponse'] as $k => $v): ?>
		<div class="row-fluid block_com lignes_mes">
		<div class="span2"><?php $this->img($v['ava_url'], array('class' => 'img-avatar img-polaroid')); ?></div>
		<div class="span7">
			<small>Message de <a href="<?php echo BASE_URL.'/parcours/voir/'.$v['use_id']; ?>"><strong><?php echo $v['use_login']; ?></strong></a> <?php echo DateHelper::fr($v['rep_dateC'], array('delay' => true)); ?></small>
			<p><?php echo $v['rep_content']; ?></p>
		</div>
		</div>
	<?php endforeach; ?>
	<?php endif; ?>

		<div class="row-fluid">
		<div class="span2"><?php $this->img(Auth::$session['ava_url'], array('class' => 'img-avatar img-polaroid')); ?></div>
		<div class="span10">
<?php	$this->Form->create('message/repondre/'.$conv['mes_id'], array(
					'type' => 'POST', 
					'id' => 'repondre'));
	$this->Form->input(array(
		'name' => 'rep_content', 
		'type' => 'textarea', 
		'label' => 'Répondre :',
	        'class' => 'reparea',	
		'id' => 'textarea',
		'message' => array('class' => 'error')));

	$this->Form->end(array('type' => 'submit',
			'value' => 'Envoyer',
			'class' => 'btn btn-info submit'));

?>
		</div>
		</div>
	</div>

</div>
