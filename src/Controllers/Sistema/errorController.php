<?php

namespace MoneyLender\Src\Controllers\Sistema;

/**
 * Class errorController
 * @package MoneyLender\Src\Controllers\Sistema
 * @version 1.0.0
 */
class errorController {

	/**
	 * Renderiza a view de página não encontrada
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function paginaNaoEncontrada(): void {
		require_once "Sistema/notFound.php";
	}

	/**
	 * Renderiza a view de erros lançados por exceção
	 *
	 * @param string $sMensagem
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function errorExeption(string $sMensagem): void {
		require_once "Sistema/errorException.php";
	}

}