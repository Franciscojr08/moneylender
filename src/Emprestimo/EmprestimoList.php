<?php

namespace MoneyLender\Src\Emprestimo;

use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Enum\SituacaoParcelaEnum;
use MoneyLender\Src\Sistema\Sistema;

class EmprestimoList extends \SplObjectStorage {

	/**
	 * Retorna se a lista está vazia
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isEmpty(): bool {
		return $this->count() == 0;
	}

	/**
	 * Cria uma lista de empréstimo a partir de um array
	 *
	 * @param array $aaDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aaDados): EmprestimoList {
		$loEmprestimoList = new EmprestimoList();

		if (empty($aaDados)) {
			return $loEmprestimoList;
		}

		foreach ($aaDados as $aDados) {
			$oEmprestimo = Emprestimo::createFromArray($aDados);
			$loEmprestimoList->attach($oEmprestimo);
		}

		return $loEmprestimoList;
	}

	/**
	 * Retorna se possui empréstimo em aberto
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasEmAberto(): bool {
		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() == SituacaoEmprestimoEnum::EM_ABERTO) {
				return true;
			}
		}

		return false;
	}

	/**
	 * Retorna se os empréstimos foram quitados
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isEmprestimosQuitados(): bool {
		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() !== SituacaoEmprestimoEnum::PAGO) {
				return false;
			}
		}

		return true;
	}

	/**
	 * Retorna a quantidade de empréstimos em aberto
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getQuantidadeEmAberto(): int {
		$iTotal = 0;

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() == SituacaoEmprestimoEnum::EM_ABERTO){
				$iTotal++;
			}
		}

		return $iTotal;
	}

	/**
	 * Retorna a quantidade de empréstimos atrasados
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getQuantidadeAtrasado(): int{
		$iTotal = 0;

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() == SituacaoEmprestimoEnum::ATRASADO){
				$iTotal++;
			}
		}

		return $iTotal;
	}

	/**
	 * Retorna a quantidade de empréstimos pagos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getQuantidadePago(): int {
		$iTotal = 0;

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() == SituacaoEmprestimoEnum::PAGO){
				$iTotal++;
			}
		}

		return $iTotal;
	}

	/**
	 * Retorna a quantidade total de empréstimos cancelados
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getQuantidadeCancelado(): int {
		$iTotal = 0;

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			if ($oEmprestimo->getSituacaoId() == SituacaoEmprestimoEnum::CANCELADO){
				$iTotal++;
			}
		}

		return $iTotal;
	}

	/**
	 * Retorna o combo dos empréstimos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getArrayCombo(): array {
		$aaEmprestimo = [];

		/** @var Emprestimo $oEmprestimo */
		foreach ($this as $oEmprestimo) {
			$fValor = number_format($oEmprestimo->getValorComJuros(),"2",",",".");
			$sData = $oEmprestimo->getDataEmprestimo()->format("d/m/Y");
			$sDescricao = "Cód. Emp.: {$oEmprestimo->getId()} - R$ $fValor - $sData";

			$aaEmprestimo[] = [
				"valor" => $oEmprestimo->getId(),
				"descricao" => $sDescricao
			];
		}

		return $aaEmprestimo;
	}
}