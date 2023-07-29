<?php

namespace MoneyLender\Src\Parcela;

use MoneyLender\Src\Emprestimo\Emprestimo;

interface ParcelaDAOInterface {

	/**
	 * Consulta as parcelas pelo empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ParcelaList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByEmprestimo(Emprestimo $oEmprestimo): ParcelaList;

	/**
	 * Cadastra uma parcela
	 *
	 * @param Parcela $oParcela
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function save(Parcela $oParcela): bool;

	/**
	 * Consulta uma parcela pelo Id
	 *
	 * @param int $iPraId
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return Parcela
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iPraId): Parcela;

	/**
	 * Atualiza uma parcela
	 *
	 * @param Parcela $oParcela
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function update(Parcela $oParcela);
}