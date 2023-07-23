$(document).ready(function() {
	$(document).ajaxStart(function() {
		$(".toggle_spinner").show();
	});

	$(document).ajaxStop(function() {
		$(".toggle_spinner").hide();
	});

	carregarPessoas();

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