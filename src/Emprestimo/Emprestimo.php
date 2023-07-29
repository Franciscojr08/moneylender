<?php

namespace MoneyLender\Src\Emprestimo;

use MoneyLender\Src\Pagamento\Pagamento;
use MoneyLender\Src\Pagamento\PagamentoList;
use MoneyLender\Src\Parcela\Parcela;
use MoneyLender\Src\Parcela\ParcelaList;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Enum\SituacaoParcelaEnum;
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
	private float $fValorJuros;
	private \DateTimeImmutable $oDataEmprestimo;
	private bool $bPagamentoParcelado;
	private \DateTimeImmutable $oDataPagamentoEmprestimo;
	private \DateTimeImmutable $oDataPrevisaoPagamento;
	private int $iSituacao;
	private int $iPessoaId;
	private ParcelaList $loParcelas;
	private PagamentoList $loPagamentos;
	private \DateTimeImmutable $oDataCadastro;
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
		$oEmprestimo->iPessoaId = $aDados['psa_id'];
		$oEmprestimo->fValor = doubleval($aDados['emo_valor']);
		$oEmprestimo->iSituacao = $aDados['emo_situacao'];
		$oEmprestimo->oDataEmprestimo = new \DateTimeImmutable($aDados['emo_data_emprestimo']);
		$oEmprestimo->oDataCadastro = new \DateTimeImmutable($aDados['emo_data_cadastro']);
		$oEmprestimo->fValorPago = doubleval($aDados['emo_valor_pago']);

		if (!empty($aDados['emo_valor_devido'])) {
			$oEmprestimo->fValorDevido = doubleval($aDados['emo_valor_devido']);
		}

		if (!empty($aDados['emo_taxa_juros'])) {
			$oEmprestimo->fTaxaJuros = $aDados['emo_taxa_juros'];
		}

		if (!empty($aDados['emo_taxa_juros']) && !empty($aDados['emo_valor_juros'])) {
			$oEmprestimo->fValorJuros = $aDados['emo_valor_juros'];
		}

		if ($aDados['emo_pagamento_parcelado'] != SimNaoEnum::NAO ) {
			$oEmprestimo->bPagamentoParcelado = true;
		}

		if ($aDados['emo_pagamento_parcelado'] != SimNaoEnum::SIM && !empty($aDados['emo_data_pagamento'])) {
			$oEmprestimo->oDataPagamentoEmprestimo = $aDados['emo_data_pagamento'];
		}

		if ($aDados['emo_pagamento_parcelado'] != SimNaoEnum::SIM && !empty($aDados['emo_data_previsao_pagamento'])) {
			$oEmprestimo->bPagamentoParcelado = false;
			$oEmprestimo->oDataPrevisaoPagamento = new \DateTimeImmutable($aDados['emo_data_previsao_pagamento']);
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
		$fValorTotal = $this->getValor() + $this->getValorJuros();

		return $fValorTotal - $this->fValorPago;
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
	 * @author Francisco Santos franciscojuniordh@gmail.com
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
	 * Retorna o valor do juros
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorJuros(): float {
		if (!$this->hasTaxaJuros()) {
			return 0.0;
		}

		return $this->fValorJuros;
	}

	/**
	 * Atribui o valor do juros
	 *
	 * @param float $fValorJuros
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setValorJuros(float $fValorJuros): void {
		$this->fValorJuros = $fValorJuros;
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
	 * Retorna a pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return Pessoa
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getPessoa(): Pessoa {
		return Sistema::PessoaDAO()->find($this->iPessoaId);
	}

	/**
	 * Atribui o client
	 *
	 * @param int $iPessoaId
	 * @return void
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setPessoaId(int $iPessoaId): void {
		$this->iPessoaId = $iPessoaId;
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
	 * Retorna o valor com a taxa de juros
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorComJuros(): float {
		return $this->fValor + $this->getValorJuros();
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

	/**
	 * Cadastra um empréstimo
	 *
	 * @param array $aEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cadastrar(array $aEmprestimo): bool {
		$this->oDataCadastro = new \DateTimeImmutable("now");
		$bEmprestimoCadastrado = Sistema::EmprestimoDAO()->save($this);

		if (!$bEmprestimoCadastrado) {
			throw new \Exception("Não foi possível cadastrar o empréstimo.");
		}

		if ($this->isPagamentoParcelado()){
			$bPrimeiraParcelaJaCadastrada = false;
			$iQuantidadeParcelas = $aEmprestimo['emo_quantidade_parcelas'];
			$fValorDevido = round($this->getValorDevido(),2);
			$iValorMaximo = $fValorDevido;

			$oPrimeiraParcela = new \DateTimeImmutable($aEmprestimo['pra_data_previsao_pagamento']);
			$iDia = $oPrimeiraParcela->format("d");
			$iMes = $oPrimeiraParcela->format("m");
			$iAno = $oPrimeiraParcela->format("Y");

			for ($i = 0; $i < $iQuantidadeParcelas; $i++) {
				$fValorParcela = $this->calcularParcela($fValorDevido,$iQuantidadeParcelas, $iValorMaximo);

				$oParcela = new Parcela();
				$oParcela->setEmprestimo($this->iId);
				$oParcela->setValor($fValorParcela);
				$oParcela->setValorDevido($fValorParcela);
				$oParcela->setValorPago(0.0);
				$oParcela->setSituacao(SituacaoParcelaEnum::EM_ABERTA);
				$oParcela->setSequenciaParcela($i + 1);

				if (!$bPrimeiraParcelaJaCadastrada) {
					$oParcela->setDataPrevisaoPagamento($oPrimeiraParcela);
					$bPrimeiraParcelaJaCadastrada = true;
				} else {
					$iMes++;
					if ($iMes > 12) {
						$iMes = 1;
						$iAno++;
					}

					$sData = "$iAno/$iMes/$iDia";
					$oParcela->setDataPrevisaoPagamento(new \DateTimeImmutable($sData));
				}

				if (!$oParcela->cadastrar()) {
					throw new \Exception("Não foi possível cadastrar a parcela do empréstimo.");
				}
				$iValorMaximo -= $fValorParcela;
			}
		}

		return true;
	}

	/**
	 * Atualiza um empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function atualizar(): void {
		if ($this->fValorDevido == 0.0 && $this->fValorPago == $this->getValorComJuros()) {
			$this->iSituacao = SituacaoEmprestimoEnum::PAGO;
		}

		$this->oDataAtualizacao = new \DateTimeImmutable("now");
		Sistema::EmprestimoDAO()->update($this);
	}

	/**
	 * Lança o pagamento de um empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function lancarPagamento(array $aDados): bool {
		$aDados = array_merge($aDados,['emo_id' => $this->getId()]);
		$fValorPagamento = round($aDados['pgo_valor'],2);
		$this->validarPagamento($fValorPagamento);

		$oPagamento = new Pagamento();
		$oPagamento->setDataPagamento(new \DateTimeImmutable("now"));
		$oPagamento->setFormaPagamento($aDados['pgo_forma_pagamento']);
		$oPagamento->setValor($fValorPagamento);

		if (!$oPagamento->cadastrar($aDados)) {
			throw new \Exception("Não foi possível lançar o pagamento.");
		}

		$this->setValorDevido(round($this->getValorDevido(),2) - $fValorPagamento);
		$this->setValorPago(round($this->getValorPago(),2) + $fValorPagamento);
		$this->atualizar();

		if ($this->isPagamentoParcelado()) {
			$oParcela = Sistema::ParcelaDAO()->find($aDados['pra_id']);
			$oParcela->setValorDevido( round($oParcela->getValorDevido(),2) - $fValorPagamento);
			$oParcela->setValorPago(round($oParcela->getValorPago(),2) + $fValorPagamento);
			$oParcela->atualizar();
		}

		return true;
	}

	/**
	 * Valida o valor do pagamento
	 *
	 * @param float $fValorPagamento
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function validarPagamento(float $fValorPagamento): void {
		if ($fValorPagamento > $this->getValorDevido()) {
			throw new \Exception("O valor do pagamento não pode ser maior que o valor devido.");
		}

		if ($fValorPagamento < 0.1) {
			throw new \Exception("O valor do pagamento deve ser maior que zero.");
		}
	}

	/**
	 * Calcula o valor da parcela
	 *
	 * @param int $fValorEmprestimo
	 * @param int $iNumeroParcelas
	 * @param float $fValorMaximo
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function calcularParcela(int $fValorEmprestimo, int $iNumeroParcelas, float $fValorMaximo): float {
		$fValorParcela = round($fValorEmprestimo / $iNumeroParcelas,2);
		$fValorMaximo = round($fValorMaximo,2);

		while ($fValorParcela > $fValorMaximo) {
			$fValorParcela -= 0.01;
			$fValorParcela = round($fValorParcela, 2);

			if ($fValorParcela == $fValorMaximo) {
				break;
			}
		}

		return $fValorParcela;
	}

	/**
	 * Apaga um empréstimo com seus pagamentos e parcelas (cascade)
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function excluirEmprestimo(): bool {
		/** @var Pagamento $oPagamento */
		/** @var Parcela $oParcela */

		$loPagamentos = Sistema::PagamentoDAO()->findByEmprestimo($this);
		if (!$loPagamentos->isEmpty()) {
			foreach ($loPagamentos as $oPagamento) {
				$oPagamento->excluir();
			}
		}

		$loParcelas = Sistema::ParcelaDAO()->findByEmprestimo($this);
		if (!$loParcelas->isEmpty()) {
			foreach ($loParcelas as $oParcela) {
				$oParcela->excluir();
			}
		}

		return Sistema::EmprestimoDAO()->delete($this);
	}
}