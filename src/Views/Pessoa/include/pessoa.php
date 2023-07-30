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
			<td><?php echo $oPessoa->hasCPF() ? $oPessoa->getCPFComMascara() : "- - -"; ?></td>
			<td><?php echo $oPessoa->hasEmail() ? $oPessoa->getEmail() : "- - -"; ?></td>
			<td><?php echo $oPessoa->hasTelefone() ? $oPessoa->getTelefoneComMascara() : "- - -"; ?></td>
			<td><?php echo $oPessoa->isIndicado() ? "Sim" : "Não"; ?></td>
			<td><?php echo $oPessoa->isIndicado() ? $oPessoa->getNomeIndicador() : "- - -"; ?></td>
			<td><?php echo $oPessoa->hasEmprestimos() ? $oPessoa->getEmprestimos()->count() : "Não"; ?></td>
			<td><?php echo $oPessoa->getDataCadastro()->format("d/m/Y"); ?></td>
			<td><?php echo $oPessoa->hasAtualizacao() ? $oPessoa->getDataAtualizacao()->format("d/m/Y") : "- - -"; ?></td>
			<td>
				<a class="icon_acao editar btn_editar_pessoa" data-target="<?php echo $oPessoa->getId(); ?>" title="Editar">
					<i class="fa-solid fa-pen-to-square fa-lg" style="margin-right: 5px;"></i>
				</a>

				<a class="icon_acao excluir btn_excluir_pessoa" data-target="<?php echo $oPessoa->getId(); ?>" title="Excluir">
					<i class="fa-solid fa-trash fa-lg"></i>
				</a>
			</td>
		</tr>
<?php } } ?>