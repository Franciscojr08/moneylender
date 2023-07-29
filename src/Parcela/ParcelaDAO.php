<?php

namespace MoneyLender\Src\Parcela;

use Exception;
use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Sistema;

class ParcelaDAO implements ParcelaDAOInterface {

	/**
	 * Consulta as parcelas pelo empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @return ParcelaList
	 * @throws Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByEmprestimo(Emprestimo $oEmprestimo): ParcelaList {
		$sSql = "SELECT * FROM pra_parcela WHERE emo_id = ?";
		$aParam[] = $oEmprestimo->getId();

		try {
			$aaParcelas = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar as parcelas.");
		}

		if (empty($aaParcelas)) {
			return new ParcelaList();
		}

		return ParcelaList::createFromArray($aaParcelas);
	}

	/**
	 * Cadastra uma parcela
	 *
	 * @param Parcela $oParcela
	 * @return bool
	 * @throws Exception
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function save(Parcela $oParcela): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "INSERT INTO pra_parcela (
						emo_id,
						pra_valor,
						pra_valor_pago,
						pra_valor_devido,
						pra_data_previsao_pagamento,
						pra_situacao,
						pra_sequencia_parcela,
						pra_data_cadastro)
					VALUES (?,?,?,?,?,?,?,?)";

			$aParams = [
				$oParcela->getEmprestimo()->getId(),
				$oParcela->getValor(),
				$oParcela->getValorPago(),
				$oParcela->getValorDevido(),
				$oParcela->getDataPrevisaoPagamento()->format("Y-m-d"),
				$oParcela->getSituacao(),
				$oParcela->getSequenciaParcela(),
				$oParcela->getDataCadastro()->format("Y-m-d")
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
			$oParcela->setId($oConnection->getLasInsertId());
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível cadastrar a parcela.");
		}

		$oConnection->commit();
		return $bStatus;
	}

	/**
	 * Atualiza uma parcela
	 *
	 * @param Parcela $oParcela
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function update(Parcela $oParcela): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;
		
		try {
			$sSql = "UPDATE pra_parcela SET
						pra_valor = ?,
						pra_valor_pago = ?,
						pra_valor_devido = ?,
						pra_situacao = ?,
						pra_data_atualizacao = ?
					WHERE
						pra_id = ?";
			
			$aParams = [
				$oParcela->getValor(),
				$oParcela->getValorPago(),
				$oParcela->getValorDevido(),
				$oParcela->getSituacao(),
				$oParcela->getDataAtualizacao()->format("Y-m-d"),
				$oParcela->getId()
			];
			
			$bStatus = $oConnection->execute($sSql,$aParams);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível atualizar a parcela.");
		}
		
		$oConnection->commit();
		return $bStatus;
	}

	/**
	 * Consulta uma parcela pelo Id
	 *
	 * @param int $iPraId
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return Parcela
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iPraId): Parcela {
		$sSql = "SELECT * FROM pra_parcela WHERE pra_id = ?";
		$aParam[] = $iPraId;

		try {
			$aParcela = Sistema::connection()->getRow($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consulta a parcela.");
		}

		if (empty($aParcela)) {
			throw new Exception("Nenhuma parcela encontrada.");
		}

		return Parcela::createFromArray($aParcela);
	}
}