<?php

namespace MoneyLender\Src\Controllers\Home;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class homeController
 * @package MoneyLender\Src\Controllers\Home
 * @version 1.0.0
 */
class homeController {

	/**
	 * Renderiza a view da home
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function index(array $aDados): void {
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll();

		require_once "Home/index.php";
	}

	/**
	 * Consulta os empréstimos por ajax
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function emprestimoAjax(array $aDados): void {
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll();

		require_once "Home/include/listagem.php";
	}
}