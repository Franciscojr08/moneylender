<?php

namespace MoneyLender\Core;

/**
 * Class Session
 * @package PortalQualidade\Core
 * @version 1.0.0
 */
class Session {

	/**
	 * Session Construtor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct() {
		self::iniciar();
	}

	/**
	 * Verifica se a sessão foi iniciada, se não foi é iniciada uma sessão
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function iniciar(): void {
		if (session_status() !== PHP_SESSION_ACTIVE) {
			session_start();
		}
	}

	/**
	 * Atribui a mensagem na sessão
	 *
	 * @param string $sMensagem
	 * @param string $sTipo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function setMensagem(string $sMensagem, string $sTipo): void {
		$_SESSION['mensagem'] = $sMensagem;
		$_SESSION['tipo_mensagem'] = $sTipo;
	}

	/**
	 * Verifica se possui mensagem na sessão
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function hasMensagem(): bool {
		return !empty($_SESSION['mensagem']);
	}

	/**
	 * Retorna a mensagem atribuída na sessão
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function getMensagem(): string {
		return $_SESSION['mensagem'];
	}

	/**
	 * Retorna o tipo da mensagem
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function getTipoMensagem(): string {
		return $_SESSION['tipo_mensagem'];
	}

	/**
	 * Remove a mensagem da sessão
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function removerMensagem(): void {
		unset($_SESSION['mensagem']);
		unset($_SESSION['tipo_mensagem']);
	}
}