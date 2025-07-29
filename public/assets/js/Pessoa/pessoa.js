$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	carregarPessoas();
	changeCampoIndicado();
	modalEditarPessoa();
	modalExcluirPessoa();
	changeCampoIndicadoFiltro();
	filtrarPessoaAjax();
	limparFiltroPessoa();
})

function carregarPessoas() {
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

function changeCampoIndicado() {
	$(".psa_indicado").on("change",function() {
		const SIM= 1;
		const NAO = 2;
		let iIndicado = $(this).val();

		if (parseInt(iIndicado) === SIM) {
			$("#div_indicador").show().find("input").attr("required",true);
		} else if (parseInt(iIndicado) === NAO) {
			$("#div_indicador").hide().find("input").attr("required",false);
		}
	});
}

function modalEditarPessoa() {
	$(".tabela_pessoa tbody").on("click", ".btn_editar_pessoa", function() {
		let iPsaId = $(this).data("target");

		$.ajax({
			url: "../../pessoa/modalEditarPessoa",
			type: "POST",
			dataType: "html",
			data: {iPsaId:iPsaId},
			success: function (html) {
				$("#modalEditarPessoa").html(html).modal("show");
			}
		});
	});
}

function modalExcluirPessoa() {
	$(".tabela_pessoa tbody").on("click", ".btn_excluir_pessoa", function() {
		let iPsaId = $(this).data("target");

		$.ajax({
			url: "../../pessoa/modalExcluirPessoa",
			type: "POST",
			dataType: "html",
			data: {iPsaId:iPsaId},
			success: function (html) {
				$("#modalExcluirPessoa").html(html).modal("show");
			}
		});
	});
}

function filtrarPessoaAjax() {
	$(".btn_filtrar_pessoa").click(function() {
		const SIM = 1;
		let iPsaId = $(".psa_id_filtro").val();
		let sDataCadastro = $(".psa_data_cadastro_filtro").val();
		let iEmprestimo = $(".psa_filtro_emprestimo:checked").val();
		let iIndicado = $(".psa_filtro_indicado:checked").val();
		let sNomeIndicador = $(".psa_filtro_nome_indicador").val();

		let aFiltro = {
			iPsaId: iPsaId,
			sDataCadastro: sDataCadastro,
			iEmprestimo: iEmprestimo,
			iIndicado: iIndicado,
			sNomeIndicador: sNomeIndicador
		}

		if (parseInt(iIndicado) === SIM && sNomeIndicador === "") {
			let eToast = $("#liveToast");
			let Toast = new bootstrap.Toast(eToast)
			Toast.show();
			return;
		}

		$.ajax({
			url: "../pessoa/pessoaAjax",
			data: {
				aFiltro:aFiltro,
				sUrl: window.location.href
			},
			type: "POST",
			dataType: "HTML",
			success: function (html) {
				$(".tabela_pessoa tbody").html("");
				$(".tabela_pessoa tbody").html(html);
			}
		});
	});
}

function changeCampoIndicadoFiltro() {
	$(".psa_filtro_indicado").on("change",function() {
		const SIM= 1;
		const NAO = 2;
		let iIndicado = $(this).val();
		let eDiv = $(".psa_filtro_nome_indicador");

		if (parseInt(iIndicado) === SIM) {
			eDiv.attr("required",true);
			eDiv.attr("disabled",false);
			eDiv.val("");
		} else if (parseInt(iIndicado) === NAO) {
			eDiv.attr("required",true);
			eDiv.attr("disabled",true);
			eDiv.val("");
		}
	});
}

function limparFiltroPessoa() {
	$(".btn_limpar_filtro_pessoa").click(function() {
		$(".psa_id_filtro option:first").prop("selected",true);
		$(".psa_data_cadastro_filtro").val("");
		$(".psa_filtro_emprestimo:checked").prop("checked",false);
		$(".psa_filtro_indicado:checked").prop("checked",false);
		$(".psa_filtro_nome_indicador").val("");

		carregarPessoas();
	});
}
