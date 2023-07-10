<?php

namespace MoneyLender\Src\Cliente;

/**
 * Class ClienteList
 * @package MoneyLender\Src\Cliente
 * @version 1.0.0
 */
class ClienteList extends \SplObjectStorage {

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
	 * Cria uma lista de clientes a partir de um array
	 *
	 * @param array $aaDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ClienteList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aaDados): ClienteList {
		$loClienteList = new ClienteList();

		if (empty($aaDados)) {
			return $loClienteList;
		}

		foreach ($aaDados as $aDados) {
			$oCliente = Cliente::createFromArray($aDados);
			$loClienteList->attach($oCliente);
		}

		return $loClienteList;
	}
}