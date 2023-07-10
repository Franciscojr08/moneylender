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
}