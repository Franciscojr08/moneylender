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
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalInvestido(bool $bFiltrarFornecedor = false): float {
		$fValorTotalInvestido = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalInvestido;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($bFiltrarFornecedor) {
				if ($oEmprestimo->getPessoa()->isCliente()) {
					continue;
				}
			} else {
				if ($oEmprestimo->getPessoa()->isFornecedor()) {
					continue;
				}
			}

			$fValorTotalInvestido += $oEmprestimo->getValor();
		}

		return $fValorTotalInvestido;
	}

	/**
	 * Retorna o valor total recebido
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalRecebido(bool $bFiltrarFornecedor = false): float {
		$fValorTotalRecebido = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalRecebido;
		}

		/** @var Emprestimo $oEmprestimo */
		/** @var Parcela $oParcela */

		foreach ($this as $oEmprestimo) {
			if ($bFiltrarFornecedor) {
				if ($oEmprestimo->getPessoa()->isCliente()) {
					continue;
				}
			}

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
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAReceber(bool $bFiltrarFornecedor = false): float {
		$fValorTotalAReceber = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalAReceber;
		}

		/** @var Emprestimo $oEmprestimo */
		/** @var Parcela $oParcela */

		foreach ($this as $oEmprestimo) {
			if ($bFiltrarFornecedor) {
				if ($oEmprestimo->getPessoa()->isCliente()) {
					continue;
				}
			} else {
				if ($oEmprestimo->getPessoa()->isFornecedor()) {
					continue;
				}
			}

			$fValorTotalAReceber += $oEmprestimo->getValorDevido();
		}

		return $fValorTotalAReceber;
	}

	/**
	 * Retorna o valor total atrasado
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAtrasado(bool $bFiltrarFornecedor = false): float {
		$fValorTotalAtrasado = 0.00;
		$oDataAtual = new \DateTimeImmutable("now");
		$aSituacaoesEmprestimo = [SituacaoEmprestimoEnum::PAGO];

		if ($this->isEmpty()) {
			return $fValorTotalAtrasado;
		}

		/** @var Emprestimo $oEmprestimo */
		/** @var Parcela $oParcela */

		foreach ($this as $oEmprestimo) {
			if ($bFiltrarFornecedor) {
				if ($oEmprestimo->getPessoa()->isCliente()) {
					continue;
				}
			} else {
				if ($oEmprestimo->getPessoa()->isFornecedor()) {
					continue;
				}
			}

			if ($oEmprestimo->isPagamentoParcelado()) {
				$loParcelas = $oEmprestimo->getParcelas();
				if ($loParcelas->isEmpty()) {
					continue;
				}

				foreach ($loParcelas as $oParcela) {
					$oDataPrevisaoPagamento = $oParcela->getDataPrevisaoPagamento();
					$iSituacao = $oParcela->getSituacao();

					if ($oDataPrevisaoPagamento < $oDataAtual && $iSituacao != $aSituacaoesEmprestimo) {
						$fValorTotalAtrasado += $oParcela->getValorDevido();
					}
				}
			} else {
				$oDataPrevisaoPagamento = $oEmprestimo->getDataPrevisaoPagamento();
				$iSituacao = $oEmprestimo->getSituacaoId();

				if ($oDataPrevisaoPagamento < $oDataAtual && $iSituacao != $aSituacaoesEmprestimo) {
					$fValorTotalAtrasado += $oEmprestimo->getValorDevido();
				}
			}
		}

		return $fValorTotalAtrasado;
	}

	/**
	 * Retorna o valor total recebido dos juros
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalJurosRecebido(bool $bFiltrarFornecedor = false): float {
		$fValorTotalJurosRecebido = 0.00;

		if ($this->isEmpty()) {
			return $fValorTotalJurosRecebido;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($bFiltrarFornecedor) {
				if ($oEmprestimo->getPessoa()->isCliente()) {
					continue;
				}
			} else {
				if ($oEmprestimo->getPessoa()->isFornecedor()) {
					continue;
				}
			}

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
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalJurosAReceber(bool $bFiltrarFornecedor = false): float {
		$fValorJurosAReceber = 0.00;

		if ($this->isEmpty()) {
			return $fValorJurosAReceber;
		}

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($bFiltrarFornecedor) {
				if ($oEmprestimo->getPessoa()->isCliente()) {
					continue;
				}
			} else {
				if ($oEmprestimo->getPessoa()->isFornecedor()) {
					continue;
				}
			}

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

	/**
	 * Retorna se possui empréstimo em aberto
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasEmAberto(): bool {
		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() == SituacaoEmprestimoEnum::EM_ABERTO) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Retorna se os empréstimos foram quitados
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isEmprestimosQuitados(): bool {
		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() !== SituacaoEmprestimoEnum::PAGO) {
				return false;
			}
		}

		return true;
	}
}