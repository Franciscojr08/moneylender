<?php

use MoneyLender\Core\Functions;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Pessoa\PessoaList;

/**
 * @var PessoaList $loPessoaList
 * @var PessoaList $loFornecedorList
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
		<h3>Relatórios</h3>
		<p class="mb-4">Selecione o tipo de relatório que deseja gerar.</p>

		<h6>Modelo de relatório</h6>
		<input type="radio" checked data-target="filtro_recibo" id="recibo" name="rel_tipo" value="rel_recibo" class="rel_tipo">
		<label for="recibo" style="color: #fff; margin-bottom: 8px">2ª Via recibo</label><br>

		<input type="radio" data-target="not_filtro" id="faturamento" name="rel_tipo" value="rel_faturamento" class="rel_tipo">
		<label for="faturamento" style="color: #fff; margin-bottom: 8px">Faturamento</label><br>

		<input type="radio" data-target="filtro_emprestimo"  id="emprestimos" name="rel_tipo" value="rel_emprestimo" class="rel_tipo">
		<label for="emprestimos" style="color: #fff; margin-bottom: 8px">Empréstimos</label><br>

		<input type="radio" data-target="filtro_clientes" id="clientes" name="rel_tipo" value="rel_cliente" class="rel_tipo">
		<label for="clientes" style="color: #fff; margin-bottom: 8px">Clientes</label><br>

		<input type="radio" data-target="filtro_fornecedores" id="fornecedores" name="rel_tipo" value="rel_fornecedor" class="rel_tipo">
		<label for="fornecedores" style="color: #fff;">Fornecedores</label><br>

	</div>

	<div class="cad_emp_data">
		<h3 style="">Filtros do relatório</h3>
		<p class="mb-4">Preencha os campos caso possua e deseje filtrar.</p>

		<form action="../relatorio/gerar" method="post" target="_blank">
			<input type="hidden" class="tipo_relatorio" name="tipo_relatorio" value="rel_recibo">

			<div id="filtro_recibo" class="div_filtro">
				<?php require_once "Relatorio/include/filtro_recibo.php"; ?>
			</div>

			<div id="filtro_emprestimo" style="display:none;" class="div_filtro">
				<?php require_once "Relatorio/include/filtro_emprestimo.php"; ?>
			</div>

			<?php require_once "Relatorio/include/filtro_pessoa.php"; ?>

			<div id="not_filtro" style="display: none" class="div_filtro">
				<?php Functions::addImage("not_img","png",""); ?>
				<br>
				<span>Este modelo de relatório não possui filtros disponíveis.</span>
			</div>
			
			<div style="display: flex; justify-content: center" class="btn_cad_emp">
				<button type="submit">Gerar</button>
			</div>
		</form>
	</div>
</div>

<?php Functions::renderFooter(); ?>
<?php Functions::addScript(["js/Relatorio/relatorio.js", "js/Sistema/sistema.js"]); ?>

</body>
</html>