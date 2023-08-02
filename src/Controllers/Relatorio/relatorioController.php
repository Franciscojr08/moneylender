<?php

namespace MoneyLender\Src\Controllers\Relatorio;

use MoneyLender\Src\Relatorio\ReciboEmprestimo;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class relatorioController
 * @package MoneyLender\Src\Controllers\Relatorio
 * @version 1.0.0
 */
class relatorioController {

	public function index(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll($aDados,true);

		require_once "Relatorio/index.php";
	}

	/**
	 * Gera o recibo do empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function recibo(array $aDados): void {
		$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['valor']);
		$oRecibo = new ReciboEmprestimo();
		$oRecibo->gerar($oEmprestimo);
		$oRecibo->Output();
	}
}