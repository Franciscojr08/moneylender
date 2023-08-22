<?php

/** @var string $sMensagem */

use MoneyLender\Core\Functions;
use MoneyLender\Src\Pessoa\PessoaList;

/** @var PessoaList $loPessoaList */
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
	<div class="d-flex justify-content-center" style="padding-bottom: 30px">
		<h3><?php echo $sMensagem; ?>!</h3>
	</div>
</div>

<?php
Functions::renderFooter();
Functions::addScript(["js/Pessoa/pessoa.js", "js/Sistema/sistema.js"]);
?>

</body>
</html>