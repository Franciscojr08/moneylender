<?php

namespace MoneyLender\Src\Sistema\Connection;

/**
 * Interface ConnectionInterface
 * @package MoneyLender\Src\Sistema\Connection
 * @version 1.0.0
 */
interface ConnectionInterface {

	/**
	 * Inicia uma transação
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function begin(): void;

	/**
	 * Confirma uma transação
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function commit(): void;

	/**
	 * Desfaz uma transação
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function rollBack(): void;

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
	public function execute(string $sSql, array $aParams = null): bool;
	
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
	public function getArray(string $sSql, array $aParams = null): array;

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
	public function getRow(string $sSql, array $aParams = null): array;

	/**
	 * Retorna o último Id inserido
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getLasInsertId(): int;
}