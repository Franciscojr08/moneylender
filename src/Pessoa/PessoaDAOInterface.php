<?php

namespace MoneyLender\Src\Pessoa;

/**
 * Interface ClienteDAOInterface
 * @package MoneyLender\Src\Pessoa
 * @version 1.0.0
 */
interface PessoaDAOInterface {

	/**
	 * Consulta a pessoa pelo Id
	 *
	 * @param int $iPsaId
	 * @return Pessoa
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iPsaId): Pessoa;

	/**
	 *Consulta todas as pessoas
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return PessoaList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(bool $bFiltrarFornecedor = false): PessoaList;

	/**
	 * Verifica se já existe o CPF cadastrado
	 *
	 * @param string $sCPF
	 * @param int $iTipo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Pessoa
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByCPFAndTipo(string $sCPF, int $iTipo): Pessoa;

	/**
	 * Cadastra uma pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function save(Pessoa $oPessoa): bool;

	/**
	 * Atualiza uma pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function update(Pessoa $oPessoa): bool;

	/**
	 * Deleta uma pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function delete(Pessoa $oPessoa): bool;
}