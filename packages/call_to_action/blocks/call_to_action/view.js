$(document).ready(function(){
	$('.c5h-call-to-action-close').on("click", function () {
		$(this).parents('div.c5h-call-to-action-wrap').fadeOut();
		$('body').css('margin-top', '0');
	});
});