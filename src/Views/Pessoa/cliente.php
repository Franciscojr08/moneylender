<?php

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
	<div class="d-flex justify-content-center">
		<h3>Clientes</h3>
	</div>

	<div class="div_cad_pessoa" style="display: block!important; margin-bottom: 2.5rem;">
		<?php Functions::renderMensagem(); ?>

		<span style="float: right" data-bs-toggle="modal" data-bs-target="#exampleModal">Cadastrar <i class="fa-solid fa-user-plus" style="margin-left: 5px"></i></span>
	</div>

	<div class="filtros_emprestimo">
		<?php require_once "Pessoa/include/filros_pessoa.php"; ?>
	</div>

	<div class="inf_pessoa">
		<label>Clientes: <span><?php echo $loPessoaList->count(); ?></span></label>
	</div>

	<table class="table table-striped tabela_pessoa" style="margin-top: 2.3rem">
		<thead>
		<tr class="table-dark">
			<th scope="col">Cód</th>
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

	<form type="POST" action="../../pessoa/cadastrarPessoa">
		<input type="hidden" class="psa_tipo" name="aPessoa[psa_tipo]" value="1">
		<?php
			$sDescricaoTipoPessoa = "Cliente";
			require_once "Pessoa/include/cadastrar.php";
		?>
	</form>
</div>

<div class="toast-container position-fixed bottom-0 p-3">
	<div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
		<div class="toast-header" style="background: #ff0000; color: #ffff; font-weight: bold;">
			<strong class="me-auto">ATENÇÃO!</strong>
			<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
		</div>
		<div class="toast-body">
			Preencha o nome do indicador!
		</div>
	</div>
</div>

<div class="modal fade" id="modalEditarPessoa"></div>
<div class="modal fade" id="modalExcluirPessoa"></div>

<?php
	Functions::renderFooter();
	Functions::addScript(["js/Pessoa/pessoa.js", "js/Sistema/sistema.js"]);

	require_once "Pessoa/include/validarCPF.php";
?>

</body>
</html>