$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	carregarEmprestimos();
})

function carregarEmprestimos() {
	$.ajax({
		url: "../gestao/emprestimoAjax",
		data: {sUrl:window.location.href},
		type: "POST",
		dataType: "HTML",
		success: function (html) {
			$(".tabela_emprestimo tbody").html(html);
		}
	});
}