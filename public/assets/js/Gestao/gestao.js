$(document).ready(function() {
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