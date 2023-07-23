$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	mudarCliente();
	mudarJuros()
	calcularMudancasJuros();
	calcularMudancasValor();

	mudarParcela();
	calcularValorParcela();

	$("#fornecedor_emp").find("select").change(function() {
		let sFornecedor = $("#fornecedor_emp").find("select option:selected").text();
		$(".input_pessoa").val(sFornecedor);
	});

	$("#cliente_emp").find("select").change(function() {
		let sCliente = $("#cliente_emp").find("select option:selected").text();
		$(".input_pessoa").val(sCliente);
	});

	$("#emo_data_emprestimo").change(function() {
		$(".input_data_emp").val($(this).val().replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1'));
	});

	$("#pra_data_previsao_pagamento").change(function() {
		$(".input_primeira_parcela").val($(this).val().replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1'));
		$(".input_prev_pag").val("- - -");
	});

	$("#emo_data_previsao_pagamento").change(function() {
		$(".input_prev_pag").val($(this).val().replace(/(\d*)-(\d*)-(\d*).*/, '$3/$2/$1'));
	});
});

function mudarCliente() {
	const EMP_PESSOAL = 1;
	const EMP_CLIENTE = 2;

	$(".emo_tipo").change(function() {
		let eInputTipo = $("#emo_tipo");
		let eInputLabelPessoa = $("#label_pessoa");
		let eInputFornecedor = $("#fornecedor_emp");
		let eInputCliente = $("#cliente_emp");
		let eInputPessoa = $(".input_pessoa");

		if (parseInt($(this).val()) === EMP_PESSOAL) {
			eInputTipo.val(EMP_PESSOAL);
			eInputLabelPessoa.text("Fornecedor");

			eInputFornecedor.show().find("select").attr('required', true);
			eInputCliente.hide().find("select").attr('required', false);

			let sFornecedor = eInputFornecedor.find("select option:selected").text();
			if (eInputFornecedor.find("select option:selected").val() > 0) {
				eInputPessoa.val(sFornecedor);
			} else {
				eInputPessoa.val("");
			}
		} else if (parseInt($(this).val()) === EMP_CLIENTE) {
			eInputTipo.val(EMP_CLIENTE);
			eInputLabelPessoa.text("Cliente");

			eInputFornecedor.hide().find("select").attr('required', false);
			eInputCliente.show().find("select").attr('required', true);

			let sCliente = eInputCliente.find("select option:selected").text();
			if (eInputCliente.find("select option:selected").val() > 0) {
				eInputPessoa.val(sCliente);
			} else {
				eInputPessoa.val("");
			}
		}
	});
}

function mudarJuros() {
	const COM_JUROS = 1;
	const SEM_JUROS = 2;

	$("#juros_emp").change(function() {
		let eTaxaJuros = $("#emo_taxa_juros");
		let eInputJuros = $(".input_juros");
		let eInputValorJuros = $(".input_valor_juros");
		let fValor = getValorEmprestimo();
		let iQuantidadeParcelas = $("#emo_quantidade_parcelas").val();

		if (parseInt($(this).val()) === COM_JUROS) {
			eTaxaJuros.attr("disabled",false);
			eTaxaJuros.attr('required', true);
			eTaxaJuros.val("");
			eInputJuros.val("");
			eInputValorJuros.val("");
		} else if (parseInt($(this).val()) === SEM_JUROS) {
			eTaxaJuros.attr("disabled",true);
			eTaxaJuros.attr('required', false);
			eTaxaJuros.val("");
			eInputJuros.val("Não");
			eInputValorJuros.val("");
			$("#input_info_valor_juros").val("Não");

			if (fValor > 0) {
				$(".input_valor_total").val(fValor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));

				if (iQuantidadeParcelas > 0) {
					let fValorParcela = fValor / iQuantidadeParcelas;
					$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
				}
			}
		}
	});
}

