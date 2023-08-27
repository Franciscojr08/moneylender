<?php

use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Pessoa\PessoaList;

/**
 * @var PessoaList $loPessoaList
 * @var PessoaList $loFornecedorList
 * @var Pessoa $oPessoa
 */

?>
<div style="width: 54.5%; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
	<label>Tipo Pessoa</label><br>
	<input type="radio" checked id="filtro_pessoa_nao" name="aFiltro[rel_pessoa][psa_tipo]" class="emo_tipo_pessoa" value="1">
	<label for="filtro_pessoa_nao" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Cliente</label>
	<input type="radio" id="filtro_pessoa_sim" name="aFiltro[rel_pessoa][psa_tipo]" class="emo_tipo_pessoa" value="2">
	<label for="filtro_pessoa_sim" style="color: rgba(0, 0, 0, 0.8);">Fornecedor</label><br>
</div>

<div id="pessoa_cliente" style="width: 54.5%; padding: 1.2rem 0;">
	<label>Cliente</label><br>
	<select style="width: 100%;" class="select_emp_data" name="aFiltro[rel_pessoa][cliente_id]">
		<option selected style="display: none;" value="">Selecione o Cliente</option>
		<?php
		foreach ($loPessoaList as $oPessoa) {
			if (!$oPessoa->hasCPF() || $oPessoa->isFornecedor()) {
				continue;
			}
			?>
			<option value="<?php echo $oPessoa->getId(); ?>"><?php echo $oPessoa->getNome(); ?></option>
		<?php } ?>
	</select>
</div>

<div id="pessoa_fornecedor" style="display: none; width: 54.5%; padding: 1.2rem 0;">
	<label>Fornecedor</label><br>
	<select style="width: 100%;" class="select_emp_data" name="aFiltro[rel_pessoa][fornecedor_id]">
		<option selected style="display: none;" value="">Selecione o Fornecedor</option>
		<?php
		foreach ($loFornecedorList as $oPessoa) {
			if (!$oPessoa->hasCPF() || $oPessoa->isCliente()) {
				continue;
			}
			?>
			<option value="<?php echo $oPessoa->getId(); ?>"><?php echo $oPessoa->getNome(); ?></option>
		<?php } ?>
	</select>
</div>