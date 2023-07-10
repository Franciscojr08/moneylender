<?php

namespace MoneyLender\Src\Emprestimo;

use MoneyLender\Src\Cliente\Cliente;
use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Sistema\Sistema;

class EmprestimoDAO implements EmprestimoDAOInterface {

	/**
	 * Consulta todos em empréstimos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(): EmprestimoList {
		$sSql = "SELECT * FROM emo_emprestimo";

		try {
			$aaEmprestimos = Sistema::connection()->getArray($sSql);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os empréstimos.");
		}

		if (empty($aaEmprestimos)) {
			return new EmprestimoList();
		}

		return EmprestimoList::createFromArray($aaEmprestimos);
	}

	/**
	 * Consulta um empréstimo pelo Id
	 *
	 * @param int $iEmoId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Emprestimo
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iEmoId): Emprestimo {
		$sSql = "SELECT * FROM emo_emprestimo WHERE emo_id = ?";
		$aParam[] = $iEmoId;

		try {
			$aEmprestimo = Sistema::connection()->getRow($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar o empréstimo.");
		}

		if (empty($aEmprestimo)) {
			throw new \Exception("Nenhum empréstimo encontrado para a parcela.");
		}

		return Emprestimo::createFromArray($aEmprestimo);
	}

	/**
	 * Consulta os emprestimos do cliente
	 *
	 * @param Cliente $oCliente
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByCliente(Cliente $oCliente): EmprestimoList {
		$sSql = "SELECT
					emo.*
				FROM
					emo_emprestimo emo
				WHERE
					emo.cle_id = ?";

		$aParam[] = $oCliente->getId();

		try {
			$aaEmprestimos = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar os empréstimos do cliente.");
		}

		if (empty($aaEmprestimos)) {
			return new EmprestimoList();
		}

		return EmprestimoList::createFromArray($aaEmprestimos);
	}
}