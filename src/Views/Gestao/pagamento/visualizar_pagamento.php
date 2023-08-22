<?php

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Pagamento\Pagamento;
use MoneyLender\Src\Pagamento\PagamentoList;

/**
 * @var Pagamento $oPagamento
 * @var PagamentoList $loPagamentoList
 * @var Emprestimo $oEmprestimo
 * @var string $sDescricaoPessoa
 */

$fTotalPago = 0.0;
?>

<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="">Pagamentos Realizados</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body" style="width: 100%;">
			<div class="modal_pagamento">
				<label style="padding-bottom: 10px">Pagamentos Lançados Para o Empréstimo</label><br>
			</div>
			<div>
				<table class="table table-striped table_pag" style="margin-top: 1rem; margin-bottom: 0 !important;">
					<thead>
						<tr class="table-dark">
							<th scope="col">Cód Emp.</th>
							<th scope="col">Cód Pag.</th>
							<th scope="col"><?php echo $sDescricaoPessoa; ?></th>
							<th scope="col">Valor</th>
							<th scope="col">Data Pagamento</th>
							<th scope="col">Forma Pagamento</th>
						</tr>
					</thead>
					<tbody>
						<?php
							if ($loPagamentoList->isEmpty()) { ?>
								<tr>
									<td colspan="6">Não há pagamentos lançados para o empréstimo.</td>
								</tr>
						<?php }	else { foreach ($loPagamentoList as $oPagamento) {
								$fTotalPago += $oPagamento->getValor();
						?>
							<tr>
								<td><?php echo $oEmprestimo->getId(); ?></td>
								<td><?php echo $oPagamento->getId(); ?></td>
								<td><?php echo $oEmprestimo->getPessoa()->getNome(); ?></td>
								<td><?php echo "R$ " . number_format($oPagamento->getValor(),2,",","."); ?></td>
								<td><?php echo $oPagamento->getDataPagamento()->format("d/m/Y"); ?></td>
								<td><?php echo $oPagamento->getDescricaoFormaPagamento(); ?></td>
							</tr>
						<?php } } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="modal-footer footer_pag" style="margin-left: 2%; justify-content: flex-start;">
			<p><b>Total valor pago: R$ <?php echo number_format($fTotalPago,2,",","."); ?></b></p>
		</div>
	</div>
</div>
