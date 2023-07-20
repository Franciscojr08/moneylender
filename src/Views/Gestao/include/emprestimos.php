<?php

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Emprestimo\EmprestimoList;

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

		$sValorPagoDevido = "R$ " . number_format($oEmprestimo->getValorPago(),2,",",".");
		$sValorPagoDevido .= " / R$ " . number_format($oEmprestimo->getValorDevido(),2,",",".");

		if ($oEmprestimo->hasTaxaJuros()) {
			$sJuros = "{$oEmprestimo->getTaxaJuros()} % / R$ " . number_format($oEmprestimo->getValorJuros(),2,",",".");
		}

		if ($oEmprestimo->isPagamentoParcelado()) {
			$sParcelas = "{$oEmprestimo->getParcelas()->count()} / {$oEmprestimo->getParcelas()->getParcelasPagas()->count()}";
			$sDataPrevPG = $oEmprestimo->getDataPrevisaoPagamento()->format("d/m/Y");
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
			<td>Olho e plus></td>
			<td>Lápis e lixeira></td>
		</tr>
<?php } } ?>
