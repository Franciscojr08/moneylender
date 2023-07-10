<?php

namespace MoneyLender\Src\Sistema;

use MoneyLender\Src\Cliente\ClienteDAO;
use MoneyLender\Src\Cliente\ClienteDAOInterface;
use MoneyLender\Src\Emprestimo\EmprestimoDAO;
use MoneyLender\Src\Emprestimo\EmprestimoDAOInterface;
use MoneyLender\Src\Parcela\ParcelaDAO;
use MoneyLender\Src\Parcela\ParcelaDAOInterface;
use MoneyLender\Src\Sistema\Connection\Connection;
use MoneyLender\Src\Sistema\Connection\ConnectionInterface;

/**
 * Class Sistema
 * @package MoneyLender\Src\Sistema
 * @version 1.0.0
 */
class Sistema {

	/**
	 * Retorna a connection com o database
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ConnectionInterface
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function connection(): ConnectionInterface {
		return new Connection();
	}

	/**
	 * Retorna o DAO de empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoDAOInterface
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function EmprestimoDAO(): EmprestimoDAOInterface {
		return new EmprestimoDAO();
	}

	/**
	 * Retorna o DAO de parcela
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ParcelaDAOInterface
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function ParcelaDAO(): ParcelaDAOInterface {
		return new ParcelaDAO();
	}

	public static function ClienteDAO(): ClienteDAOInterface {
		return new ClienteDAO();
	}
}