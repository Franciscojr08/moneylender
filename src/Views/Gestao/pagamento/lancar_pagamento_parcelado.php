<?php

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Parcela\ParcelaList;
use MoneyLender\Src\Sistema\Enum\FormaPagamentoEnum;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;

/**
 * @var Emprestimo $oEmprestimo
 * @var ParcelaList $loParcelas
 * @var Parcela $oParcela
 */
?>

<div class="modal-dialog modal-dialog-centered modal-xl">
	<input type="hidden" class="valor_devido_parcelado" value="<?php echo $oEmprestimo->getValorDevido(); ?>">

	<div class="modal-content">
		<form type="POST" action="../gestao/lancarPagamento">
			<input type="hidden" name="emo_id" value="<?php echo $oEmprestimo->getId(); ?>">
			<div class="modal-header">
				<h5 class="modal-title" id="">Lançar Pagamentos</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" style="width: 100%;">
				<div style="    margin-left: 2%;
    border-bottom: 1px solid #aaa;
    width: 96%;
    font-weight: bold;
    font-style: italic;
    box-shadow: 0px 2px 0px #f57449;">
					<label style="padding-bottom: 10px">Realizar Pagamento da Parcela</label><br>
				</div>
				<div>
					<table class="table table-striped table_pag" style="margin-top: 1rem; margin-bottom: 0 !important;">
						<thead>
						<tr class="table-dark">
							<th scope="col">Emp.</th>
							<th scope="col">Parcela</th>
							<th scope="col">Cliente</th>
							<th scope="col">Devido</th>
							<th scope="col">Pago</th>
							<th scope="col">Vencimento</th>
							<th scope="col">Valor a Pagar</th>
							<th scope="col">Forma Pagamento</th>
							<th scope="col"><i class="fa-solid fa-money-bill-wave fa-xl"></i></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?php echo $oEmprestimo->getId(); ?></td>
							<td width="16%">
								<select class="select_emp_data pagamento_parcela" name="pra_id" required>
									<option selected style="display: none;" value="">Parcela</option>
									<?php foreach ($loParcelas->getComboNaoPagas() as $aValores) { ?>
										<option value="<?php echo $aValores['valor']; ?>"><?php echo $aValores['descricao']; ?></option>
									<?php } ?>
								</select>
							</td>
							<td><?php echo $oEmprestimo->getPessoa()->getNome(); ?></td>
							<td><span id="valor_devido_parcela">- - -</span></td>
							<td><span id="valor_pago_parcela">- - -</span></td>
							<td><span id="vencimento_parcela">- - -</span></td>
							<td width="15%"><input disabled name="pgo_valor" class="valor_pagamento_parcelado" style="width: 100%; border: 1px solid #aaa;" type="text" min="0" step="0.01" required></td>
							<td>
								<select class="select_emp_data" name="pgo_forma_pagamento" required>
									<option selected style="display: none;" value="">Forma de Pagamento</option>
									<?php foreach (FormaPagamentoEnum::getValores() as $aValores) { ?>
										<option value="<?php echo $aValores['valor']; ?>"><?php echo $aValores['descricao']; ?></option>
									<?php } ?>
							</td>
							<td><button disabled style="padding: 4px 15px;" type="submit" class="btn btn-secondary btn_pag_parcelado">Pagar</button></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer footer_pag_parcelado" style="margin-left: 2%; justify-content: flex-start;"></div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('.valor_pagamento_parcelado').maskMoney({
			prefix: "R$ ",
			decimal: ",",
			thousands: "."
		});

		$(".pagamento_parcela").change(function() {
			let iPraId = $(this).val();
			$.ajax({
				url: "../gestao/consultarInformacoesParcela",
				type: "POST",
				data: {iPraId:iPraId},
				dataType: "json",
				success: function (json) {
					if (json.status) {
						$("#valor_devido_parcela").text(`R$ ${json.valor_devido_parcela}`);
						$("#valor_pago_parcela").text(`R$ ${json.valor_pago_parcela}`);
						$("#vencimento_parcela").text(json.vencimento_parcela);
						removeMensagem();
						$(".valor_pagamento_parcelado").attr("disabled",false);
						$(".btn_pag_parcelado").attr("disabled",false);
					} else {
						addMensagem(json.msg);
						$(".valor_pagamento_parcelado").attr("disabled",true);
						$(".btn_pag_parcelado").attr("disabled",true);
					}
				}
			});
		})

		$(".valor_pagamento_parcelado").change(function() {
			let VALOR_DEVIDO = $("#valor_devido_parcela").text().replace(/R\$\s*/, '');
			VALOR_DEVIDO = VALOR_DEVIDO.replace(/\./g, '');
			VALOR_DEVIDO = VALOR_DEVIDO.replace(',', '.');
			VALOR_DEVIDO = parseFloat(VALOR_DEVIDO);

			let VALOR = $(this).val().replace(/R\$\s*/, '');
			VALOR = VALOR.replace(/\./g, '');
			VALOR = VALOR.replace(',', '.');
			VALOR = parseFloat(VALOR);
			console.log(VALOR_DEVIDO);

			if (VALOR < VALOR_DEVIDO) {
				addMensagem("ATENÇÃO! O Valor a ser pago está abaixo do valor devido, a parcela não será paga totalmente.", false)
			} else if (VALOR > VALOR_DEVIDO) {
				addMensagem("ATENÇÃO! O valor a ser pago está acima do valor devido, não é possível realizar o pagamento.", true)
			} else if (isNaN(VALOR)) {
				addMensagem("ATENÇÃO! Preencha o valor a ser pago.", true)
			}
			else {
				removeMensagem()
			}
		});

		function addMensagem(sMensagem, bBloquear) {
			removeMensagem();

			if (bBloquear) {
				$(".footer_pag_parcelado").html(`<p class="mensagem_error">${sMensagem}</p>`);
				$(".valor_pagamento_parcelado").addClass("input_error");
				$(".btn_pag_parcelado").attr("disabled",true);
			} else {
				$(".footer_pag_parcelado").html(`<p class="mensagem_error">${sMensagem}</p>`);
			}
		}

		function removeMensagem() {
			$(".mensagem_error").remove();
			$(".valor_pagamento_parcelado").removeClass("input_error");
			$(".btn_pag_parcelado").attr("disabled",false);
		}
	});
</script>