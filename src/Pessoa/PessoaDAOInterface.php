<?php

namespace MoneyLender\Src\Pessoa;

/**
 * Interface ClienteDAOInterface
 * @package MoneyLender\Src\Pessoa
 * @version 1.0.0
 */
interface PessoaDAOInterface {

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
	public function find(int $iCleId): Pessoa;

	/**
	 * Consulta todos os clientes
	 *
	 * @return PessoaList
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(): PessoaList;
}