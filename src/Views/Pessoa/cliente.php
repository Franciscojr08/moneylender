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

<div class="content_div">
	<div class="d-flex justify-content-center">
		<h3>Clientes</h3>
	</div>

	<div class="div_cad_pessoa">
		<span>Cadastrar <i class="fa-solid fa-user-plus" id="cadastrar_cliente" style="margin-left: 5px"></i></span>
	</div>
	<table class="table table-striped tabela_pessoa">
		<thead>
		<tr class="table-dark">
			<th scope="col">Identificador</th>
			<th scope="col">Nome</th>
			<th scope="col">CPF</th>
			<th scope="col">E-mail</th>
			<th scope="col">Telefone</th>
			<th scope="col">Indicado</th>
			<th scope="col">Nome Indicador</th>
			<th scope="col">Empréstimos</th>
			<th scope="col">Cadastro</th>
			<th scope="col">Atualização</th>
			<th scope="col">Controle</th>
		</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div>

<?php Functions::renderFooter(); ?>
<?php Functions::addScript(["js/Pessoa/pessoa.js", "js/Sistema/sistema.js"]); ?>
</body>
</html>