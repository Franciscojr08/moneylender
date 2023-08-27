<?php

use MoneyLender\Src\Pessoa\PessoaList;

/**
 * @var PessoaList $loFornecedorList
 * @var PessoaList $loPessoaList
 */

?>

<div id="filtro_clientes" style="display:none;" class="div_filtro">
	<div>
		<label>Cliente</label><br>
		<select style="width: 100%;" id="cliente" class="select_emp_data" name="aFiltro[rel_cliente][cliente_id]">
			<option selected style="display: none;" value="">Selecione o Cliente</option>
			<?php
			foreach ($loPessoaList as $oPessoa) {
				if ($oPessoa->isFornecedor()) {
					continue;
				}
				?>
				<option value="<?php echo $oPessoa->getId(); ?>"><?php echo $oPessoa->getNome(); ?></option>
			<?php } ?>
		</select>
	</div>

	<div style="padding-bottom: 16rem;">
		<span style="font-size: 11.5px; color: #ff0000; font-weight: 500;">Este filtro não é obrigatório, caso deseje filtrar por um cliente, selecione o mesmo no filtro acima.</span>
	</div>
</div>

<div id="filtro_fornecedores" style="display:none;" class="div_filtro">
	<div>
		<label>Fornecedor</label><br>
		<select style="width: 100%;" id="fornecedor" name="aFiltro[rel_fornecedor][fornecedor_id]" class="select_emp_data">
			<option selected style="display: none;" value="">Selecione o Fornecedor</option>
			<?php
			foreach ($loFornecedorList as $oPessoa) {
				if ($oPessoa->isCliente()) {
					continue;
				}
				?>
				<option value="<?php echo $oPessoa->getId(); ?>"><?php echo $oPessoa->getNome(); ?></option>
			<?php } ?>
		</select>
	</div>

	<div style="padding-bottom: 16rem;">
		<span style="font-size: 11.5px; color: #ff0000; font-weight: 500;">Este filtro não é obrigatório, caso deseje filtrar por um fornecedor, selecione o mesmo no filtro acima.</span>
	</div>
</div>