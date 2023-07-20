<?php

namespace MoneyLender\Src\Emprestimo;

use MoneyLender\Src\Pessoa\Pessoa;

/**
 * Interface EmprestimoDAOInterface
 * @package MoneyLender\Src\Emprestimo
 * @version 1.0.0
 */
interface EmprestimoDAOInterface {

	/**
	 * Consulta todos em empréstimos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(): EmprestimoList;

	/**
	 * Consulta um empréstimo pelo Id
	 *
	 * @param int $iEmoId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Emprestimo
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iEmoId): Emprestimo;

	/**
	 * Consulta os emprestimos do cliente
	 *
	 * @param Pessoa $oPessoa
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByPessoa(Pessoa $oPessoa): EmprestimoList;
}