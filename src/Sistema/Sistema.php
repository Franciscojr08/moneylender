<?php

namespace MoneyLender\Src\Sistema;

use MoneyLender\Src\Pagamento\PagamentoDAO;
use MoneyLender\Src\Pagamento\PagamentoDAOInterface;
use MoneyLender\Src\Pessoa\PessoaDAO;
use MoneyLender\Src\Pessoa\PessoaDAOInterface;
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

	/**
	 * Retorna o DAO de pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return PessoaDAOInterface
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function PessoaDAO(): PessoaDAOInterface {
		return new PessoaDAO();
	}

	/**
	 * Retorna o DAO de pagamento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return PagamentoDAOInterface
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function PagamentoDAO(): PagamentoDAOInterface {
		return new PagamentoDAO();
	}
}