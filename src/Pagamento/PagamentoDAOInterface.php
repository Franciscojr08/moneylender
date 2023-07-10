<?php

namespace MoneyLender\Src\Pagamento;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Parcela\Parcela;

/**
 * Interface PagamentoDAOInterface
 * @package MoneyLender\Src\Pagamento
 * @version 1.0.0
 */
interface PagamentoDAOInterface {

	/**
	 * Consulta os pagamentos de um empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return PagamentoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByEmprestimo(Emprestimo $oEmprestimo): PagamentoList;

	/**
	 * Consulta os pagamentos de uma parcela
	 *
	 * @param Parcela $oParcela
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return PagamentoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByParcela(Parcela $oParcela): PagamentoList;
}