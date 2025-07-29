$(document).ready(function() {
	$(".nav_ul li").hover(
		function () {
			$("ul.nav_ul_sub:not(:animated)",this).slideDown(300);
		},
		function (){
			$("ul.nav_ul_sub",this).slideUp(300);
		}
	);

	setInterval(function () {
		atualizarSituacoesEmprestimo();
	},100000);
});


function atualizarSituacoesEmprestimo() {
	$.ajax({
		url: "../../emprestimo/atualizarSituacoesEmprestimo",
		type: "POST"
	});
}