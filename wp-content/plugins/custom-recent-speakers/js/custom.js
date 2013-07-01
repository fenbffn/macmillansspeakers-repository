/*custom.min*/
	
jQuery(document).ready(function($){
	//portfolio - show link
	$('.fdw-background').hover(
		function () {
			$(this).animate({opacity:'1'});
		},
		function () {
			$(this).animate({opacity:'0'});
		}
	);	
});

//jQuery(document).ready(function($){
//    //portfolio - show link
//    $('.background-speaker').hover(
//        function () {
//            $(this).animate({opacity:'0'});
//        },
//        function () {
//            $(this).animate({opacity:'1'});
//        }
//    );
//});