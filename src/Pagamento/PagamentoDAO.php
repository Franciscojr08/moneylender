<?php

namespace MoneyLender\Src\Pagamento;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class PagamentoDAO
 * @package MoneyLender\Src\Pagamento
 * @version 1.0.0
 */
class PagamentoDAO implements PagamentoDAOInterface {

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
	public function findByEmprestimo(Emprestimo $oEmprestimo): PagamentoList {
		$sSql = "SELECT
					pgo.*
				FROM
					pgo_pagamento pgo
				INNER JOIN pgm_pagamento_emprestimo pgm on pgo.pgo_id = pgm.pgo_id
				WHERE
					pgm.emo_id = ?";
		$aParam[] = $oEmprestimo->getId();
		
		try {
			$aaPagamentos = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os pagamentos do empréstimo.");
		}

		if (empty($aaPagamentos)) {
			return new PagamentoList();
		}

		return PagamentoList::createFromArray($aaPagamentos);
	}

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
	public function findByParcela(Parcela $oParcela): PagamentoList {
		$sSql = "SELECT
					pgo.*
				FROM
					pgo_pagamento pgo
				INNER JOIN pgm_pagamento_emprestimo pgm on pgo.pgo_id = pgm.pgo_id
				WHERE
					pgm.pra_id = ?";
		$aParam[] = $oParcela->getId();

		try {
			$aaPagamentos = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os pagamentos do empréstimo.");
		}

		if (empty($aaPagamentos)) {
			return new PagamentoList();
		}

		return PagamentoList::createFromArray($aaPagamentos);
	}
}