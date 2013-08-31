
/**
*foncion qui vérifié le formulaire de connexion à l'espace membre du site
*
**/
function checklogin(){
	var one = 0;
	var check = true;
	$('#connexion .submit').click(function(){
		var login = $('#connexion #login').val();
		var pass = $('#connexion #password').val();

		if(!login){
			if(one < 2){

				$('#login').after('<span class=" label label-important"></span>');
				$('#login').css('border', '1px solid #b94a47').after(' <span class=" label label-important"> Vous n\'avez pas tapez de login !</span>');
				$('#login').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else{
			$('#login').css('border', '#CCCCCC').prev().css('color', 'black').css('font-weight', 'normal');
			$('#login').next().text('');
			check = true;
		}
		if(!pass){
			if(one < 2){
				$('#password').css('border', '1px solid #b94a47').after(' <span class=" label label-important"> Vous n\'avez pas tapez de mot de passe !</span>');
				$('#password').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else{
			$('#password').css('border', '1px solid #CCCCCC').prev().css('color', 'black').css('font-weight', 'normal');
			$('#password').next().text('');
			check = true;
		}

	return check;	
	});
}


/**
*fonction de test du formulaire d'inscription
**/
function checkinscription(){
	var one = 0;
	var check = true;
	$('#inscription .submit').click(function(){
		var login = $('#inscription #login').val();
		var mail = $('#inscription #mail').val();
		var pass1 = $('#inscription #pass1').val();
		var pass2 = $('#inscription #pass2').val();

		var login_test = /^[0-9a-zA-Z]{3,}$/;
		var mail_test = /^[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*@[a-z0-9]+([_|\.|-]{1}[a-z0-9]+)*[\.]{1}[a-z]{2,6}$/;
		var pass1_test = /^[0-9a-zA-Z]{5,}$/;

		//test du champs login ---
		if(!login || !login_test.test(login)){
			if(one < 4){

				$('#login').after('<span class=" label label-important"></span>');
				$('#login').css('border', '1px solid #b94a47').after(' <span class=" label label-important">Minimum 3 caractères et alphanuméric uniquement</span>');
				$('#login').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else{
			$('#login').css('border', '1px solid green').prev().css('color', 'green').css('font-weight', 'normal');
			$('#login').next().text('');
			check = true;
		}
		//test du champ mail ----
		if(!mail || !mail_test.test(mail)){
			if(one < 4){

				$('#mail').after('<span class=" label label-important"></span>');
				$('#mail').css('border', '1px solid #b94a47').after(' <span class=" label label-important">Cette adresse mail est invalide</span>');
				$('#mail').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else{
			$('#mail').css('border', '1px solid green').prev().css('color', 'green').css('font-weight', 'normal');
			$('#mail').next().text('');
			check = true;
		}

		//test du champ mot de pass1----
		if(!pass1 || !pass1_test.test(pass1)){
			if(one < 4){
				$('#pass1').css('border', '1px solid #b94a47').after(' <span class=" label label-important"> Il est préférable que votre mot de passe fasse au moins 5 caractères</span>');
				$('#pass1').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else{
			$('#pass1').css('border', '1px solid green').prev().css('color', 'green').css('font-weight', 'normal');
			$('#pass1').next().text('');
			check = true;
		}

		// test du champ mot de pass 2
		if(!pass2 || pass2 != pass1){
			if(one < 4){
				$('#pass2').css('border', '1px solid #b94a47').after(' <span class=" label label-important"> Vous avez mal comfirmé votre mot de passe</span>');
				$('#pass2').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else if(pass2 == pass1){
			$('#pass2').css('border', '1px solid green').prev().css('color', 'green').css('font-weight', 'normal');
			$('#pass2').next().text('');
			check = true;
		}

	return check;	
	});
}
/*
function checkComment(){
	var one = 0;
	var check = true;
	$('#comment .submit').click(function(){
		var comment = $('#comment #com_content').val();
		var comment_test = /^.{2,}$/;

		if(!comment || !comment_test.test(comment)){
			if(one < 1){

				$('#com_content').after('<span class=" label label-important"></span>');
				$('#com_content').css('border', '1px solid #b94a47').after(' <span class=" label label-important">Ecrivez un commentaire d\'au moins deux caractères</span>');
				$('#com_content').prev().css('color', '#b94a47').css('font-weight', 'bold');
				one++;
			}
			check = false;
		}else{
			$('#comment').css('border', '#CCCCCC').prev().css('color', 'black').css('font-weight', 'normal');
			$('#comment').next().text('');
			check = true;
		}
	return check;	
	});
}
*/

function menuCategories(){
	$('.main_aside_categories ul li:nth-child(2)').addClass('active');
	$('.main_aside_categories .info').click(function(){
		$(this).toggleClass('active');
	});
}

/**
 *gere le javascript d'affichage du bouton supprimer et de l'envoie du formulaire par javascript
 * */
function del_mes() {
	$('#new-mes').after("<div id=\"del-btn\" class=\"span3 offset3 add_message_area btn-hide\"><a href=\"#zoneForm\" class=\"btn btn-danger btn-hide\"><i class=\"icon-trash\"></i> Vider le journal</a></div>");
	$('#del-mes-submit').css('visibility', 'hidden');	
	$('.checkbox-mes > input').click(function(){
		if($("#del-btn[class*=\"btn-hide\"]")) {
			$('#del-btn').removeClass('btn-hide');
		}
		if($('.checkbox-mes > input:checked').length == 0) {
			$('#del-btn').addClass('btn-hide');	
		}
		
	});
	$('#del-btn a').click(function(){
		if(confirm('Etes vous sûr de vouloir retirer cette conversation de votre boite de reception ?\nLa conversation sera à nouveau disponible si votre interlocuteur poste une nouvelle réponse')){
			$('#delForm').submit();
		}
	});
}

$(document).ready(function(){
	checklogin();
	checkinscription();
	del_mes();
});
