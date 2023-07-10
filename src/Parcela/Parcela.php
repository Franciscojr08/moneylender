<?php

namespace MoneyLender\Src\Parcela;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Pagamento\PagamentoList;
use MoneyLender\Src\Sistema\Enum\SituacaoParcelaEnum;
use MoneyLender\Src\Sistema\Sistema;

class Parcela {

	private int $iId;
	private float $fValor;
	private float $fValorPago;
	private float $fValorDevido;
	private \DateTimeImmutable $oDataCadastro;
	private \DateTimeImmutable $oDataPagamento;
	private \DateTimeImmutable $oDataPrevisaoPagamento;
	private int $iSituacao;
	private Emprestimo $oEmprestimo;
	private PagamentoList $loPagamentos;

	/**
	 * Cria um objeto de parcela a partir de um array
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Parcela
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aDados): Parcela {
		$oParcela = new Parcela();
		$oParcela->iId = $aDados['pra_id'];
		$oParcela->fValor = doubleval($aDados['pra_valor']);
		$oParcela->oDataCadastro = new \DateTimeImmutable($aDados['pra_data_cadastro']);
		$oParcela->iSituacao = $aDados['pra_data_cadastro'];
		$oParcela->oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['emo_id']);
		$oParcela->oDataPrevisaoPagamento = new \DateTimeImmutable($aDados['pra_data_previsao_pagamento']);

		if (!empty($aDados['pra_valor_pago'])) {
			$oParcela->fValorPago = doubleval($aDados['pra_valor_pago']);
		}

		if (!empty($aDados['pra_valor_devido'])) {
			$oParcela->fValorPago = doubleval($aDados['pra_valor_devido']);
		}

		if (!empty($aDados['pra_data_pagamento'])) {
			$oParcela->oDataPagamento = new \DateTimeImmutable($aDados['pra_data_pagamento']);
		}

		return $oParcela;
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
	 * Retorna o valor pago
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorPago(): float {
		return $this->fValorPago;
	}

	/**
	 * Atribui o valor pago
	 *
	 * @param float $fValorPago
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setValorPago(float $fValorPago): void {
		$this->fValorPago = $fValorPago;
	}

	/**
	 * Retorna o valor devido
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorDevido(): float {
		return $this->fValorDevido;
	}

	/**
	 * Atribui o valor devido
	 *
	 * @param float $fValorDevido
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setValorDevido(float $fValorDevido): void {
		$this->fValorDevido = $fValorDevido;
	}

	/**
	 * Retorna a data de cadastro
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataCadastro(): \DateTimeImmutable {
		return $this->oDataCadastro;
	}

	/**
	 * Atribui a data de cadastro
	 *
	 * @param \DateTimeImmutable $oDataCadastro
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataCadastro(\DateTimeImmutable $oDataCadastro): void {
		$this->oDataCadastro = $oDataCadastro;
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
	 * Retorna a data de previsão de pagamento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataPrevisaoPagamento(): \DateTimeImmutable {
		return $this->oDataPrevisaoPagamento;
	}

	/**
	 * Atribui a data de previsão de pagamento
	 *
	 * @param \DateTimeImmutable $oDataPrevisaoPagamento
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataPrevisaoPagamento(\DateTimeImmutable $oDataPrevisaoPagamento): void {
		$this->oDataPrevisaoPagamento = $oDataPrevisaoPagamento;
	}

	/**
	 * Retorna o Id da situação
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getSituacao(): int {
		return $this->iSituacao;
	}

	/**
	 * Retorna a descrição da situação
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDescricaoSituacao(): string {
		return SituacaoParcelaEnum::getDescricaoById($this->iSituacao);
	}

	/**
	 * Atribui o Id da situação
	 *
	 * @param int $iSituacao
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setSituacao(int $iSituacao): void {
		$this->iSituacao = $iSituacao;
	}

	/**
	 * Retorna o Empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Emprestimo
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getEmprestimo(): Emprestimo {
		return $this->oEmprestimo;
	}

	/**
	 * Atribui o Empréstimo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setEmprestimo(Emprestimo $oEmprestimo): void {
		$this->oEmprestimo = $oEmprestimo;
	}

	/**
	 * Retorna os pagamentos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return PagamentoList
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getPagamentos(): PagamentoList {
		return $this->loPagamentos;
	}

	/**
	 * Retorna se possui pagamentos
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasPagamentos(): bool {
		return !empty($this->loPagamentos);
	}

	/**
	 * Atribui os pagamentos
	 *
	 * @param PagamentoList $loPagamentos
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setPagamentos(PagamentoList $loPagamentos): void {
		$this->loPagamentos = $loPagamentos;
	}

}