<?php

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;

/**
 * @var EmprestimoList $loEmprestimos
 * @var Emprestimo $oEmprestimo
 * @var bool $bFiltrarFornecedor
 */

?>

<?php if ($loEmprestimos->isEmpty()) { ?>
	<tr>
		<td colspan="13">Não há empréstimo cadastrado.</td>
	</tr>
<?php } else {
	foreach ($loEmprestimos as $oEmprestimo) {
		$oPessoa = $oEmprestimo->getPessoa();
		if ($bFiltrarFornecedor) {
			if ($oPessoa->isCliente()) {
				continue;
			}
		} elseif ($oPessoa->isFornecedor()) {
			continue;
		}

		$sDataAtualizacao = $oEmprestimo->hasAtualizacao() ? $oEmprestimo->getDataAtualizacao()->format("d/m/Y") : "- - -";
		$sJuros = "- - -";
		$sParcelas = "- - -";
		$sDataPrevPG = "- - -";
		$bExibirBotaoCancelar = !in_array($oEmprestimo->getSituacaoId(), [SituacaoEmprestimoEnum::PAGO,SituacaoEmprestimoEnum::CANCELADO]);

		$sValorPagoDevido = "R$ " . number_format($oEmprestimo->getValorDevido(),2,",",".");
		$sValorPagoDevido .= " / R$ " . number_format($oEmprestimo->getValorPago(),2,",",".");

		if ($oEmprestimo->hasTaxaJuros()) {
			$sJuros = "{$oEmprestimo->getTaxaJuros()} % / R$ " . number_format($oEmprestimo->getValorJuros(),2,",",".");
		}

		if ($oEmprestimo->getSituacaoId() != SituacaoEmprestimoEnum::CANCELADO) {
			if ($oEmprestimo->isPagamentoParcelado()) {
				$sParcelas = "{$oEmprestimo->getParcelas()->count()} / {$oEmprestimo->getParcelas()->getParcelasPagas()->count()}";
			} else {
				$sDataPrevPG = $oEmprestimo->getDataPrevisaoPagamento()->format("d/m/Y");
			}
			
		}

		try {
			$sDescricao = $oEmprestimo->getDescricaoSituacao();
		} catch (Exception $oExp) {
			$sDescricao = "- - -";
		}
		?>
		<tr>
			<td><?php echo $oEmprestimo->getId(); ?></td>
			<td><?php echo $oEmprestimo->getDataEmprestimo()->format("d/m/Y"); ?></td>
			<td><?php echo $sDataAtualizacao; ?></td>
			<td><?php echo $oEmprestimo->getPessoa()->getNome(); ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValor(),2,",","."); ?></td>
			<td><?php echo $sJuros; ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValorComJuros(),2,",","."); ?></td>
			<td><?php echo $sValorPagoDevido; ?></td>
			<td><?php echo $sParcelas; ?></td>
			<td><?php echo $sDescricao; ?></td>
			<td><?php echo $sDataPrevPG; ?></td>
			<td>
				<?php if ($oEmprestimo->getSituacaoId() != SituacaoEmprestimoEnum::CANCELADO) { ?>
					<a class="icon_acao btn_visualizar_pagamento" data-target="<?php echo $oEmprestimo->getId(); ?>" title="Visualizar">
						<i class="fa-solid fa-eye fa-lg" style="margin-right: 5px;"></i>
					</a>
					
					<?php if ($oEmprestimo->getSituacaoId() != SituacaoEmprestimoEnum::PAGO) { ?>
						<a class="icon_acao btn_lancar_pagamento" data-target="<?php echo $oEmprestimo->getId(); ?>" title="Lançar Pagamento">
							<i class="fa-solid fa-circle-plus fa-lg"></i>
						</a>
					<?php } ?>
				<?php } ?>
			</td>
			<td>
				<?php if ($bExibirBotaoCancelar) { ?>
					<a class="icon_acao btn_cancelar_emprestimo" data-target="<?php echo $oEmprestimo->getId(); ?>" title="Cancelar">
						<i class="fa-solid fa-ban fa-lg" style="margin-right: 5px;"></i>
					</a>
				<?php } ?>

				<a class="icon_acao excluir btn_excluir_emprestimo" data-target="<?php echo $oEmprestimo->getId(); ?>" title="Excluir">
					<i class="fa-solid fa-trash fa-lg"></i>
				</a>
			</td>
		</tr>
<?php } } ?>
