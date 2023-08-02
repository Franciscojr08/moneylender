<?php

namespace MoneyLender\Src\Parcela;

use MoneyLender\Src\Sistema\Enum\SituacaoParcelaEnum;
use MoneyLender\Src\Sistema\Sistema;

class ParcelaList extends \SplObjectStorage {

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
	 * Cria uma lista de parcelas a partir de um array
	 *
	 * @param array $aaDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ParcelaList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aaDados): ParcelaList {
		$loParcelas = new ParcelaList();

		if (empty($aaDados)) {
			return $loParcelas;
		}

		foreach ($aaDados as $aDados) {
			$oParcela = Parcela::createFromArray($aDados);
			$loParcelas->attach($oParcela);
		}

		return $loParcelas;
	}

	/**
	 * Retorna as parcelas pagas
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ParcelaList
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getParcelasPagas(): ParcelaList {
		$loParcelasPagas = new ParcelaList();

		if (empty($this)) {
			return $loParcelasPagas;
		}

		/** @var Parcela $oParcela */
		foreach ($this as $oParcela) {
			if ($oParcela->getSituacao() == SituacaoParcelaEnum::PAGA) {
				$loParcelasPagas->attach($oParcela);
			}
		}

		return $loParcelasPagas;
	}

	/**
	 * Retorna o combo das parcelas não pagas
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return array
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getComboNaoPagas(): array {
		$aParcelas = [];

		/** @var Parcela $oParcela */
		foreach ($this as $oParcela) {
			if ($oParcela->getSituacao() == SituacaoParcelaEnum::PAGA) {
				continue;
			}

			$aParcelas[] = [
				"valor" => $oParcela->getId(),
				"descricao" => "{$oParcela->getSequenciaParcela()}ª Parcela"
			];
		}

		return $aParcelas;
	}

	/**
	 * Retorna se alguma parcela possui pagamentos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasPagamento(): bool {
		/** @var Parcela $oParcela */
		foreach ($this as $oParcela) {
			if ($oParcela->hasPagamentos()) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Retorna a primeira parcela
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Parcela
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function first(): Parcela {
		$iPraId = 0;

		foreach ($this as $oParcela) {
			$iPraId = $oParcela->getId();
			break;
		}

		return Sistema::ParcelaDAO()->find($iPraId);
	}
}