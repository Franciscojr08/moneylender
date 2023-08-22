<?php

namespace MoneyLender\Src\Emprestimo;

use Exception;
use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Sistema;

class EmprestimoDAO implements EmprestimoDAOInterface {

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
	public function findAll(array $aDados): EmprestimoList {
		$oConnection = Sistema::connection();
		$aFiltro = $aDados['aFiltro'] ?? [];
		$aParams = [];

		$sSql = "SELECT
					*
				FROM
					emo_emprestimo emo
				INNER JOIN psa_pessoa psa on emo.psa_id = psa.psa_id and psa.psa_tipo = ?
				WHERE 1 = 1";

		$aParams[] = isset($aDados['filtrar_fornecedor']) && $aDados['filtrar_fornecedor'] ? Pessoa::FORNECEDOR : Pessoa::CLIENTE;

		if (!empty($aFiltro['iPsaId'])) {
			$sSql .= " AND emo.psa_id = ?";
			$aParams[] = $aFiltro['iPsaId'];
		}

		if (!empty($aFiltro['sDataEmprestimo'])) {
			$sSql .= " AND emo.emo_data_emprestimo = ?";
			$aParams[] = $aFiltro['sDataEmprestimo'];
		}

		if (!empty($aFiltro['iJuros'])) {
			$iJuros = $aFiltro['iJuros'];
			if ($iJuros == SimNaoEnum::SIM) {
				$sSql .= " AND emo.emo_taxa_juros is not null";
			} else if ($iJuros == SimNaoEnum::NAO) {
				$sSql .= " AND emo.emo_taxa_juros is null";
			}
		}

		if (!empty($aFiltro['iParcelado'])) {
			$iParcelado = $aFiltro['iParcelado'];
			if ($iParcelado == SimNaoEnum::SIM) {
				$sSql .= " AND emo.emo_pagamento_parcelado = ?";
				$aParams[] = SimNaoEnum::SIM;
			} else if ($iParcelado == SimNaoEnum::NAO) {
				$sSql .= " AND emo.emo_pagamento_parcelado = ?";
				$aParams[] = SimNaoEnum::NAO;
			}
		}

		if (!empty($aFiltro['aSituacaoId'])) {
			$sBindParams = implode(" ,",array_fill(0,count($aFiltro['aSituacaoId']),"?"));
			$sSql .= " AND emo.emo_situacao in ({$sBindParams})";
			$aParams = array_merge($aParams,$aFiltro['aSituacaoId']);
		}

		$sSql .= " ORDER BY emo.psa_id, emo.emo_situacao, emo.emo_valor desc";
//		$sSql .= " LIMIT 0,20";

		try {
			$aaEmprestimos = $oConnection->getArray($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar os empréstimos.");
		}

		if (empty($aaEmprestimos)) {
			return new EmprestimoList();
		}

		return EmprestimoList::createFromArray($aaEmprestimos);
	}

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
	public function find(int $iEmoId): Emprestimo {
		$sSql = "SELECT * FROM emo_emprestimo WHERE emo_id = ?";
		$aParam[] = $iEmoId;

		try {
			$aEmprestimo = Sistema::connection()->getRow($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}

		if (empty($aEmprestimo)) {
			throw new Exception("Nenhum empréstimo encontrado..");
		}

		return Emprestimo::createFromArray($aEmprestimo);
	}

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
	public function findByPessoa(Pessoa $oPessoa): EmprestimoList {
		$sSql = "SELECT
					emo.*
				FROM
					emo_emprestimo emo
				WHERE
					emo.psa_id = ?
					and emo.emo_situacao != ?";

		$aParams = [
			$oPessoa->getId(),
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			$aaEmprestimos = Sistema::connection()->getArray($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar os empréstimos do cliente.");
		}

		if (empty($aaEmprestimos)) {
			return new EmprestimoList();
		}

		return EmprestimoList::createFromArray($aaEmprestimos);
	}

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
	public function save(Emprestimo $oEmprestimo): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "INSERT INTO emo_emprestimo (
						psa_id,
						emo_valor,
						emo_valor_pago,
						emo_valor_devido,
						emo_taxa_juros,
						emo_valor_juros,
						emo_data_emprestimo,
						emo_pagamento_parcelado,
						emo_data_previsao_pagamento,
						emo_situacao,
						emo_data_cadastro)
					VALUES (?,?,?,?,?,?,?,?,?,?,?)";

			$aParams = [
				$oEmprestimo->getPessoa()->getId(),
				$oEmprestimo->getValor(),
				$oEmprestimo->getValorPago(),
				$oEmprestimo->getValorDevido(),
				$oEmprestimo->hasTaxaJuros() ? $oEmprestimo->getTaxaJuros() : null,
				$oEmprestimo->hasTaxaJuros() ? $oEmprestimo->getValorJuros() : null,
				$oEmprestimo->getDataEmprestimo()->format("Y-m-d"),
				$oEmprestimo->isPagamentoParcelado() ? SimNaoEnum::SIM : SimNaoEnum::NAO,
				$oEmprestimo->isPagamentoParcelado() ? null : $oEmprestimo->getDataPrevisaoPagamento()->format("Y-m-d"),
				$oEmprestimo->getSituacaoId(),
				$oEmprestimo->getDataCadastro()->format("Y-m-d")
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
			$oEmprestimo->setId($oConnection->getLasInsertId());
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível cadastrar o empréstimo.");
		}

		$oConnection->commit();
		return $bStatus;
	}

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
	public function update(Emprestimo $oEmprestimo): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "UPDATE emo_emprestimo SET
						psa_id = ?,
						emo_valor = ?,
						emo_valor_pago = ?,
						emo_valor_devido = ?,
						emo_taxa_juros = ?,
						emo_valor_juros = ?,
						emo_data_emprestimo = ?,
						emo_pagamento_parcelado = ?,
						emo_data_previsao_pagamento = ?,
						emo_situacao = ?,
						emo_data_cadastro = ?,
						emo_data_atualizacao = ?
					WHERE
						emo_id = ?";

			$aParams = [
				$oEmprestimo->getPessoa()->getId(),
				$oEmprestimo->getValor(),
				$oEmprestimo->getValorPago(),
				$oEmprestimo->getValorDevido(),
				$oEmprestimo->hasTaxaJuros() ? $oEmprestimo->getTaxaJuros() : null,
				$oEmprestimo->hasTaxaJuros() ? $oEmprestimo->getValorJuros() : null,
				$oEmprestimo->getDataEmprestimo()->format("Y-m-d"),
				$oEmprestimo->isPagamentoParcelado() ? SimNaoEnum::SIM : SimNaoEnum::NAO,
				$oEmprestimo->isPagamentoParcelado() ? null : $oEmprestimo->getDataPrevisaoPagamento()->format("Y-m-d"),
				$oEmprestimo->getSituacaoId(),
				$oEmprestimo->getDataCadastro()->format("Y-m-d"),
				$oEmprestimo->getDataAtualizacao()->format("Y-m-d"),
				$oEmprestimo->getId()
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível atualizar o empréstimo.");
		}

		$oConnection->commit();
		return $bStatus;
	}

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
	public function delete(Emprestimo $oEmprestimo): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "DELETE FROM emo_emprestimo WHERE emo_id = ?";
			$aParam[] = $oEmprestimo->getId();
			
