$(document).ready(function() {
	carregarEmprestimos();
})

function carregarEmprestimos() {
	$.ajax({
		url: "../home/emprestimoAjax",
		type: "POST",
		dataType: "HTML",
		success: function (html) {
			$(".tabela_emprestimo tbody").html(html);
		}
	});
}