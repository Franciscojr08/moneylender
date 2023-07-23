$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	$(".nav_ul li").hover(
		function () {
			$("ul.nav_ul_sub:not(:animated)",this).slideDown(300);
		},
		function (){
			$("ul.nav_ul_sub",this).slideUp(300);
		}
	);
});
