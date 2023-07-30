<div style="width: 54.5%; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
	<label>Beneficiário do Empréstimo</label><br>
	<input type="radio" checked id="pessoal" name="emo_tipo" class="emo_tipo" value="1">
	<label for="pessoal" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Pessoal</label>
	<input type="radio" id="cliente" name="emo_tipo" class="emo_tipo" value="2">
	<label for="cliente" style="color: rgba(0, 0, 0, 0.8);">Cliente</label><br>
</div>

<div id="fornecedor_emp" style="width: 54.5%; padding: 1.2rem 0;">
	<label>Fornecedor</label><br>
	<select style="width: 100%;" id="fornecedor" name="fornecedor_id" class="select_emp_data" required>
		<option selected style="display: none;" value="">Selecione o Fornecedor</option>
		<?php
		foreach ($loPessoaList as $oPessoa) {
			if ($oPessoa->isCliente()) {
				continue;
			}
			?>
			<option value="<?php echo $oPessoa->getId(); ?>"><?php echo $oPessoa->getNome(); ?></option>
		<?php } ?>
	</select>
</div>

<div id="cliente_emp" style="display: none; width: 54.5%; padding-bottom: 1.2rem;">
	<label>Cliente</label><br>
	<select style="width: 100%;" id="cliente" class="select_emp_data" name="cliente_id">
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

<div id="fornecedor_emp" style="width: 100%; padding-bottom: 1.2rem;">
	<label>Situação do Empréstimo</label><br>
	<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
	<label for="vehicle1" style="margin-right: 15px;"> Em Aberto</label>
	<input type="checkbox" id="vehicle2" name="vehicle2" value="Car">
	<label for="vehicle2" style="margin-right: 15px;"> Pago</label>
	<input type="checkbox" id="vehicle3" name="vehicle3" value="Boat">
	<label for="vehicle3"> Cancelado</label>
</div>

<div style="width: 54.5%; padding-bottom: 2rem;">
	<label>Data Emprestimo</label><br>
	<input style="width: 100%;" type="date" id="emo_data_previsao_pagamento" name="emo_data_previsao_pagamento">
</div>

