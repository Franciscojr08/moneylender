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

	/**
	 * Cancela um empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cancelar(Emprestimo $oEmprestimo): bool;

	/**
	 * Retorna o valor total investido
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalInvestido(bool $bFiltrarFornecedor): array;

	/**
	 * Retorna o valor total investido
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalRecebido(bool $bFiltrarFornecedor): array;

	/**
	 * Retorna o valor total a receber
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAReceber(bool $bFiltrarFornecedor): array;

	/**
	 * Retorna o valor total atrasado
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAtrasado(bool $bFiltrarFornecedor): array;

	/**
	 * Retorna o valor total de juros recebido
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorJurosRecebido(bool $bFiltrarFornecedor): array;

	/**
	 * Retorna o valor total de juros a receber
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorJurosAReceber(bool $bFiltrarFornecedor): array;

	/**
	 * Retorna os empréstimos em aberto
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAllEmAberto(): EmprestimoList;
}