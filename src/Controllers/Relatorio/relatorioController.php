<?php

namespace MoneyLender\Src\Controllers\Relatorio;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class relatorioController
 * @package MoneyLender\Src\Controllers\Relatorio
 * @version 1.0.0
 */
class relatorioController {

	public function index(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll();

		require_once "Relatorio/index.php";
	}
}