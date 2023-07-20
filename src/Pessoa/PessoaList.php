<?php

namespace MoneyLender\Src\Pessoa;

/**
 * Class ClienteList
 * @package MoneyLender\Src\Pessoa
 * @version 1.0.0
 */
class PessoaList extends \SplObjectStorage {

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
	 * @return PessoaList
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aaDados): PessoaList {
		$loPessoaList = new PessoaList();

		if (empty($aaDados)) {
			return $loPessoaList;
		}

		foreach ($aaDados as $aDados) {
			$oCliente = Pessoa::createFromArray($aDados);
			$loPessoaList->attach($oCliente);
		}

		return $loPessoaList;
	}
}