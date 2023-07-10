<?php

namespace MoneyLender\Src\Pagamento;

use MoneyLender\Src\Parcela\ParcelaList;

/**
 * Class PagamentoList
 * @package MoneyLender\Src\Pagamento
 * @version 1.0.0
 */
class PagamentoList extends \SplObjectStorage {

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
	 * Cria uma lista de pagamentos a partir de um array
	 *
	 * @param array $aaDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return PagamentoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aaDados): PagamentoList {
		$loPagamentos = new PagamentoList();

		if (empty($aaDados)) {
			return $loPagamentos;
		}
		
		foreach ($aaDados as $aDados) {
			$oPagamento = Pagamento::createFromArray($aDados);
			$loPagamentos->attach($oPagamento);
		}

		return $loPagamentos;
	}
}