/**
 *
 * Tous les plugins
 *
 * */

(function($) {
	$.fn.popNotif=function(text, statut) {
		 return (this).each(function(){
			$(this).css('display', 'none').css('top', '-70px').css('display', 'block');
			if(statut == 'success'){
				$(this).removeClass('alert-error');
				$(this).addClass('alert-success');
			}else{
				$(this).removeClass('alert-success');
				$(this).addClass('alert-error');
			}
			$(this).children().text(text);
			$(this).animate({
				top : '0px'
			},500).animate({
				top : '0px'
			},1500).animate({
				top: '-70px'
			},500);
		 });
	};
})(jQuery);
