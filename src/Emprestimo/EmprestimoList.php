<?php

namespace MoneyLender\Src\Emprestimo;

use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;

class EmprestimoList extends \SplObjectStorage {

	/**
	 * Retorna se a lista está vazia
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isEmpty(): bool {
		return $this->count() == 0;
	}

	/**
	 * Cria uma lista de empréstimo a partir de um array
	 *
	 * @param array $aaDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aaDados): EmprestimoList {
		$loEmprestimoList = new EmprestimoList();

		if (empty($aaDados)) {
			return $loEmprestimoList;
		}

		foreach ($aaDados as $aDados) {
			$oEmprestimo = Emprestimo::createFromArray($aDados);
			$loEmprestimoList->attach($oEmprestimo);
		}

		return $loEmprestimoList;
	}

	/**
	 * Retorna o valor total investido
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalInvestido(): float {
		$fValorTotalInvestido = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalInvestido;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			$fValorTotalInvestido += $oEmprestimo->getValor();
		}

		return $fValorTotalInvestido;
	}

	/**
	 * Retorna o valor total recebido
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalRecebido(): float {
		$fValorTotalRecebido = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalRecebido;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if (!$oEmprestimo->hasPagamentos()) {
				continue;
			}

			$fValorTotalRecebido += $oEmprestimo->getValorPago();
		}

		return $fValorTotalRecebido;
	}

	/**
	 * Retorna o valor total a receber
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAReceber(): float {
		$fValorTotalAReceber = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalAReceber;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			$fValorTotalAReceber += $oEmprestimo->getValorDevido();
		}

		return $fValorTotalAReceber;
	}

	/**
	 * Retorna o valor total atrasado
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAtrasado(): float {
		$fValorTotalAtrasado = 0.00;
		$oDataAtual = new \DateTimeImmutable("now");
		$aSituacaoesEmprestimo = [SituacaoEmprestimoEnum::PAGO,SituacaoEmprestimoEnum::CANCELADO];

		if ($this->isEmpty()) {
			return $fValorTotalAtrasado;
		}

		/** @var Emprestimo $oEmprestimo */
		/** @var Parcela $oParcela */

		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->isPagamentoParcelado()) {
				$loParcelas = $oEmprestimo->getParcelas();
				if ($loParcelas->isEmpty()) {
					continue;
				}

				foreach ($loParcelas as $oParcela) {
					$oDataPrevisaoPagamento = $oParcela->getDataPrevisaoPagamento();
					$iSituacao = $oParcela->getSituacaoId();

					if ($oDataPrevisaoPagamento < $oDataAtual &&
						!in_array($iSituacao,$aSituacaoesEmprestimo) &&
						!$oParcela->hasPagamentos()) {
						$fValorTotalAtrasado += $oParcela->getValorDevido();
					}
				}
			} else {
				$oDataPrevisaoPagamento = $oEmprestimo->getDataPrevisaoPagamento();
				$iSituacao = $oEmprestimo->getSituacaoId();

				if ($oDataPrevisaoPagamento < $oDataAtual &&
					!in_array($iSituacao,$aSituacaoesEmprestimo) &&
					!$oEmprestimo->hasPagamentos()) {
					$fValorTotalAtrasado += $oEmprestimo->getValorDevido();
				}
			}
		}

		return $fValorTotalAtrasado;
	}

	/**
	 * Retorna o valor total recebido dos juros
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalJurosRecebido(): float {
		$fValorTotalJurosRecebido = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalJurosRecebido;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if (!$oEmprestimo->hasTaxaJuros() && !$oEmprestimo->hasPagamentos()) {
				continue;
			}

			if ($oEmprestimo->getValorPago() > $oEmprestimo->getValor()) {
				$fValorTotalJurosRecebido += ($oEmprestimo->getValorPago() - $oEmprestimo->getValor());
			}
		}

		return $fValorTotalJurosRecebido;
	}

	/**
	 * Retorna o valor do juros a receber
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalJurosAReceber(): float {
		$fValorJurosAReceber = 0.00;

		if ($this->isEmpty()) {
			return $fValorJurosAReceber;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if (!$oEmprestimo->hasTaxaJuros() && !$oEmprestimo->hasPagamentos()) {
				continue;
			}

			$fValorJuros = $oEmprestimo->getValorJuros();
			if ($oEmprestimo->getValorPago() > $oEmprestimo->getValor()) {
				if (($oEmprestimo->getValorPago() - $oEmprestimo->getValor()) == $fValorJuros) {
					continue;
				} else {
					$fValorJurosAReceber = $fValorJuros - ($oEmprestimo->getValorPago() - $oEmprestimo->getValor());
				}
			} else {
				$fValorJurosAReceber += $fValorJuros;
			}
		}

		return $fValorJurosAReceber;
	}
}