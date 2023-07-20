<?php

namespace MoneyLender\Src\Pessoa;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class ClienteDAO
 * @package MoneyLender\Src\Pessoa
 * @version 1.0.0
 */
class PessoaDAO implements PessoaDAOInterface {

	/**
	 * Consulta o cliente pelo id
	 *
	 * @param int $iCleId
	 * @return Pessoa
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iCleId): Pessoa {
		$sSql = "SELECT * FROM cle_cliente WHERE cle_id = ?";
		$aParam[] = $iCleId;
		
		try {
			$aCliente = Sistema::connection()->getRow($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar o cliente.");
		}

		if (empty($aCliente)) {
			throw new \Exception("Nenhum cliente encontrado.");
		}

		return Pessoa::createFromArray($aCliente);
	}

	/**
	 * Consulta todos os clientes
	 *
	 * @return PessoaList
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(): PessoaList {
		$sSql = "SELECT * FROM cle_cliente";

		try {
			$aaClientes = Sistema::connection()->getArray($sSql);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os clientes.");
		}

		if (empty($aaClientes)) {
			return new PessoaList();
		}

		return PessoaList::createFromArray($aaClientes);
	}
}