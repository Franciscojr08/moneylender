<?php

use MoneyLender\Core\Functions;

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

<div>
	<?php require_once "Home/include/cards.php"; ?>

	<table class="table table-striped tabela_emprestimo">
		<thead>
		<tr class="table-dark">
			<th scope="col">Código</th>
			<th scope="col">Data Empréstimo</th>
			<th scope="col">Cliente</th>
			<th scope="col">Valor</th>
			<th scope="col">Juros (%)</th>
			<th scope="col">Juros (R$)</th>
			<th scope="col">Valor Total</th>
			<th scope="col">Valor Pago</th>
			<th scope="col">Valor Devido</th>
			<th scope="col">Parcelas</th>
			<th scope="col">Parcelas Pagas</th>
			<th scope="col">Situação</th>
			<th scope="col">Prev. Pagamento</th>
			<th scope="col">Pagamentos</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<?php Functions::renderFooter(); ?>
<?php Functions::addScript(["js/Home/home.js"]); ?>
</body>
</html>