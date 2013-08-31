<?php debug($enseignement); ?>
<div class="row-fluid">
	<div class="span12">
		<h2>Panneau de configuration de votre carte de visite</h2>
		<p>Cette page vous permet de montrer aux autres usagers du site les diplômes que vous avez obtenues au CNAM,
		les UV déjà validé ou les cours du soirs que vous suivez en ce momennt</p>
		<p>Lorsque vous surfez sur ce site vous pouvez à tout moment cliquez sur les pseudos des internautes qui interviennent sur ce site
		pour voir apparaitre leur carte de visite et en apprendre plus sur leur activités au CNAM</p><p>Validez une par une chacune des rubriques avant de passer à la suivante,
		n'esitez pas à écrire un petit méssage de présentation en bas de page, décrivez vos objectifs scolaires ou professionnels.</p>
		<p>Ce site peut être consulté à thèrme par des professionnels alors ne soyez pas timide.</p>




	<!-- diplome obtenus -->	
		<h5>Entrez un ou plusieurs diplomes obtenus</h5>
		<p>Attention !, un diplôme obtenus signifie que toutes les Unités d'Enseignements (UE) du diplome ont été validé. Le cas contraire vous selectionnerez plus bas uniquement les UES obtenus</p><br>
	</div>

	<div class="row_fluid">
		<div class="span3"></div>
		<div class="span9">
			<div class="input-append" id="dipinput">
			<label>Recherché un diplome ou un code :</label>
			<input type="text" class="span20" id="appendedInputButton">
			<button class="btn" type="button">Ajouter !</button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div id="dipObtain" class="span9 offset3">
			<h4>Diplomes obtenus :</h4>
		</div>
	</div>
<script>
	$('document').ready(function(){
		$('#block_form_diplome').css('display', 'none');	
		$('#dipinput').after('<select class="ajaxSelect" id="ajaxSelect1" size="3" name="diplome"></select>');
		$('#ajaxSelect1').css("display", "none");
			$('#dipObtain').on('click', '#dipTicket button',function(){
			var id = $(this).next().attr("data-id");
			$.ajax({
				type : "GET",
				url :  "<?php echo BASE_URL.'/parcours/delDiplome/'?>"+id,
				success : function(data) {
					if(data == "delSuccess") {
						var dipname = $('#dipObtain span[data-id="'+id+'"]').text();
						$('#notificationAjax').popNotif(dipname+' bien retiré de votre parcours !', 'success');
						$('#dipObtain span[data-id="'+id+'"]').parent().remove();	
					}else{
						$('#notificationAjax').popNotif('Erreur lors de l\'effacement réessayez ou contacter l\'administrateur du site', 'error');
					}	
				},
				error : function(data) {
				}	
			});
		});
		$.ajax({
			type : "GET",
			url : "<?php echo BASE_URL.'/parcours/showDiplome'; ?>",
			success : function(data) {
				$(data).appendTo("#dipObtain");
			},
			error : function(data) {
				$("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>Erreur de chargement de vos diplômes</div>").appendTo("#dipObtain");
			}	
		});
		var option = /option/;
		$('#dipinput input').keyup(function(){
			var val = $(this).val();
			if(val.length > 1){
				$("#ajaxSelect1").css("display", "block");
				$("#ajaxSelect1").html("<option>Recherche en cours ...</option>");		
				$.ajax({
					type :   "GET",
					url :    "<?php echo BASE_URL.'/parcours/getDiplomes/'; ?>"+val,
					success : function(data) {
						if(option.test(data)) {
							$("#ajaxSelect1").html(data);
							$("#ajaxSelect1").click(function(){
								$("#dipinput input").val($(this).children(":selected").text());
							});
						}else{
							$("#ajaxSelect1").html("<option>Pas de résultat</option>");		
						}						
					},
					error :	function() {
						alert("la fonction a echoué");
					}
				});
			}else{
				$("#ajaxSelect1").css("display", "none");
			}
		});
		$('#ajaxSelect1').dblclick(function(){
			var dipname = $(this).children(':selected').text();
			var dipid = $(this).val();
			$.ajax({
				type : "GET",
					
				url :  "<?php echo BASE_URL.'/parcours/saveDiplomes/'; ?>"+dipid,
				success : function(data) {
					if(data == "saveSuccess") {
						if($("#noDiplome").length == 1){
							$("#noDiplome").remove();
						}
						$("<div id='dipTicket' class='alert alert-success'><button type='button' class='close'>&times;</button><span data-id='"+dipid+"'>"+dipname+"</div>").appendTo("#dipObtain");
						$('#notificationAjax').popNotif(dipname + ' bien ajouté à votre parcours', 'success');
						}else if(data == "saveError"){
							$('#notificationAjax').popNotif('Erreur lors de l\'ajout du diplome à votre parcours veuillez réessayer ou contacter l\'administrateur du site', 'error');
						}else if(data == "saved"){
							$('#notificationAjax').popNotif('Vous avez déjà lié ce diplome à votre parcours', 'error');
						}
				},
				error : function(data) {
					alert('zarb');							
				}
			});
		});
		$('#dipinput button').click(function(){
			if($('#ajaxSelect1 option').length >= 1) {
				$('#ajaxSelect1').trigger('dblclick');
			}
		});
			
	});	

