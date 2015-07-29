$(document).ready(function(){

	$('.dropdown-toggle').unbind('click').bind('click', function (event) {
	//	window.location.href = $(this).attr('href');
		event.stopPropagation();
	});

	$('.dropdown').hover(function(){ 	
		$('.dropdown-menu').fadeToggle();
	//	$('.dropdown-menu').css({'visibility':'visible'});
	});
	
	$('.ckeditor').each(function(){	
		CKEDITOR.replace( $(this).attr('name') );
	});
    
    $(".rating").rating();
});