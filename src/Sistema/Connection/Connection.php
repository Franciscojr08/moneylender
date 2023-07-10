<?php

namespace MoneyLender\Src\Sistema\Connection;

use PDO;

/**
 * Class Connection
 * @package MoneyLender\Src\Sistema
 * @version 1.0.0
 */
class Connection implements ConnectionInterface {
	private PDO $oPDO;

	/**
	 * Connection Constructor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct() {
		$sDriver = 'mysql';
		$sHost = 'mysql';
		$sUser = 'root';
		$sPassword = 'moneylender@!#';
		$sDatabase = 'moneylender';

		$oConexao = new PDO("$sDriver:host=$sHost;dbname=$sDatabase", $sUser, $sPassword);
		$oConexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		$this->oPDO = $oConexao;
	}

	/**
	 * Executa uma query sql
	 *
	 * @param string $sSql
	 * @param array|null $aParams
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function execute(string $sSql, array $aParams = null): bool {
		$oSttm = $this->oPDO->prepare($sSql);

		if (!empty($aParams)) {
			foreach ($aParams as $iKey => $aParam) {
				$iContador = 1 + $iKey;
				$oSttm->bindValue($iContador,$aParam);
			}
		}

		try {
			return $oSttm->execute();
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os dados.",0,$oExp);
		}
	}

	/**
	 * Retorna um array com os dados consultados
	 *
	 * @param string $sSql
	 * @param array|null $aParams
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getArray(string $sSql, array $aParams = null): array {
		$oSttm = $this->oPDO->prepare($sSql);

		if (!empty($aParams)) {
			foreach ($aParams as $iKey => $aParam) {
				$iContador = 1 + $iKey;
				$oSttm->bindValue($iContador,$aParam);
			}
		}

		try {
			$oSttm->execute();
			return $oSttm->fetchAll();
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os dados.",0,$oExp);
		}
	}

	/**
	 * Retorna a linha da consulta
	 *
	 * @param string $sSql
	 * @param array|null $aParams
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getRow(string $sSql, array $aParams = null): array {
		$oSttm = $this->oPDO->prepare($sSql);

		if (!empty($aParams)) {
			foreach ($aParams as $iKey => $aParam) {
				$iContador = 1 + $iKey;
				$oSttm->bindValue($iContador,$aParam);
			}
		}

		try {
			$oSttm->execute();
			return $oSttm->fetch();
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os dados.",0,$oExp);
		}
	}
}