<?php

namespace MoneyLender\Src\Emprestimo;

use MoneyLender\Src\Pagamento\PagamentoList;
use MoneyLender\Src\Parcela\ParcelaList;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class Emprestimo
 * @package MoneyLender\Src\Emprestimo
 * @version 1.0.0
 */
class Emprestimo {

	private int $iId;
	private float $fValor;
	private float $fValorPago;
	private float $fValorDevido;
	private float $fTaxaJuros;
	private \DateTimeImmutable $oDataEmprestimo;
	private bool $bPagamentoParcelado;
	private \DateTimeImmutable $oDataPagamentoEmprestimo;
	private \DateTimeImmutable $oDataPrevisaoPagamento;
	private int $iSituacao;
	private Pessoa $oPessoa;
	private ParcelaList $loParcelas;
	private PagamentoList $loPagamentos;
	private \DateTimeImmutable $oDataAtualizacao;

	/**
	 * Cria um objeto de parcela a partir de um array
	 *
	 * @param mixed $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Emprestimo
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(mixed $aDados): Emprestimo {
		$oEmprestimo = new Emprestimo();
		$oEmprestimo->iId = $aDados['emo_id'];
		$oEmprestimo->oPessoa = Sistema::PessoaDAO()->find($aDados['psa_id']);
		$oEmprestimo->fValor = doubleval($aDados['emo_valor']);
		$oEmprestimo->oDataEmprestimo = new \DateTimeImmutable($aDados['emo_data_emprestimo']);
		$oEmprestimo->iSituacao = $aDados['emo_situacao'];

		if (!empty($aDados['emo_valor_pago'])) {
			$oEmprestimo->fValorPago = doubleval($aDados['emo_valor_pago']);
		}

		if (!empty($aDados['emo_valor_devido'])) {
			$oEmprestimo->fValorDevido = doubleval($aDados['emo_valor_devido']);
		}

		if (!empty($aDados['emo_taxa_juros'])) {
			$oEmprestimo->fTaxaJuros = $aDados['emo_taxa_juros'];
		}

		if ($aDados['emo_pagamento_parcelado'] != SimNaoEnum::NAO ) {
			$oEmprestimo->bPagamentoParcelado = $aDados['emo_pagamento_parcelado'];
		}

		if ($aDados['emo_pagamento_parcelado'] != SimNaoEnum::NAO && !empty($aDados['emo_data_pagamento'])) {
			$oEmprestimo->oDataPagamentoEmprestimo = $aDados['emo_data_pagamento'];
		}

		if ($aDados['emo_pagamento_parcelado'] != SimNaoEnum::NAO && !empty($aDados['emo_data_previsao_pagamento'])) {
			$oEmprestimo->oDataPrevisaoPagamento = $aDados['emo_data_previsao_pagamento'];
		}

		if (!empty($aDados['emo_data_atualizacao'])) {
			$oEmprestimo->oDataAtualizacao = new \DateTimeImmutable($aDados['emo_data_atualizacao']);
		}

		$loParcelas = Sistema::ParcelaDAO()->findByEmprestimo($oEmprestimo);
		if (!$loParcelas->isEmpty()) {
			$oEmprestimo->loParcelas = $loParcelas;
		}

		return $oEmprestimo;
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
	 * Retorna a taxa de juros
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getTaxaJuros(): float {
		return $this->fTaxaJuros;
	}

	/**
	 * Retorna se o empréstimo possui taxa de juros
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasTaxaJuros(): bool {
		return !empty($this->fTaxaJuros);
	}

	/**
	 * Atribui a taxa de juros
	 *
	 * @param float $fTaxaJuros
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setTaxaJuros(float $fTaxaJuros): void {
		$this->fTaxaJuros = $fTaxaJuros;
	}

	/**
	 * Retorna a data do empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataEmprestimo(): \DateTimeImmutable {
		return $this->oDataEmprestimo;
	}

	/**
	 * Atribui a data de empréstimo
	 *
	 * @param \DateTimeImmutable $oDataEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataEmprestimo(\DateTimeImmutable $oDataEmprestimo): void {
		$this->oDataEmprestimo = $oDataEmprestimo;
	}

	/**
	 * Retorna se o pagamento é parcelado
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isPagamentoParcelado(): bool {
		return $this->bPagamentoParcelado;
	}

	/**
	 * Atribui se o pagamento é parcelado
	 *
	 * @param bool $bPagamentoParcelado
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setPagamentoParcelado(bool $bPagamentoParcelado): void {
		$this->bPagamentoParcelado = $bPagamentoParcelado;
	}

	/**
	 * Retorna a data do empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataPagamentoEmprestimo(): \DateTimeImmutable {
		return $this->oDataPagamentoEmprestimo;
	}

	/**
	 * Atribui a data do empréstimo
	 *
	 * @param \DateTimeImmutable $oDataPagamentoEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataPagamentoEmprestimo(\DateTimeImmutable $oDataPagamentoEmprestimo): void {
		$this->oDataPagamentoEmprestimo = $oDataPagamentoEmprestimo;
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
	public function getSituacaoId(): int {
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
		return SituacaoEmprestimoEnum::getDescricaoById($this->iSituacao);
	}

	/**
	 * Atribui a situação
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
	 * Retorna o cliente
	 *
	 * @return Pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getPessoa(): Pessoa {
		return $this->oPessoa;
	}

	/**
	 * Atribui o client
	 *
	 * @param Pessoa $oPessoa
	 * @return void
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setPessoa(Pessoa $oPessoa): void {
		$this->oPessoa = $oPessoa;
	}

	/**
	 * Retorna as parcelas
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return ParcelaList
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getParcelas(): ParcelaList {
		return $this->loParcelas;
	}

	/**
	 * Atribui as parcelas
	 *
	 * @param ParcelaList $loParcelas
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setParcelas(ParcelaList $loParcelas): void {
		$this->loParcelas = $loParcelas;
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

	/**
	 * Retorna o valor do juros
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorJuros(): float {
		if ($this->fTaxaJuros == 0.00) {
			return 0.00;
		}

		return ($this->fValor * ($this->fTaxaJuros / 100));
	}

	/**
	 * Retorna o valor com a taxa de juros
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorComJuros(): float {
		if ($this->fTaxaJuros == 0.00) {
			return $this->fValor;
		}

		return ($this->fValor + ($this->fValor * ($this->fTaxaJuros / 100)));
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
	 * Atribui a data de atualização
	 *
	 * @param \DateTimeImmutable $oDataAtualizacao
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataAtualizacao(\DateTimeImmutable $oDataAtualizacao): void {
		$this->oDataAtualizacao = $oDataAtualizacao;
	}

}