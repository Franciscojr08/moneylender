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
	private \DateTimeImmutable $oDataAtualizacao;
	private \DateTimeImmutable $oDataPrevisaoPagamento;
	private int $iSituacao;
	private int $iSequenciaParcela;
	private int $oEmprestimoId;
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
		$oParcela->fValor = floatval($aDados['pra_valor']);
		$oParcela->fValorPago = floatval($aDados['pra_valor_pago']);
		$oParcela->fValorDevido = floatval($aDados['pra_valor_devido']);
		$oParcela->oDataCadastro = new \DateTimeImmutable($aDados['pra_data_cadastro']);
		$oParcela->iSituacao = $aDados['pra_situacao'];
		$oParcela->iSequenciaParcela = $aDados['pra_sequencia_parcela'];
		$oParcela->oEmprestimoId = $aDados['emo_id'];
		$oParcela->oDataPrevisaoPagamento = new \DateTimeImmutable($aDados['pra_data_previsao_pagamento']);

		if (!empty($aDados['pra_data_atualizacao'])) {
			$oParcela->oDataAtualizacao = new \DateTimeImmutable($aDados['pra_data_atualizacao']);
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
	 * Retorna a data de atualização
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataAtualizacao(): \DateTimeImmutable {
		return $this->oDataAtualizacao;
	}

	/**
	 * Retorna se possui atualização
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasAtualizacao(): bool {
		return !empty($this->oDataAtualizacao);
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
	 * Retorna a sequencia da parcela
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getSequenciaParcela(): int {
		return $this->iSequenciaParcela;
	}

	/**
	 * Atribui a sequencia da parcela
	 *
	 * @param int $iSequenciaParcela
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setSequenciaParcela(int $iSequenciaParcela): void {
		$this->iSequenciaParcela = $iSequenciaParcela;
	}

	/**
	 * Retorna o Empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Emprestimo
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getEmprestimo(): Emprestimo {
		return Sistema::EmprestimoDAO()->find($this->oEmprestimoId);
	}

	/**
	 * Atribui o Empréstimo
	 *
	 * @param int $oEmprestimoId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setEmprestimo(int $oEmprestimoId): void {
		$this->oEmprestimoId = $oEmprestimoId;
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
		return $this->fValorPago > 0.0;
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

	/**
	 * Cadastra uma parcela
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cadastrar(): bool {
		$this->oDataCadastro = new \DateTimeImmutable("now");

		return Sistema::ParcelaDAO()->save($this);
	}

	/**
	 * Atualiza uma parcela
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function atualizar(): void {
		if ($this->fValorDevido == 0.0 && $this->fValorPago == $this->fValor) {
			$this->iSituacao = SituacaoParcelaEnum::PAGA;
		}

		$this->oDataAtualizacao = new \DateTimeImmutable("now");
		Sistema::ParcelaDAO()->update($this);
	}
}