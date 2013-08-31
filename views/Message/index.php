<?php
debug($list_message);
?>

<div class="row-fluid">
	<div class="offset3">
	<h2>Messagerie privée</h2>
	</div>
</div>

<div class="row-fluid ">
	<div id="new-mes" class="span2 offset3 add_message_area">
	<a href="#zoneForm" class="btn btn-info">Nouveau message</a>
	</div>
	
</div>

<?php  $this->Form->create('message/delete', array('type' => 'POST', 'id' => 'delForm', 'class'=> 'delForm'));
if(isset($list_message) && !empty($list_message)):
foreach($list_message as $k => $v): ?>
	<?php $name = ($v['mes_id_dest'] == Auth::$session['use_id'])? 'mes_dest_del[]' : 'mes_auth_del[]'; ?>

	<div class="row-fluid lignes_mes">
	<div class="span1 offset2"><?php $this->img($v['ava_url'], array('class' => 'img-avatar img-polaroid')); ?>
	</div>
		<div class="span7 mes_block">
		<a class="link_mes_block" href="<?php echo BASE_URL.'/message/voir/'.$v['mes_id']; ?>">
		<strong><?php echo $v['mes_title'];?></strong><br>
		</a>
		<small>Message de <a href="<?php echo BASE_URL.'/parcours/voir/'.$v['use_id']; ?>"><strong><?php echo $v['use_login']; ?></strong></a> <?php echo dateHelper::fr($v['mes_dateC'], array('delay' => true)); ?></small>
		<?php $this->Form->input(array('name' => $name,
						'type' => 'checkbox',
						'value' => $v['mes_id'],
						'class' => 'checkbox checkbox-mes'));

?>
	</div>
	</div>
<?php endforeach;
endif; ?>
<div class="row-fluid">
	<div class="span1 offset2"></div>
	<div class="span7">
	<?php $this->Form->end(array('type' => 'submit', 'class' => 'btn btn-info submit','id' => 'del-mes-submit', 'value' => 'supprimer')); ?>
	</div>
<?php 
//------------------------------- Formulaire de redaction de nouveau MP ----------------------
?>
<div id="zoneForm">
	<div class="row-fluid">
	<div class="span1 offset2"></div>
	<div class="span7">
	<h3>Nouveau message </h3>
	</div>
	</div>
	<div class="row-fluid">
	<div class="span1 offset2"><?php $this->img(Auth::$session['ava_url'], array('class' => 'img-avatar img-polaroid')); ?>
</div> 
	<div class="span7">
<?php	
	$this->Form->create('message/ecrire', array('type' => 'POST', 'id' => 'FormEcrire'));
	
	$this->Form->input(array('name' => 'use_login',
				 'type' => 'text',
				 'label' => 'Destinataire :',
				 'autocomplete' => 'off',
			 	 'id' => 'login'));

	$this->Form->input(array('name' => 'mes_title',
			  	 'type' => 'text',
				 'label' => 'Titre du message'));

	$this->Form->input(array('type' => 'textarea', 
				 'name' => 'mes_content', 
				 'label' => 'Votre message',
				 'rows' => 5,
			 	 'class' => 'messarea'));

	$this->Form->end(array('type' => 'submit',
			       'value' => 'Envoyer',
			       'class' => 'btn btn-info submit'));

?>
	</div>
	</div>
</div>


<script>
/**
 *requete ajax pour trouver un membre
 * */
	$('document').ready(function(){
		$('#login').after('<br><select class="ajaxSelect" id="ajaxSelect" size="3" name="use_login"></select>');
		$('#ajaxSelect').css("display", "none");
		var option = /option/;
		$('#login').keyup(function(){
			var val = $(this).val();
			if(val.length > 1){
				$("#ajaxSelect").css("display", "block");
				$("#ajaxSelect").html("<option>Recherche en cours ...</option>");		
				$.ajax({
					type :   "GET",
					url :    "<?php echo BASE_URL.'/message/getLogin/'; ?>"+val,
					success : function(data) {
						if(option.test(data)) {
							$("#ajaxSelect").html(data);
							$("#ajaxSelect").click(function(){
								$("#login").val($(this).val());
							});
						}else{
							$("#ajaxSelect").html("<option>Pas de résultat</option>");		
						}						
					},
					error :	function() {
						alert("la fonction a echoué");
					}
				});
			}else{
				$("#ajaxSelect").css("display", "none");
			}
		});	
	});	

</script>


