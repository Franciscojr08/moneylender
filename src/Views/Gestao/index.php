<?php

use MoneyLender\Core\Functions;
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Pessoa\PessoaList;

/** @var PessoaList $loPessoaList */
/** @var EmprestimoList $loEmprestimos */
/** @var bool $bFiltrarFornecedor */
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

<div class="content_gestao">
	<div class="d-flex justify-content-center">
		<h3>Gestão Clientes</h3>
	</div>

	<?php require_once "Gestao/include/cards.php"; ?>

	<div style="margin: 0 0 0 2%;">
		<?php Functions::renderMensagem(true, 98); ?>
	</div>

	<div class="filtros_emprestimo">
		<?php require_once "Gestao/filtros_emprestimo.php"; ?>
	</div>

	<div class="inf_emprestimos">
		<label>Empréstimos: <span><?php echo $loEmprestimos->count(); ?></span></label>
		<label>Em Aberto: <span><?php echo $loEmprestimos->getQuantidadeEmAberto(); ?></span></label>
		<label>Atrasados: <span><?php echo $loEmprestimos->getQuantidadeAtrasado(); ?></span></label>
		<label>Pagos: <span><?php echo $loEmprestimos->getQuantidadePago(); ?></span></label>
		<label>Cancelados: <span><?php echo $loEmprestimos->getQuantidadeCancelado(); ?></span></label>
	</div>

	<table class="table table-striped tabela_emprestimo">
		<thead>
		<tr class="table-dark">
			<th scope="col" title="Código Empréstimo"><i class="fa-solid fa-barcode fa-lg"></i></th>
			<th scope="col">Data Emp.</th>
			<th scope="col">Data Atl.</th>
			<th scope="col">Cliente</th>
			<th scope="col">Valor</th>
			<th scope="col">Juros</th>
			<th scope="col">Valor Total</th>
			<th scope="col">Devido / Pago</th>
			<th scope="col">Parcelas</th>
			<th scope="col">Situação</th>
			<th scope="col">Prev. PG</th>
			<th scope="col" title="Pagamentos"><i class="fa-solid fa-money-bill-trend-up fa-lg"></i></th>
			<th scope="col" title="Ações do empréstimo"><i class="fa-solid fa-gears fa-lg"></i></th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<div class="modal fade" id="modalVisualizarPagamentos"></div>
<div class="modal fade" id="modalLancarPagamentos"></div>

<div class="modal fade" id="modalCancelarEmprestimo"></div>
<div class="modal fade" id="modalExcluirEmprestimo"></div>

<?php Functions::renderFooter(); ?>
<?php Functions::addScript(["js/Gestao/gestao.js", "js/Sistema/sistema.js"]); ?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

</body>
</html>