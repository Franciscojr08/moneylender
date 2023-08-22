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
		<h3>Pagamentos</h3>
	</div>

</div>


<?php Functions::renderFooter(); ?>
<?php Functions::addScript(["js/Gestao/gestao.js", "js/Sistema/sistema.js"]); ?>

</body>
</html>