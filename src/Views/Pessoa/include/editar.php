<?php

use MoneyLender\Src\Pessoa\Pessoa;

/** @var Pessoa $oPessoa */
?>

<div class="modal-dialog modal-dialog-centered modal-lg">
	<div class="modal-content">
		<form type="POST" action="../../pessoa/editarPessoa">
			<input type="hidden" class="cpf_antigo" value="<?php echo $oPessoa->hasCPF() ? $oPessoa->getCPF() : ""; ?>">
			<input type="hidden" name="aPessoa[psa_id]" value="<?php echo $oPessoa->getId(); ?>">

			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Editar <?php echo $oPessoa->getDescricaoTipoPessoa(); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body cad_emp_data" style="width: 100%;">
				<div class="d-flex justify-content-between" style="padding-bottom: 1.2rem;">
					<div style="width: 50%;">
						<label>Nome</label><br>
						<input style="width: 100%" type="text" name="aPessoa[psa_nome]" placeholder="Nome" required
								value="<?php echo $oPessoa->getNome(); ?>">
					</div>

					<div>
						<label>CPF</label><br>
						<input type="text" class="cpf_edicao" name="aPessoa[psa_cpf]" placeholder="CPF" maxlength="14"
								value="<?php echo $oPessoa->hasCPF() ? $oPessoa->getCPF() : ""; ?>">
					</div>
				</div>

				<div class="d-flex justify-content-between" style="padding-bottom: 1.2rem;">
					<div style="width: 50%;">
						<label>Logradouro</label><br>
						<input style="width: 100%" type="text" name="aPessoa[psa_logradouro]" placeholder="Logradouro"
								value="<?php echo $oPessoa->hasLogradouro() ? $oPessoa->getLogradouro() : ""; ?>">
					</div>

					<div>
						<label>Bairro</label><br>
						<input type="text" name="aPessoa[psa_bairro]" placeholder="Bairro"
								value="<?php echo $oPessoa->hasBairro() ? $oPessoa->getBairro() : ""; ?>">
					</div>
				</div>

				<div class="d-flex" style="padding-bottom: 1.2rem;">
					<div style="width: 22.5%;">
						<label>Cidade</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_cidade]" placeholder="Cidade"
								value="<?php echo $oPessoa->hasCidade() ? $oPessoa->getCidade() : ""; ?>">
					</div>

					<div style="width: 22.5%; margin-left: 5%">
						<label>Estado</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_estado]" placeholder="Estado"
								value="<?php echo $oPessoa->hasEstado() ? $oPessoa->getEstado() : ""; ?>">
					</div>

					<div style="width: 34%; margin-left: 16%">
						<label>Complemento</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_complemento]"
								placeholder="Complemento"
								value="<?php echo $oPessoa->hasComplemento() ? $oPessoa->getComplemento() : ""; ?>">
					</div>
				</div>

				<div class="d-flex justify-content-between" style="padding-bottom: 1.2rem;">
					<div style="width: 50%;">
						<label>E-mail</label><br>
						<input style="width: 100%" type="email" name="aPessoa[psa_email]" placeholder="E-mail"
								value="<?php echo $oPessoa->hasEmail() ? $oPessoa->getEmail() : ""; ?>">
					</div>

					<div>
						<label>Telefone</label><br>
						<input type="text" class="telefone_edicao" name="aPessoa[psa_telefone]" placeholder="Telefone"
								value="<?php echo $oPessoa->hasTelefone() ? $oPessoa->getTelefone() : ""; ?>">
					</div>
				</div>

				<div class="d-flex">
					<div style="width: 22.5%; border: none; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
						<label>Indicado</label><br>
						<input type="radio" <?php echo $oPessoa->isIndicado() ? "checked" : ""; ?> id="sim_edicao"
								name="aPessoa[psa_indicado]" class="psa_indicado_edit" value="1">
						<label for="sim_edicao" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Sim</label>
						<input type="radio" <?php echo $oPessoa->isIndicado() ? "" : "checked"; ?> id="nao_edicao"
								name="aPessoa[psa_indicado]" class="psa_indicado_edit" value="2">
						<label for="nao_edicao" style="color: rgba(0, 0, 0, 0.8);">Não</label><br>
					</div>

					<div id="div_indicador_edit"
						 style="width: 73%; margin-left: 5%; display: <?php echo $oPessoa->isIndicado() ? "block" : "none"; ?>">
						<label>Nome Indicador</label><br>
						<input style="width: 100%;" type="text" class="nome_indicador_antigo"
								name="aPessoa[psa_nome_indicador]" placeholder="Nome Indicador"
								value="<?php echo $oPessoa->isIndicado() ? $oPessoa->getNomeIndicador() : ""; ?> ">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Atualizar</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript"
		src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.0/jquery.mask.js"></script>

<script>
	$(document).ready(function () {
		$(document).ajaxStart(function () {
			$(".toggle_spinner").show();
		});

		$(document).ajaxStop(function () {
			$(".toggle_spinner").hide();
		});

		const sCPFAntigo = $(".cpf_antigo").val();
		const sIndicadorAntigo = $(".nome_indicador_antigo").val();

		let eCPF = $(".cpf_edicao");
		let eTEL = $(".telefone_edicao");

		eCPF.mask('000.000.000-00', {reverse: false});
		eTEL.mask('(00) 00000-0000', {reverse: false});

		eTEL.on("blur", function () {
			if ($(this).val().length < 15) {
				$(this).val("");
			}
		});

		$(".psa_indicado_edit").on("change", function () {
			const SIM = 1;
			const NAO = 2;

			let iIndicado = $(this).val();
			let eDiv = $("#div_indicador_edit");

			if (parseInt(iIndicado) === SIM) {
				eDiv.show().find("input").attr("required", true);
				eDiv.find("input").val(sIndicadorAntigo);
			} else if (parseInt(iIndicado) === NAO) {
				eDiv.hide().find("input").attr("required", false);
				eDiv.find("input").val("");
			}
		});

		eCPF.change(function () {
			const sCPF = eCPF.val().replace(/\D/g, '');

			if (sCPF === "" || sCPF === sCPFAntigo) {
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
					sCPF: sCPF,
					iTipo: $(".psa_tipo").val()
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
		let eCPF = $(".cpf_edicao");

		eCPF.after(`<p class="msg_cpf_cadastrado">${sMensagem}</p>`);
		eCPF.addClass("input_error");
		$(".btn-success").attr("disabled", true);
	}

	function delMensagemCPFCadastrado() {
		$(".msg_cpf_cadastrado").remove();
		$(".cpf_edicao").removeClass("input_error");
		$(".btn-success").attr("disabled", false);
	}

	function addMensagemCPFInvalido(sMensagem) {
		let eCPF = $(".cpf_edicao");

		eCPF.after(`<p class="msg_cpf_invalido">${sMensagem}</p>`);
		eCPF.addClass("input_error");
		$(".btn-success").attr("disabled", true);
	}

	function delMensagemCPFInvalido() {
		$(".msg_cpf_invalido").remove();
		$(".cpf_edicao").removeClass("input_error");
		$(".btn-success").attr("disabled", false);
	}
</script>