function calcularMudancasJuros() {
	$("#emo_taxa_juros").change(function() {
		let fPorcentagem = parseFloat($(this).val());
		let fValor = getValorEmprestimo();
		let iQuantidadeParcelas = $("#emo_quantidade_parcelas").val();

		if (fPorcentagem > 0) {
			$(".input_juros").val(`${fPorcentagem} %`);
		} else {
			$(".input_juros").val("");
		}

		if (fValor > 0 && fPorcentagem > 0) {
			let fValorJuros = (fValor * (fPorcentagem / 100));
			let fValorTotal = fValor + fValorJuros;

			if (iQuantidadeParcelas > 0) {
				let fValorParcela = fValorTotal / iQuantidadeParcelas;

				$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
			}

			$(".input_valor_juros").val(fValorJuros.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			$(".input_valor_total").val(fValorTotal.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
		} else if (fValor > 0) {
			$(".input_valor_total").val(fValor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			$(".input_valor_juros").val("");

			if (iQuantidadeParcelas > 0) {
				let fValorParcela = fValor / iQuantidadeParcelas;
				$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
			}
		} else {
			$(".input_valor_juros").val("");
			$(".input_valor_total").val("");
			$(".input_pag_parcelado").val("");
		}
	});

}

function calcularMudancasValor() {
	$("#emo_valor").change(function() {
		let fValor = getValorEmprestimo();
		let fPorcentagem = parseFloat($("#emo_taxa_juros").val());
		let iQuantidadeParcelas = $("#emo_quantidade_parcelas").val();

		if (fValor > 0 && fPorcentagem > 0) {
			let fValorJuros = (fValor * (fPorcentagem / 100));
			let fValorTotal = fValor + fValorJuros;

			if (iQuantidadeParcelas > 0) {
				let fValorParcela = fValorTotal / iQuantidadeParcelas;

				$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
			}

			$(".input_valor_juros").val(fValorJuros.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
			$(".input_valor_total").val(fValorTotal.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));
		} else if (fValor > 0) {
			$(".input_valor_total").val(fValor.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"}));

			if (iQuantidadeParcelas > 0) {
				let fValorParcela = fValor / iQuantidadeParcelas;
				$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
			}
		} else {
			$(".input_valor_juros").val("");
			$(".input_valor_total").val("");
			$(".input_pag_parcelado").val("");
		}
	});
}

function getValorEmprestimo() {
	let fValor = $("#emo_valor").val();
	fValor = fValor.replace(/[^0-9,.]+/g, '');
	fValor = fValor.replace(/\./g, '').replace(',', '.');
	fValor = parseFloat(fValor);

	return fValor;
}

function mudarParcela() {
	const PARCELADO = 1;
	const NAO_PARCELADO = 2;

	$("#pagamento_emp").change(function() {
		let eInputValorParcelado = $(".input_pag_parcelado");
		let eInputQuantidadeParcelas = $("#emo_quantidade_parcelas");
		let eInputDataPrevisaoParcela = $("#pra_data_previsao_pagamento");
		let eInputDataPrevisaoEmprestimo = $("#emo_data_previsao_pagamento");

		if (parseInt($(this).val()) === PARCELADO) {
			eInputValorParcelado.val("");
			eInputQuantidadeParcelas.attr("disabled",false);
			eInputQuantidadeParcelas.attr('required', true);
			eInputQuantidadeParcelas.val("");

			eInputDataPrevisaoParcela.attr("disabled",false);
			eInputDataPrevisaoParcela.attr('required', true);
			eInputDataPrevisaoParcela.val("");

			eInputDataPrevisaoEmprestimo.attr("disabled",true);
			eInputDataPrevisaoEmprestimo.attr("required",false);
			eInputDataPrevisaoEmprestimo.val("");
			$(".input_primeira_parcela").val("")
			$(".input_prev_pag").val("");
		} else if (parseInt($(this).val()) === NAO_PARCELADO) {
			eInputValorParcelado.val("Não");
			eInputQuantidadeParcelas.attr("disabled",true);
			eInputQuantidadeParcelas.attr('required', false);
			eInputQuantidadeParcelas.val("");

			eInputDataPrevisaoParcela.attr("disabled",true);
			eInputDataPrevisaoParcela.attr('required', false);
			eInputDataPrevisaoParcela.val("");

			eInputDataPrevisaoEmprestimo.attr("disabled",false);
			eInputDataPrevisaoEmprestimo.attr("required",true);
			eInputDataPrevisaoEmprestimo.val("");

			$(".input_primeira_parcela").val("Não");
			$(".input_prev_pag").val("");
		}
	});
}

function calcularValorParcela() {
	$("#emo_quantidade_parcelas").change(function() {
		let iQuantidadeParcelas = $(this).val();
		if (iQuantidadeParcelas < 1) {
			$(".input_pag_parcelado").val("");
			return;
		}

		let fValor = getValorEmprestimo();
		let fPorcentagem = parseFloat($("#emo_taxa_juros").val());

		if (fValor > 0 && fPorcentagem > 0) {
			let fValorJuros = (fValor * (fPorcentagem / 100));
			let fValorTotal = fValor + fValorJuros;
			let fValorParcela = fValorTotal / iQuantidadeParcelas;

			$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
		} else if (fValor > 0) {
			let fValorParcela = fValor / iQuantidadeParcelas;
			$(".input_pag_parcelado").val(`${iQuantidadeParcelas}x ${fValorParcela.toLocaleString("pt-BR", { style: "currency" , currency:"BRL"})}`);
		} else {
			$(".input_pag_parcelado").val("");
		}
	})
}
