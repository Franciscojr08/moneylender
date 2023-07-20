$(document).ready(function() {
	$(".rel_tipo").change(function() {
		$(".div_filtro").hide();
		$(`#${$(this).data("target")}`).show();
	});
});