$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	carregarValoresAjax("getValorTotalInvestido","li_total_investido");
	carregarValoresAjax("getValorTotalRecebido","li_total_recebido");
	carregarValoresAjax("getValorTotalAReceber","li_total_a_receber");
	carregarValoresAjax("getValorTotalAtrasado","li_total_atrasado");
	carregarValoresAjax("getValorJurosRecebido","li_juros_recebido");
	carregarValoresAjax("getValorJurosAReceber","li_juros_a_receber");
	carregarEmprestimos();

	modalVisualizarPagamento();
	modalLancarPagamento();
	modalCancelarEmprestimo();
	modalExcluirEmprestimo();

	filtrarEmprestimoAjax();
	limparFiltroEmprestimo();
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

function modalCancelarEmprestimo() {
	$(".tabela_emprestimo tbody").on("click", ".btn_cancelar_emprestimo", function() {
		let iEmoId = $(this).data("target");

		$.ajax({
			url: "../../emprestimo/carregarModalCancelarEmprestimo",
			type: "POST",
			dataType: "html",
			data: {
				iEmoId:iEmoId,
				sUrl:window.location.href
			},
			success: function (html) {
				$("#modalCancelarEmprestimo").html(html).modal("show");
			}
		});
	});
}

function modalExcluirEmprestimo() {
	$(".tabela_emprestimo tbody").on("click", ".btn_excluir_emprestimo", function() {
		let iEmoId = $(this).data("target");

		$.ajax({
			url: "../../emprestimo/carregarModalExcluirEmprestimo",
			type: "POST",
			dataType: "html",
			data: {
				iEmoId:iEmoId,
				sUrl:window.location.href
			},
			success: function (html) {
				$("#modalExcluirEmprestimo").html(html).modal("show");
			}
		});
	});
}

function filtrarEmprestimoAjax() {
	$(".btn_filtrar_emprestimo").click(function() {
		let iPsaId = $(".psa_id_filtro").val();
		let sDataEmprestimo = $(".emo_data_emprestimo_filtro").val();
		let iJuros = $(".emo_juros_filtro:checked").val();
		let iParcelado = $(".emo_parcelado_filtro:checked").val();
		let aSituacaoId = [];
		$(".emo_situacao_filtro:checked").each(function() {
			aSituacaoId.push($(this).val());
		});

		let aFiltro = {
			iPsaId: iPsaId,
			sDataEmprestimo: sDataEmprestimo,
			iJuros: iJuros,
			iParcelado: iParcelado,
			aSituacaoId: aSituacaoId
		}

		$.ajax({
			url: "../gestao/emprestimoAjax",
			data: {
				aFiltro:aFiltro,
				sUrl: window.location.href
			},
			type: "POST",
			dataType: "HTML",
			success: function (html) {
				$(".tabela_emprestimo tbody").html("");
				$(".tabela_emprestimo tbody").html(html);
			}
		});
	});
}

function limparFiltroEmprestimo() {
	$(".btn_limpar_filtro_emprestimo").click(function() {
		$(".psa_id_filtro option:first").prop("selected",true);
		$(".emo_data_emprestimo_filtro").val("");
		$(".emo_juros_filtro:checked").prop("checked",false);
		$(".emo_parcelado_filtro:checked").prop("checked",false);;
		$(".emo_situacao_filtro:checked").each(function() {
			$(this).prop("checked",false);
		});

		carregarEmprestimos();
	});
}

function carregarValoresAjax(sAcao,eElement) {
	$.ajax({
		url: `../emprestimo/${sAcao}`,
		type: "POST",
		data: {sUrl:window.location.href},
		dataType: "json",
		success: function (json) {
			$(`#${eElement}`).contents().filter(function() {
				return this.nodeType === 3 && this.nodeValue.trim() === "Aguarde...";
			}).replaceWith(json);
		}
	});
}