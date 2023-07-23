<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

<script>
	$(document).ready(function () {
		$(document).ajaxStart(function() {
			$(".toggle_spinner").show();
		});

		$(document).ajaxStop(function() {
			$(".toggle_spinner").hide();
		});

		let eCPF = $(".cpf");
		let eTEL = $(".telefone");

		eCPF.mask('000.000.000-00', {reverse: false});
		eTEL.mask('(00) 00000-0000', {reverse: false});

		eTEL.on("blur", function() {
			if ($(this).val().length < 15) {
				$(this).val("");
			}
		});

		eCPF.change(function() {
			const sCPF = eCPF.val().replace(/\D/g, '');

			if (sCPF === "") {
				delMensagemCPFCadastrado();
				delMensagemCPFInvalido();

				return;
			}

			if (isCPFValido(sCPF)) {
				if ($(".msg_cpf_cadastrado").length) {
					delMensagemCPFCadastrado();
				}

				if ($(".msg_cpf_invalido").length) {
					delMensagemCPFInvalido();
				}
			} else {
				if ($(".msg_cpf_cadastrado").length) {
					delMensagemCPFCadastrado();
				}

				if (!$(".msg_cpf_invalido").length) {
					addMensagemCPFInvalido("Preencha um CPF válido.");
					return;
				}

				return;
			}

			$.ajax({
				url: "../../pessoa/verificarcpfcadastrado",
				type: "POST",
				data: {
					sCPF:sCPF,
					iTipo:$(".psa_tipo").val()
				},
				dataType: "JSON",
				success: function (json) {
					if (json.status) {
						if (!$(".msg_cpf_cadastrado").length) {
							addMensagemCPFCadastrado("Este CPF já está cadastrado.");
						}

						return;
					}

					if (json.code) {
						addMensagemCPFCadastrado(json.msg);
					} else {
						delMensagemCPFCadastrado();
					}
				}
			});
		});
	});

	function isCPFValido(sCPF) {
		if (sCPF.length !== 11) {
			return false;
		}

		let sum = 0;
		let remainder;

		for (let i = 1; i <= 9; i++) {
			sum += parseInt(sCPF.substring(i - 1, i)) * (11 - i);
		}

		remainder = (sum * 10) % 11;

		if (remainder === 10 || remainder === 11) {
			remainder = 0;
		}

		if (remainder !== parseInt(sCPF.substring(9, 10))) {
			return false;
		}

		sum = 0;

		for (let i = 1; i <= 10; i++) {
			sum += parseInt(sCPF.substring(i - 1, i)) * (12 - i);
		}

		remainder = (sum * 10) % 11;

		if (remainder === 10 || remainder === 11) {
			remainder = 0;
		}

		if (remainder !== parseInt(sCPF.substring(10, 11))) {
			return false;
		}

		return true;
	}

	function addMensagemCPFCadastrado(sMensagem) {
		let eCPF = $(".cpf");

		eCPF.after(`<p class="msg_cpf_cadastrado">${sMensagem}</p>`);
		eCPF.addClass("input_error");
		$(".btn-success").attr("disabled",true);
	}

	function delMensagemCPFCadastrado() {
		$(".msg_cpf_cadastrado").remove();
		$(".cpf").removeClass("input_error");
		$(".btn-success").attr("disabled",false);
	}

	function addMensagemCPFInvalido(sMensagem) {
		let eCPF = $(".cpf");

		eCPF.after(`<p class="msg_cpf_invalido">${sMensagem}</p>`);
		eCPF.addClass("input_error");
		$(".btn-success").attr("disabled",true);
	}

	function delMensagemCPFInvalido() {
		let eCPF = $(".cpf");

		$(".msg_cpf_invalido").remove();
		eCPF.removeClass("input_error");
		$(".btn-success").attr("disabled",false);
	}
</script>