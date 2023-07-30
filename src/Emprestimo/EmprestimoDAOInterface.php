<?php

namespace MoneyLender\Src\Emprestimo;

use Exception;
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
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(array $aDados): EmprestimoList;

	/**
	 * Consulta um empréstimo pelo Id
	 *
	 * @param int $iEmoId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Emprestimo
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iEmoId): Emprestimo;

	/**
	 * Consulta os emprestimos do cliente
	 *
	 * @param Pessoa $oPessoa
	 * @return EmprestimoList
	 * @throws Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByPessoa(Pessoa $oPessoa): EmprestimoList;

	/**
	 * Cadastra um empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function save(Emprestimo $oEmprestimo): bool;

	/**
	 * Atualiza um empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function update(Emprestimo $oEmprestimo): bool;

	/**
	 * Apaga um empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function delete(Emprestimo $oEmprestimo): bool;
}