</script>	

<div id="block_form_diplome"><!-- Le bloc de checkbox qui s'affiche si le javascript est désactivé chez l'utilisateur-->
	<?php $dip_user = (!empty($enseignement['diplome_user']))? $enseignement['diplome_user'] : array(); ?>
	<div class="row-fluid">
		<div class="span12">	
		<?php $this->Form->create('parcours/addDiplome', array('type' => 'POST', 'name' => 'use_id', 'value' => Auth::$session['use_id'], 'class' => '')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
		<?php $i=0; ?>
		<?php $checked =''; ?>
		<?php foreach ($enseignement['diplome'] as $k => $v): ?>
			<?php foreach($dip_user as $kk => $vv){
				$checked = ($vv['udi_dip_id'] == $v['dip_id'])? true : false;
				if($checked == true){break;}
			}; ?>
			<?php $this->Form->input(array('name' => 'udi_dip_id[]', 'value' => $v['dip_id'], 'type' => 'checkbox', 'checked' => $checked, 'label' => Sanitize::show($v['dip_name']), 'class' => 'checkbox')); ?>
			<?php $i++; ?>	
			<?php if($i==3): ?>
				</div>
				<div class="span4">
				<?php $i=0; ?>	
			<?php endif; ?>
		<?php endforeach; ?>
		</div>

	</div>
	<div class="row-fluid">
		<div class="span12">	
		<?php $this->Form->end(array('type' => 'submit', 'value' => 'Validez', 'class' => 'btn btn-info submit'));    ?>
		</div>
	</div>

</div>
<!-- UV obtenus -->
	<?php $uni_user_success = (!empty($enseignement['unite_user_success']))? $enseignement['unite_user_success'] : array(); ?>

	<div class="row-fluide">
		<div class="span12">
			<h5>Selectionnez des Unités d'enseignements validés</h5>
			<p>Séléctionnez uniquemement ici des UV n'ayant pas encore permis l'obtention d'un diplome</p><br>
		</div>
	</div>

	<div class="row_fluid">
		<div class="span3"></div>
		<div class="span9">
			<div class="input-append" id="uniinput">
			<label>Recherché une UE ou un code :</label>
			<input type="text" class="span20" id="appendedInputButton">
			<button class="btn" type="button">Ajouter !</button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div id="uniObtain" class="span9 offset3">
			<h4>Unités d'Enseignement obtenues :</h4>
		</div>
	</div>
<script>
	$('document').ready(function(){
		$('#block_form_unite').css('display', 'none');	
		$('#uniinput').after('<select class="ajaxSelect" id="ajaxSelect2" size="3" name="unite"></select>');
		$('#ajaxSelect2').css("display", "none");
			$('#uniObtain').on('click', '#uniTicket button',function(){
			var id = $(this).next().attr("data-id");
			$.ajax({
				type : "GET",
				url :  "<?php echo BASE_URL.'/parcours/delUnite/'?>"+id,
				success : function(data) {
					if(data == "delSuccess") {
						var dipname = $('#uniObtain span[data-id="'+id+'"]').text();
						$('#notificationAjax').popNotif(dipname+' bien retiré de votre parcours !', 'success');
						$('#uniObtain span[data-id="'+id+'"]').parent().remove();	
					}else{
						$('#notificationAjax').popNotif('Erreur lors de l\'effacement réessayez ou contacter l\'administrateur du site', 'error');
					}	
				},
				error : function(data) {
				}	
			});
		});
		$.ajax({
			type : "GET",
			url : "<?php echo BASE_URL.'/parcours/showUnite'; ?>",
			success : function(data) {
				$(data).appendTo("#uniObtain");
			},
			error : function(data) {
				$("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>Erreur de chargement de vos UEs</div>").appendTo("#uniObtain");
			}	
		});
		var option = /option/;
		$('#uniinput input').keyup(function(){
			var val = $(this).val();
			if(val.length > 1){
				$("#ajaxSelect2").css("display", "block");
				$("#ajaxSelect2").html("<option>Recherche en cours ...</option>");		
				$.ajax({
					type :   "GET",
					url :    "<?php echo BASE_URL.'/parcours/getUnites/'; ?>"+val,
					success : function(data) {
						if(option.test(data)) {
							$("#ajaxSelect2").html(data);
							$("#ajaxSelect2").click(function(){
								$("#uniinput input").val($(this).children(":selected").text());
							});
						}else{
							$("#ajaxSelect2").html("<option>Pas de résultat</option>");		
						}						
					},
					error :	function() {
						alert("la fonction a echoué");
					}
				});
			}else{
				$("#ajaxSelect2").css("display", "none");
			}
		});
		$('#ajaxSelect2').dblclick(function(){
			var uniname = $(this).children(':selected').text();
			var uniid = $(this).val();
			$.ajax({
				type : "GET",
					
				url :  "<?php echo BASE_URL.'/parcours/saveUnites/'; ?>"+uniid,
				success : function(data) {
					if(data == "saveSuccess") {
						if($("#noUnite").length == 1){
							$("#noUnite").remove();
						}
						$("<div id='uniTicket' class='alert alert-success'><button type='button' class='close'>&times;</button><span data-id='"+uniid+"'>"+uniname+"</div>").appendTo("#uniObtain");
						$('#notificationAjax').popNotif(uniname + ' bien ajouté à votre parcours', 'success');
						}else if(data == "saveError"){
							$('#notificationAjax').popNotif('Erreur lors de l\'ajout du diplome à votre parcours veuillez réessayer ou contacter l\'administrateur du site', 'error');
						}else if(data == "saved"){
							$('#notificationAjax').popNotif('Vous avez déjà lié ce diplome à votre parcours', 'error');
						}
				},
				error : function(data) {
					alert('zarb');							
				}
			});
		});
		$('#uniinput button').click(function(){
			if($('#ajaxSelect2 option').length >= 1) {
				$('#ajaxSelect2').trigger('dblclick');
			}
		});
			
	});	

</script>	









<div id="block_form_unite"><!-- Bloc de checkbox en cas de desactivation du javascript de l'utilisateur-->
	<div class="row-fluid">
		<div class="span12">	
		<?php $this->Form->create('parcours/addUniteValid/1', array('type' => 'POST', 'name' => 'use_id', 'value' => Auth::$session['use_id'], 'class' => '')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
		<?php $i=0; ?>
		<?php $checked =''; ?>
		<?php foreach ($enseignement['Unite'] as $k => $v): ?>
			<?php foreach($uni_user_success as $kk => $vv){
				$checked = ($vv['uun_uni_id'] == $v['uni_id'])? true : false;
				if($checked == true){break;}
			} ?>
			<?php $this->Form->input(array('name' => 'uun_uni_id[]', 'value' => $v['uni_id'], 'type' => 'checkbox', 'checked' => $checked, 'label' => Sanitize::show($v['uni_name']), 'class' => 'checkbox')); ?>
			<?php $i++; ?>	
			<?php if($i==3): ?>
				</div>
				<div class="span4">
				<?php $i=0; ?>	
			<?php endif; ?>
		<?php endforeach; ?>
		</div>

	</div>
	<div class="row-fluid">
		<div class="span12">	
		<?php $this->Form->end(array('type' => 'submit', 'value' => 'Validez', 'class' => 'btn btn-info submit'));    ?>
		</div>
	</div>

</div>





	<!-- UV en cours d'obtention -->
	<?php $uni_user_progress = (!empty($enseignement['unite_user_progress']))? $enseignement['unite_user_progress'] : array(); ?>

	<div class="row-fluide">
		<div class="span12">
			<h5>Selectionnez des Unités d'enseignements en cours d'obtention..</h5>
			<p>Séléctionnez des UV dans lesquels vous etes inscris mais que vous n'avez pas encore obtenus</p><br>
		</div>
	</div>

	<div class="row_fluid">
		<div class="span3"></div>
		<div class="span9">
			<div class="input-append" id="uniinputIP">
			<label>Recherché une UE en cours d'obtention ou son code :</label>
			<input type="text" class="span20" id="appendedInputButton">
			<button class="btn" type="button">Ajouter !</button>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div id="uniIP" class="span9 offset3">
			<h4>Unités d'Enseignement en cours d'obtention :</h4>
		</div>
	</div>
<script>
	$('document').ready(function(){
		$('#block_form_uniteIP').css('display', 'none');	
		$('#uniinputIP').after('<select class="ajaxSelect" id="ajaxSelect3" size="3" name="unite"></select>');
		$('#ajaxSelect3').css("display", "none");
			$('#uniIP').on('click', '#uniTicketIP button',function(){
			var id = $(this).next().attr("data-id");
			$.ajax({
				type : "GET",
				url :  "<?php echo BASE_URL.'/parcours/delUniteIP/'?>"+id,
				success : function(data) {
					if(data == "delSuccess") {
						var dipname = $('#uniIP span[data-id="'+id+'"]').text();
						$('#notificationAjax').popNotif(dipname+' bien retiré de votre parcours !', 'success');
						$('#uniIP span[data-id="'+id+'"]').parent().remove();	
					}else{
						$('#notificationAjax').popNotif('Erreur lors de l\'effacement réessayez ou contacter l\'administrateur du site', 'error');
					}	
				},
				error : function(data) {
				}	
			});
		});
		$.ajax({
			type : "GET",
			url : "<?php echo BASE_URL.'/parcours/showUniteIP'; ?>",
			success : function(data) {
				$(data).appendTo("#uniIP");
			},
			error : function(data) {
				$("<div class='alert alert-error'><button type='button' class='close' data-dismiss='alert'>&times;</button>Erreur de chargement de vos UEs</div>").appendTo("#uniIP");
			}	
		});
		var option = /option/;
		$('#uniinputIP input').keyup(function(){
			var val = $(this).val();
			if(val.length > 1){
				$("#ajaxSelect3").css("display", "block");
				$("#ajaxSelect3").html("<option>Recherche en cours ...</option>");		
				$.ajax({
					type :   "GET",
					url :    "<?php echo BASE_URL.'/parcours/getUnitesIP/'; ?>"+val,
					success : function(data) {
						if(option.test(data)) {
							$("#ajaxSelect3").html(data);
							$("#ajaxSelect3").click(function(){
								$("#uniinputIP input").val($(this).children(":selected").text());
							});
						}else{
							$("#ajaxSelect3").html("<option>Pas de résultat</option>");		
						}						
					},
					error :	function() {
						alert("la fonction a echoué");
					}
				});
			}else{
				$("#ajaxSelect3").css("display", "none");
			}
		});
		$('#ajaxSelect3').dblclick(function(){
			var uniIPname = $(this).children(':selected').text();
			var uniIPid = $(this).val();
			$.ajax({
				type : "GET",
					
				url :  "<?php echo BASE_URL.'/parcours/saveUnitesIP/'; ?>"+uniIPid,
				success : function(data) {
					if(data == "saveSuccess") {
						if($("#noUniteIP").length == 1){
							$("#noUniteIP").remove();
						}
						$("<div id='uniTicketIP' class='alert alert-success'><button type='button' class='close'>&times;</button><span data-id='"+uniIPid+"'>"+uniIPname+"</div>").appendTo("#uniIP");
						$('#notificationAjax').popNotif(uniIPname + ' bien ajouté à votre parcours', 'success');
						}else if(data == "saveError"){
							$('#notificationAjax').popNotif('Erreur lors de l\'ajout de l\'UE à votre parcours veuillez réessayer ou contacter l\'administrateur du site', 'error');
						}else if(data == "saved"){
							$('#notificationAjax').popNotif('Vous avez déjà lié cette UE à votre parcours', 'error');
						}
				},
				error : function(data) {
					alert('zarb');							
				}
			});
		});
		$('#uniinputIP button').click(function(){
			if($('#ajaxSelect3 option').length >= 1) {
				$('#ajaxSelect3').trigger('dblclick');
			}
		});
			
	});	

</script>	



<div id="block_form_uniteIP"><!-- on masque le block de checkbox utile qu'en cas de desactivation du JS -->
	<div class="row-fluid">
		<div class="span12">	
		<?php $this->Form->create('parcours/addUniteValid/0', array('type' => 'POST', 'name' => 'use_id', 'value' => Auth::$session['use_id'], 'class' => '')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
		<?php $i=0; ?>
		<?php $checked =''; ?>
		<?php foreach ($enseignement['Unite'] as $k => $v): ?>
			<?php foreach($uni_user_progress as $kk => $vv){
				$checked = ($vv['uun_uni_id'] == $v['uni_id'])? true : false;
				if($checked == true){break;}
			}; ?>
			<?php $this->Form->input(array('name' => 'uun_uni_id[]', 'value' => $v['uni_id'], 'type' => 'checkbox', 'checked' => $checked, 'label' => $v['uni_name'], 'class' => 'checkbox')); ?>
			<?php $i++; ?>	
			<?php if($i==3): ?>
				</div>
				<div class="span4">
				<?php $i=0; ?>	
			<?php endif; ?>
		<?php endforeach; ?>
		</div>

	</div>
	<div class="row-fluid">
		<div class="span12">	
		<?php $this->Form->end(array('type' => 'submit', 'value' => 'Validez', 'class' => 'btn btn-info submit'));    ?>
		</div>
	</div>
</div>


	<div class="row-fluid">
		<div class="span12">
			<h5>Présentation, objectifs, informations suplémentaires..</h5>
			<div id="emoticons" class="emoticons_area">
    			<a href="#" onclick="return false;" title=":p"><?php $this->img('design/emoticons/tongue.png');?></a>
				<a href="#" onclick="return false;" title=":("><?php $this->img('design/emoticons/unhappy.png');?></a>
				<a href="#" onclick="return false;" title=":D"><?php $this->img('design/emoticons/wink.png');?></a>
				<a href="#" onclick="return false;" title=">:("><?php $this->img('design/emoticons/hangry.png');?></a>
				<a href="#" onclick="return false;" title=":)"><?php $this->img('design/emoticons/smile.png');?></a>
			</div>
				<?php echo $this->Form->create('parcours/addObservation', array('type' => 'POST', 'name' => 'use_id', 'value' => '')); ?>
				
				<?php echo $this->Form->input(array('name' => 'use_obs', 'type' => 'textarea', 'rows' => 10, 'value' => Sanitize::show($enseignement['obs'][0]['use_obs']), 'class' => 'markitup')); ?>

				<?php echo $this->Form->input(array('type' => 'submit', 'value' => 'Envoyer', 'class' => 'btn btn-info submit'));?>
		</div>

	</div>

</div>
