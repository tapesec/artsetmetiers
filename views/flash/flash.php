<?php

/**
*@param $statut le statut de vos messages d'alerte
*@return Voici la vue de vos messages d'alertes.
*
**/
	  switch ($_SESSION['flashStatut']) {
		case 'error':
			$alert = 'alert-error';
			break;
		case 'success':
			$alert = 'alert-success';
			break;
			
		default:
			$alert = 'alert-info';
			break;
	   }

	  echo '<div id="notification" class="alert '.$alert.' span4">';
	  echo '<button type="button" href="#" class="close" data-dismiss="alert">&times;</button>';
	  echo $_SESSION['flash'];
	  echo '</div>';?>
	  <script>
		$(document).ready(function(){
			$('#notification')
				.animate({
					left:10
				},700)
				.animate({
					left:10
				},2000)
				.animate({
					opacity:0
				}, 500);
		});
	  </script>
