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
	<label>Beneficiário do Empréstimo</label><br>
	<input type="radio" checked id="filtro_recibo_nao" name="filtro_recibo_pessoa" class="emo_tipo_pessoa_recibo" value="1">
	<label for="filtro_recibo_nao" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Cliente</label>
	<input type="radio" id="filtro_recibo_sim" name="filtro_recibo_pessoa" class="emo_tipo_pessoa_recibo" value="2">
	<label for="filtro_recibo_sim" style="color: rgba(0, 0, 0, 0.8);">Pessoal</label><br>
</div>

<div id="recibo_cliente" style="width: 54.5%; padding: 1.2rem 0;">
	<label>Cliente</label><br>
	<select style="width: 100%;" id="filtro_recibo_cliente" class="select_emp_data" name="cliente_id" required>
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

<div id="recibo_fornecedor" style="display: none; width: 54.5%; padding: 1.2rem 0;">
	<label>Fornecedor</label><br>
	<select style="width: 100%;" id="filtro_recibo_fornecedor" class="select_emp_data">
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

<div id="fornecedor_emp" style="width: 54.5%; padding-bottom: 6.9rem;">
	<label>Empréstimo</label><br>
	<select style="width: 100%;" id="filtro_recibo_emprestimo" name="filtro_recibo_emprestimo" class="select_emp_data" required>
		<option selected style="display: none;" value="">Selecione o Empréstimo</option>
	</select>
</div>
