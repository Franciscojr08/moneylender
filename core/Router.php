<?php

namespace MoneyLender\Core;

use MoneyLender\Src\Controllers\Sistema\errorController;

/**
 * Class Router
 * @package MoneyLender\Core
 * @version 1.0.0
 */
class Router {

	private array $aDados;

	/**
	 * Router Construtor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct() {
		Session::iniciar();
		$this->attrValues();
	}

	/**
	 * Inicia a rota
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function iniciar(): void {
		$oController = $this->getController();

		try {
			$sAcao = $this->aDados['acao'];
			if (!method_exists($oController,$sAcao)) {
				$oErroController = new errorController();
				$oErroController->paginaNaoEncontrada();

				exit();
			}

			$oController->$sAcao($this->aDados);
		} catch (\Exception $oExp) {
			$oErroController = new errorController();
			$oErroController->errorExeption($oExp->getMessage());

			exit();
		}
	}

	/**
	 * Atribui os valores
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function attrValues(): void {
		$_GET['modulo'] = filter_input(INPUT_GET,"modulo",FILTER_SANITIZE_URL) ?? "gestao";
		$_GET['acao'] = filter_input(INPUT_GET,"acao",FILTER_SANITIZE_URL) ?? "index";
		$_GET['valor'] = filter_input(INPUT_GET,'valor',FILTER_SANITIZE_URL) ?? null;

		$this->aDados = array_merge($_GET,$_POST,$_FILES);
	}

	/**
	 * Retorna a controladora
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return mixed
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getController(): mixed {
		$sController = ucfirst($this->aDados['modulo']) . "\\{$this->aDados['modulo']}Controller";
		$oControllerClass = "MoneyLender\\Src\\Controllers\\$sController";

		if (!class_exists($oControllerClass)) {
			$oErroController = new errorController();
			$oErroController->paginaNaoEncontrada();

			exit();
		}

		return new $oControllerClass();
	}

}