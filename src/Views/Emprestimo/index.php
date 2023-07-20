<?php

use MoneyLender\Core\Functions;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Pessoa\PessoaList;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;

/**
 * @var PessoaList $loPessoaList
 * @var Pessoa $oPessoa
 */

?>

<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">

	<title>Controle de Empréstimos</title>
	<?php
	Functions::addFavicon();
	Functions::addStyleSheet(["css/style.css"]);
	?>
</head>
<body>
<?php Functions::renderMenu(); ?>

<div class="content_cad_emprestimo">
	<div class="cad_emp_info">
		<h3>Lançamento</h3>
		<p class="mb-4">Cadastre um empréstimo pessoal ou para um cliente.</p>

		<h6>Beneficiário do Empréstimo</h6>
		<input type="radio" checked id="pessoal" name="emo_tipo" class="emo_tipo" value="1">
		<label for="pessoal" style="color: #fff; margin-right: 15px">Pessoal</label>
		<input type="radio" id="cliente" name="emo_tipo" class="emo_tipo" value="2">
		<label for="cliente" style="color: #fff;">Cliente</label><br>

		<h6 style="padding-top: 2rem;">Resumo do Empréstimo</h6>
		<div>
			<label class="label_emp_info">DT Empréstimo</label>
			<input class="input_emp_info input_data_emp" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info" id="label_pessoa">Fornecedor</label>
			<input class="input_emp_info input_pessoa" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info">Juros</label>
			<input class="input_emp_info input_juros" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info">Valor Juros</label>
			<input class="input_emp_info input_valor_juros" id="input_info_valor_juros" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info">Parcelado</label>
			<input class="input_emp_info input_pag_parcelado" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info">1º Parcela</label>
			<input class="input_emp_info input_primeira_parcela" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info">Prev. Pagamento</label>
			<input class="input_emp_info input_prev_pag" type="text" disabled>
		</div>

		<div>
			<label class="label_emp_info" style="font-weight: bold;">Valor Total</label>
			<input class="input_emp_info input_valor_total" style="font-weight: bold;" type="text" disabled>
		</div>
	</div>

	<div class="cad_emp_data">
		<h3>Informações do Empréstimo</h3>
		<p class="mb-4">Todos os campos são obrigatórios.</p>

		<form type="post" action="../emprestimo/cadastrar">
			<input type="hidden" id="emo_tipo" name="emo_tipo" value="1">
			<div class="div_emp_data">
				<div id="fornecedor_emp" style="width: 54.5%;">
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

				<div id="cliente_emp" style="display: none; width: 54.5%;">
					<label>Cliente</label><br>
					<select  style="width: 100%;" id="cliente" class="select_emp_data" name="cliente_id">
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

				<div style="width: 40.5%;  margin-left: 5%">
					<label>Valor</label><br>
					<input style="width: 100%;" type="text" min="0" id="emo_valor" name="emo_valor" placeholder="Valor" required>
				</div>
			</div>

			<div class="div_emp_data">
				<div style="width: 18.2%;">
					<label>Juros</label><br>
						<select class="select_emp_data" id="juros_emp" >
						<?php foreach (SimNaoEnum::getValores() as $aValores) { ?>
							<option value="<?php echo $aValores['valor']; ?>"><?php echo $aValores['descricao']; ?></option>
						<?php } ?>
					</select>
				</div>

				<div style="width: 32%; margin-left: 4%">
					<label>Taxa Juros</label><br>
					<input style="width: 100%;" type="number" min="0" id="emo_taxa_juros" name="emo_taxa_juros" placeholder="Taxa" required>
				</div>

				<div style="width: 40.5%; margin-left: 5%">
					<label>Valor Juros</label><br>
					<input style="width: 100%;" type="text" class="input_valor_juros" disabled placeholder="Valor Juros">
				</div>
			</div>

			<div class="div_emp_data">
				<div style="width: 18.2%;">
					<label>Parcelado</label><br>
					<select class="select_emp_data" id="pagamento_emp" name="emo_pagamento_parcelado">
						<?php foreach (SimNaoEnum::getValores() as $aValores) { ?>
							<option value="<?php echo $aValores['valor']; ?>"><?php echo $aValores['descricao']; ?></option>
						<?php } ?>
					</select>
				</div>

				<div style="width: 32%; margin-left: 4%">
					<label>QTD Parcelas</label><br>
					<input style="width: 100%;" type="number" min="1" id="emo_quantidade_parcelas" name="emo_quantidade_parcelas" placeholder="Parcelas" required>
				</div>

				<div style="width: 40.5%; margin-left: 5%">
					<label>Primeira Parcela</label><br>
					<input style="width: 100%;" type="date" id="pra_data_previsao_pagamento" name="pra_data_previsao_pagamento" placeholder="Valor" required>
				</div>
			</div>

			<div class="div_emp_data" style=" justify-content: space-between!important">
				<div style="width: 54.5%;">
					<label>Data Empréstimo</label><br>
					<input style="width: 100%;" type="date" id="emo_data_emprestimo" name="emo_data_emprestimo" placeholder="Valor" required>
				</div>

				<div style="width: 40.5%;  margin-left: 5%">
					<label>Previsão Pagamento</label><br>
					<input style="width: 100%;" type="date" id="emo_data_previsao_pagamento" disabled name="emo_data_previsao_pagamento" placeholder="Valor">
				</div>
			</div>

			<div style="display: flex; justify-content: center" class="btn_cad_emp">
				<button>Cadastrar</button>
			</div>
		</form>
	</div>
</div>

<?php Functions::renderFooter(); ?>
<?php Functions::addScript(["js/Emprestimo/emprestimo.js", "js/Sistema/sistema.js"]); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

<script>
	$(document).ready(function () {
		$('#emo_valor').maskMoney({
			prefix: "R$ ",
			decimal: ",",
			thousands: "."
		});
	});
</script>

</body>
</html>