			$bStatus = Sistema::connection()->execute($sSql,$aParam);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new \Exception("Não foi possível lançar o pagamento.");
		}

		$oConnection->commit();
		return $bStatus;
	}

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
	public function cancelar(Emprestimo $oEmprestimo): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "UPDATE emo_emprestimo SET emo_cancelado = ?, emo_situacao = ? WHERE emo_id = ?";
			$aParams = [
				SimNaoEnum::SIM,
				$oEmprestimo->getSituacaoId(),
				$oEmprestimo->getId()
			];

			$bStatus = Sistema::connection()->execute($sSql,$aParams);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new \Exception("Não foi possível lançar o pagamento.");
		}

		$oConnection->commit();
		return $bStatus;
	}

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
	public function getValorTotalInvestido(bool $bFiltrarFornecedor): array {
		$sSql = "select
					sum(emo.emo_valor) as valor_investido
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				where emo.emo_situacao != ?";
		$aParams = [
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			return Sistema::connection()->getRow($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}
	}

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
	public function getValorTotalRecebido(bool $bFiltrarFornecedor): array {
		$sSql = "select
					sum(emo.emo_valor_pago) as valor_recebido
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				where emo.emo_situacao != ?";
		$aParams = [
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			return Sistema::connection()->getRow($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}
	}

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
	public function getValorTotalAReceber(bool $bFiltrarFornecedor): array {
		$sSql = "select
					sum(emo.emo_valor_devido) as valor_a_receber
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				where emo.emo_situacao != ?";
		$aParams = [
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			return Sistema::connection()->getRow($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}
	}

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
	public function getValorTotalAtrasado(bool $bFiltrarFornecedor): array {
		$sSql = "select
					sum(pra.pra_valor_devido) as valor_a_receber
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				inner join pra_parcela pra on emo.emo_id = pra.emo_id
				WHERE
					pra.pra_data_previsao_pagamento < (SELECT CURDATE())
					and pra.pra_situacao != ?
					and emo.emo_situacao not in (?,?)

				union

				select
					sum(emo.emo_valor_devido) as valor_a_receber
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				WHERE
					emo.emo_data_previsao_pagamento < (SELECT CURDATE())
					and emo.emo_situacao not in (?,?)";

		$aParams = [
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::PAGO,
			SituacaoEmprestimoEnum::PAGO,
			SituacaoEmprestimoEnum::CANCELADO,
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::PAGO,
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			return Sistema::connection()->getArray($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}
	}

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
	public function getValorJurosRecebido(bool $bFiltrarFornecedor): array {
		$sSql = "select
					emo.emo_id,
					(CASE
						when emo.emo_valor_pago > emo.emo_valor then sum(emo.emo_valor_pago) - sum(emo.emo_valor)
						else 0.0
					END) as valor_recebido
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				where
					emo.emo_taxa_juros > 0
					and emo.emo_situacao != ?
				GROUP BY emo.emo_id HAVING valor_recebido > 0;";

		$aParams = [
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			return Sistema::connection()->getArray($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}
	}

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
	public function getValorJurosAReceber(bool $bFiltrarFornecedor): array {
		$sSql = "select
					emo.emo_id,
					(CASE
						when emo.emo_valor_pago > emo.emo_valor and emo.emo_valor_pago - emo.emo_valor < emo.emo_valor_juros THEN sum(emo.emo_valor_pago) - sum(emo.emo_valor)
						when emo.emo_valor_pago < emo.emo_valor THEN emo.emo_valor_juros
						else 0.0
					END) as valor_a_receber
				from
					emo_emprestimo emo
				inner join psa_pessoa psa on emo.psa_id = psa.psa_id and psa_tipo = ?
				where
					emo.emo_taxa_juros > 0
					and emo.emo_situacao != ?
				GROUP BY emo.emo_id HAVING valor_a_receber > 0";

		$aParams = [
			$bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE,
			SituacaoEmprestimoEnum::CANCELADO
		];

		try {
			return Sistema::connection()->getArray($sSql,$aParams);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar o empréstimo.");
		}
	}

	/**
	 * Retorna os empréstimos em aberto
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAllEmAberto(): EmprestimoList {
		$sSql = "SELECT * FROM emo_emprestimo
				WHERE
					emo_situacao = ?";
		$aParam[] = SituacaoEmprestimoEnum::EM_ABERTO;

		try {
			$aaEmprestimos = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar os empréstimos.");
		}

		if (empty($aaEmprestimos)) {
			return new EmprestimoList();
		}

		return EmprestimoList::createFromArray($aaEmprestimos);
	}
}