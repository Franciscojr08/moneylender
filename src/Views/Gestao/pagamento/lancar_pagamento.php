<?php

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Sistema\Enum\FormaPagamentoEnum;

/**
 * @var Emprestimo $oEmprestimo
 * @var string $sDescricaoPessoa
 */

$sAcao = $sDescricaoPessoa == "Fornecedor" ? "pessoal" : "cliente";
?>

<div class="modal-dialog modal-dialog-centered modal-xl">
	<input type="hidden" class="valor_devido" value="<?php echo $oEmprestimo->getValorDevido(); ?>">

	<div class="modal-content">
		<form type="POST" action="../gestao/lancarPagamento">
			<input type="hidden" name="emo_id" value="<?php echo $oEmprestimo->getId(); ?>">
			<input type="hidden" name="sUrl" value="<?php echo $sAcao; ?>">

			<div class="modal-header">
				<h5 class="modal-title" id="">Lançar Pagamentos</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" style="width: 100%;">
				<div class="modal_pagamento">
					<label style="padding-bottom: 10px">Realizar Pagamento do Empréstimo</label><br>
				</div>
				<div>
					<table class="table table-striped table_pag" style="margin-top: 1rem; margin-bottom: 0 !important;">
						<thead>
						<tr class="table-dark">
							<th scope="col">Cód</th>
							<th scope="col"><?php echo $sDescricaoPessoa; ?></th>
							<th scope="col">Valor Devido</th>
							<th scope="col">Valor Pago</th>
							<th scope="col">Vencimento</th>
							<th scope="col">Valor a Pagar</th>
							<th scope="col">Forma Pagamento</th>
							<th scope="col"><i class="fa-solid fa-money-bill-wave fa-xl"></i></th>
						</tr>
						</thead>
						<tbody>
						<tr>
							<td><?php echo $oEmprestimo->getId(); ?></td>
							<td><?php echo $oEmprestimo->getPessoa()->getNome(); ?></td>
							<td><?php echo "R$ " . number_format($oEmprestimo->getValorDevido(),2,",","."); ?></td>
							<td><?php echo "R$ " . number_format($oEmprestimo->getValorPago(),2,",","."); ?></td>
							<td><?php echo $oEmprestimo->getDataPrevisaoPagamento()->format("d/m/Y"); ?></td>
							<td width="20%"><input name="pgo_valor" id="valor_pagamento" style="width: 100%; border: 1px solid #aaa;" type="text" min="0" step="0.01" required></td>
							<td>
								<select class="select_emp_data" name="pgo_forma_pagamento" required>
									<option selected style="display: none;" value="">Forma de Pagamento</option>
									<?php foreach (FormaPagamentoEnum::getValores() as $aValores) { ?>
										<option value="<?php echo $aValores['valor']; ?>"><?php echo $aValores['descricao']; ?></option>
									<?php } ?>
							</td>
							<td><button style="padding: 4px 15px;" type="submit" class="btn btn-secondary btn_pag">Pagar</button></td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="modal-footer footer_pag" style="margin-left: 2%; justify-content: flex-start;"></div>
		</form>
	</div>
</div>

<script>
	$(document).ready(function () {
		$('#valor_pagamento').maskMoney({
			prefix: "R$ ",
			decimal: ",",
			thousands: "."
		});

		$("#valor_pagamento").change(function() {
			const VALOR_DEVIDO = $(".valor_devido").val();
			let VALOR = $(this).val().replace(/R\$\s*/, '');
			VALOR = VALOR.replace(/\./g, '');
			VALOR = VALOR.replace(',', '.');
			VALOR = parseFloat(VALOR);
			console.log(VALOR);

			if (VALOR < VALOR_DEVIDO) {
				addMensagem("ATENÇÃO! O Valor a ser pago está abaixo do valor devido, o empréstimo não será pago totalmente.", false)
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
				$(".footer_pag").html(`<p class="mensagem_error">${sMensagem}</p>`);
				$("#valor_pagamento").addClass("input_error");
				$(".btn_pag").attr("disabled",true);
			} else {
				$(".footer_pag").html(`<p class="mensagem_error">${sMensagem}</p>`);
			}
		}

		function removeMensagem() {
			$(".mensagem_error").remove();
			$("#valor_pagamento").removeClass("input_error");
			$(".btn_pag").attr("disabled",false);
		}
	});
</script>