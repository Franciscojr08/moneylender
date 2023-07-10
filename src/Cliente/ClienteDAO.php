<?php

namespace MoneyLender\Src\Cliente;

use MoneyLender\Src\Sistema\Sistema;

/**
 * Class ClienteDAO
 * @package MoneyLender\Src\Cliente
 * @version 1.0.0
 */
class ClienteDAO implements ClienteDAOInterface {

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
	public function find(int $iCleId): Cliente {
		$sSql = "SELECT * FROM cle_cliente WHERE cle_id = ?";
		$aParam[] = $iCleId;
		
		try {
			$aCliente = Sistema::connection()->getRow($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar o cliente.");
		}

		if (empty($aCliente)) {
			throw new \Exception("Nenhum cliente encontrado.");
		}

		return Cliente::createFromArray($aCliente);
	}
}