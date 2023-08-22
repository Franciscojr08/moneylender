$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	$(".rel_tipo").change(function() {
		let iTipoRelatorio = $(this).val();

		$(".div_filtro").hide();
		$(`#${$(this).data("target")}`).show();
		$(".tipo_relatorio").val(iTipoRelatorio);
	});

	changeTipoPessoaRecibo();
	carregarEmprestimoPorCliente();
	carregarEmprestimoPorFornecedor();
});

function changeTipoPessoaRecibo() {
	$(".emo_tipo_pessoa_recibo").change(function() {
		const CLIENTE = 1;
		const PESSOAL = 2;
		let eInputFornecedor = $("#recibo_fornecedor");
		let eInputCliente = $("#recibo_cliente");
		let eSelect = $("#filtro_recibo_emprestimo");

		if (parseInt($(this).val()) === CLIENTE) {
			eInputFornecedor.hide().find("select").attr('required', false);
			eInputCliente.show().find("select").attr('required', true);

			$(".mensagem_error").remove();
			eSelect.empty();
			eSelect.append(`<option selected style="display: none;" value="">Selecione o Empréstimo</option>`);
		} else if (parseInt($(this).val()) === PESSOAL) {
			eInputFornecedor.show().find("select").attr('required', true);
			eInputCliente.hide().find("select").attr('required', false);

			$(".mensagem_error").remove();
			eSelect.empty();
			eSelect.append(`<option selected style="display: none;" value="">Selecione o Empréstimo</option>`);
		}
	});
}

function carregarEmprestimoPorCliente() {
	$("#filtro_recibo_cliente").change(function() {
		let iPsaId = $(this).val();
		carregarEmprestimo(iPsaId);
	});
}

function carregarEmprestimoPorFornecedor() {
	$("#filtro_recibo_fornecedor").change(function() {
		let iPsaId = $(this).val();
		carregarEmprestimo(iPsaId);
	});
}

function carregarEmprestimo(iPsaId) {
	$.ajax({
		url: "../emprestimo/consultarPorPessoaAjax",
		type: "post",
		data: {iPsaId:iPsaId},
		dataType: "json",
		success: function (json) {
			if (json.status) {
				$(".mensagem_error").remove();
				$("#filtro_recibo_emprestimo").empty();
				$.each(json.opcoes, function (key, valor) {
					$("#filtro_recibo_emprestimo").append(`<option value='${valor.valor}'>${valor.descricao}</option>`);
				});
			} else {
				let eSelect = $("#filtro_recibo_emprestimo");
				$(".mensagem_error").remove();
				eSelect.empty();
				eSelect.append(`<option selected style="display: none;" value="">Selecione o Empréstimo</option>`);
				eSelect.after(`<p class="mensagem_error">${json.msg}</p>`);
			}
		}
	});
}