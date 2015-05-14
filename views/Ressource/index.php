
<div class="row_fluid">
	<div class="span8 offset2">
		<div class="input-append" id="UEinput">
		<label>Recherché le nom d'une UE ou son code pour acceder aux contenus telechargables :</label>
		<input type="text" class="span20" id="appendedInputButton">
		<button class="btn" type="button">Cherchez !</button>
		</div>
	</div>
</div>

<table class="table">
<caption>MVA003 Mathématiques pour la programmation</caption>
<tr>
	<th>Nom du fichier</th>
	<th>Mis en ligne</th>
	<th>Taille</th>
	<th>Type</th>
	<th>telecharger</th>
</tr>


</table>
<script>
$(document).ready(function(){
$('#UEinput').after('<select class="ajaxSelect" id="ajaxSelect" size="3" name=""></select>');
		$('#ajaxSelect').css("display", "none");

		$('#UEpinput input').keyup(function(){
			var val = $(this).val();
			if(val.length > 1){
				$("#ajaxSelect").css("display", "block");
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


});
</script>				
