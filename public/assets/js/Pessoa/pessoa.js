$(document).ready(function() {
	carregarEmprestimos();
})

function carregarEmprestimos() {
	$.ajax({
		url: "../pessoa/pessoaAjax",
		type: "POST",
		data: {sUrl:window.location.href},
		dataType: "HTML",
		success: function (html) {
			$(".tabela_pessoa tbody").html(html);
		}
	});
}