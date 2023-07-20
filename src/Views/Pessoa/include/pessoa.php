<?php

use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Pessoa\PessoaList;

/**
 * @var PessoaList $loPessoaList
 * @var Pessoa $oPessoa
 * @var bool $bFiltrarFornecedor
 */

$sTipoPessoa = $bFiltrarFornecedor ? "fornecedor" : "cliente";
?>

<?php if ($loPessoaList->isEmpty()) { ?>
	<tr>
		<td colspan="14">Não há <?php echo $sTipoPessoa; ?> cadastrado.</td>
	</tr>
<?php } else {
	foreach ($loPessoaList as $oPessoa) {
		if ($bFiltrarFornecedor) {
			if ($oPessoa->isCliente()) {
				continue;
			}
		} elseif ($oPessoa->isFornecedor()) {
			continue;
		}
		?>

		<tr>
			<td><?php echo $oPessoa->getId(); ?></td>
			<td><?php echo $oPessoa->getNome(); ?></td>
			<td><?php echo $oPessoa->getCPF(); ?></td>
			<td><?php echo $oPessoa->getEmail(); ?></td>
			<td><?php echo $oPessoa->getTelefone(); ?></td>
			<td><?php echo $oPessoa->isIndicado() ? "Sim" : "Não"; ?></td>
			<td><?php echo $oPessoa->isIndicado() ? $oPessoa->getNomeIndicador() : "- - -"; ?></td>
			<td><?php echo $oPessoa->hasEmprestimos() ? $oPessoa->getEmprestimos()->count() : "- - -"; ?></td>
			<td>Lápis e lixeira></td>
		</tr>
<?php } } ?>