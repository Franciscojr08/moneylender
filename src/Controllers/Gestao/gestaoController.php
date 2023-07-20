<?php

namespace MoneyLender\Src\Controllers\Gestao;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class gestaoController
 * @package MoneyLender\Src\Controllers\Gestao
 * @version 1.0.0
 */
class gestaoController {

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
	public function pessoal(array $aDados): void {
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll();
		$bFiltrarFornecedor = true;

		require_once "Gestao/pessoal.php";
	}

	public function index(array $aDados): void {
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll();
		$bFiltrarFornecedor = false;

		require_once "Gestao/index.php";
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
		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		require_once "Gestao/include/emprestimos.php";
	}
}