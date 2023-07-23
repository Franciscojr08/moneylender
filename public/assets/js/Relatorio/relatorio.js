$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	$(".rel_tipo").change(function() {
		$(".div_filtro").hide();
		$(`#${$(this).data("target")}`).show();
	});
});