<?php

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Emprestimo\EmprestimoList;

/**
 * @var EmprestimoList $loEmprestimos
 * @var Emprestimo $oEmprestimo
 */

?>

<?php if ($loEmprestimos->isEmpty()) { ?>
	<tr>
		<td colspan="14">Não há empréstimo cadastrado.</td>
	</tr>
<?php } else {
	foreach ($loEmprestimos as $oEmprestimo) { ?>
		<tr>
			<td><?php echo $oEmprestimo->getId(); ?></td>
			<td><?php echo $oEmprestimo->getDataEmprestimo()->format("d/m/Y"); ?></td>
			<td><?php echo $oEmprestimo->getCliente()->getNome(); ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValor(),2,",","."); ?></td>
			<td><?php echo "{$oEmprestimo->getTaxaJuros()} %"; ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValorJuros(),2,",","."); ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValorComJuros(),2,",","."); ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValorPago(),2,",","."); ?></td>
			<td><?php echo "R$ " . number_format($oEmprestimo->getValorDevido(),2,",","."); ?></td>
			<td><?php echo $oEmprestimo->isPagamentoParcelado() ? $oEmprestimo->getParcelas()->count() : "- - -"; ?></td>
			<td><?php echo $oEmprestimo->isPagamentoParcelado() ? $oEmprestimo->getParcelas()->getParcelasPagas()->count() : "- - -"; ?></td>
			<td><?php echo $oEmprestimo->getDescricaoSituacao(); ?></td>
			<td><?php echo $oEmprestimo->isPagamentoParcelado() ? "- - -" : $oEmprestimo->getDataPrevisaoPagamento()->format("d/m/Y"); ?></td>
			<td>Olho e plus></td>
		</tr>
<?php } } ?>
