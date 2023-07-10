<?php

namespace MoneyLender\Src\Pagamento;

use MoneyLender\Src\Sistema\Enum\FormaPagamentoEnum;

/**
 * Class Pagamento
 * @package MoneyLender\Src\Pagamento
 * @version 1.0.0
 */
class Pagamento {

	private int $iId;
	private float $fValor;
	private \DateTimeImmutable $oDataPagamento;
	private int $iFormaPagamento;

	/**
	 * Cria um objeto pagamento a partir de um array
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Pagamento
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aDados): Pagamento {
		$oPagamento = new Pagamento();
		$oPagamento->iId = $aDados['pgo_id'];
		$oPagamento->fValor = doubleval($aDados['pgo_valor']);
		$oPagamento->oDataPagamento = new \DateTimeImmutable($aDados['pgo_data_pagamento']);
		$oPagamento->iFormaPagamento = $aDados['pgo_forma_pagamento'];

		return $oPagamento;
	}

	/**
	 * Retorna o Id
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getId(): int {
		return $this->iId;
	}

	/**
	 * Atribui o Id
	 *
	 * @param int $iId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setId(int $iId): void {
		$this->iId = $iId;
	}

	/**
	 * Retorna o valor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValor(): float {
		return $this->fValor;
	}

	/**
	 * Atribui o valor
	 *
	 * @param float $fValor
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setValor(float $fValor): void {
		$this->fValor = $fValor;
	}

	/**
	 * Retorna a data de pagamento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataPagamento(): \DateTimeImmutable {
		return $this->oDataPagamento;
	}

	/**
	 * Atribui a data de pagamento
	 *
	 * @param \DateTimeImmutable $oDataPagamento
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataPagamento(\DateTimeImmutable $oDataPagamento): void {
		$this->oDataPagamento = $oDataPagamento;
	}

	/**
	 * Retorna o Id da forma de pagamento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getFormaPagamentoId(): int {
		return $this->iFormaPagamento;
	}

	/**
	 * Retorna a descrição da forma de pagamento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDescricaoFormaPagamento(): string {
		return FormaPagamentoEnum::getDescricaoById($this->iFormaPagamento);
	}

	/**
	 * Atribui a forma de pagamento
	 *
	 * @param int $iFormaPagamento
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setFormaPagamento(int $iFormaPagamento): void {
		$this->iFormaPagamento = $iFormaPagamento;
	}

}