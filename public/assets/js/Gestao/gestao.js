$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	carregarEmprestimos();
	modalVisualizarPagamento();
	modalLancarPagamento();
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

function modalVisualizarPagamento() {
	$(".tabela_emprestimo tbody").on("click", ".btn_visualizar_pagamento", function() {
		let iEmoId = $(this).data("target");

		$.ajax({
			url: "../../gestao/carregarModalVisualizarPagamentos",
			type: "POST",
			dataType: "html",
			data: {
				iEmoId:iEmoId,
				sUrl:window.location.href
			},
			success: function (html) {
				$("#modalVisualizarPagamentos").html(html).modal("show");
			}
		});
	});
}

function modalLancarPagamento() {
	$(".tabela_emprestimo tbody").on("click", ".btn_lancar_pagamento", function() {
		let iEmoId = $(this).data("target");

		$.ajax({
			url: "../../gestao/carregarModalLancarPagamento",
			type: "POST",
			dataType: "html",
			data: {
				iEmoId:iEmoId,
				sUrl:window.location.href
			},
			success: function (html) {
				$("#modalLancarPagamentos").html(html).modal("show");
			}
		});
	});
}