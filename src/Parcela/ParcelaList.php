<?php

namespace MoneyLender\Src\Parcela;

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
			if ($oParcela->hasPagamentos()) {
				$loParcelasPagas->attach($oParcela);
			}
		}

		return $loParcelasPagas;
	}
}