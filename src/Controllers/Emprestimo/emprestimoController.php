<?php

namespace MoneyLender\Src\Controllers\Emprestimo;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class emprestimoController
 * @package MoneyLender\Src\Controllers\Emprestimo
 * @version 1.0.0
 */
class emprestimoController {

	/**
	 * Renderiza a view de cadastro do empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function index(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll();

		require_once "Emprestimo/index.php";
	}

}