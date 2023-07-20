<?php

namespace MoneyLender\Src\Controllers\Pessoa;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class pessoaController
 * @package MoneyLender\Src\Controllers\Pessoa
 * @version 1.0.0
 */
class pessoaController {

	/**
	 * Renderiza a view padrão
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cliente(array $aDados): void {
		require_once "Pessoa/cliente.php";
	}

	public function fornecedor(array $aDados): void {
		require_once "Pessoa/fornecedor.php";
	}

	/**
	 * Carrega todos os clientes
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function pessoaAjax(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll();
		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "fornecedor";

		require_once "Pessoa/include/pessoa.php";
	}
}