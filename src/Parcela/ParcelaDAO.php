<?php

namespace MoneyLender\Src\Parcela;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Sistema\Sistema;

class ParcelaDAO implements ParcelaDAOInterface {

	/**
	 * Consulta as parcelas pelo empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ParcelaList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByEmprestimo(Emprestimo $oEmprestimo): ParcelaList {
		$sSql = "SELECT * FROM pra_parcela WHERE emo_id = ?";
		$aParam[] = $oEmprestimo->getId();

		try {
			$aaParcelas = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new \Exception("Não foi possível consultar as parcelas.");
		}

		if (empty($aaParcelas)) {
			return new ParcelaList();
		}

		return ParcelaList::createFromArray($aaParcelas);
	}
}