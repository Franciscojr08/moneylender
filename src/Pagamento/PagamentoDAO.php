<?php

namespace MoneyLender\Src\Pagamento;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Sistema\Connection\Connection;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
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

	/**
	 * Cadastra um pagamento
	 *
	 * @param Pagamento $oPagamento
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function save(Pagamento $oPagamento, array $aDados): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "INSERT INTO pgo_pagamento (
						pgo_valor,
						pgo_forma_pagamento,
						pgo_data_pagamento)
					VALUES (?,?,?)";

			$aParams = [
				$oPagamento->getValor(),
				$oPagamento->getFormaPagamentoId(),
				$oPagamento->getDataPagamento()->format("Y-m-d")
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
			$oPagamento->setId($oConnection->getLasInsertId());

			$aDados = array_merge($aDados,["pgo_id" => $oPagamento->getId()]);
			$this->saveToTablePagamentoAux($aDados,$oConnection);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new \Exception("Não foi possível lançar o pagamento.");
		}

		$oConnection->commit();
		return $bStatus;
	}

	/**
	 * Salva o pagamento na tabela auxiliar com s Id's do empréstimo e parcela
	 *
	 * @param array $aDados
	 * @param Connection $oConnection
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function saveToTablePagamentoAux(array $aDados, Connection &$oConnection): void {
		try {
			$sSql = "INSERT INTO pgm_pagamento_emprestimo (pgo_id, emo_id, pra_id) VALUES (?,?,?)";
			$aParams = [
				$aDados['pgo_id'],
				$aDados['emo_id'],
				!empty($aDados['pra_id']) ? $aDados['pra_id'] : null
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
			if (!$bStatus) {
				throw new \Exception("Não foi possível lançar o pagamento.");
			}
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new \Exception("Não foi possível lançar o pagamento.");
		}
	}
}