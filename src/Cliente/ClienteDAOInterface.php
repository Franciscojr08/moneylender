<?php

namespace MoneyLender\Src\Cliente;

/**
 * Interface ClienteDAOInterface
 * @package MoneyLender\Src\Cliente
 * @version 1.0.0
 */
interface ClienteDAOInterface {

	/**
	 * Consulta o cliente pelo id
	 *
	 * @param int $iCleId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Cliente
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iCleId): Cliente;
}