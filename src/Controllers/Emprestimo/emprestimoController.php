<?php

namespace MoneyLender\Src\Controllers\Emprestimo;

use MoneyLender\Core\Session;
use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class emprestimoController
 * @package MoneyLender\Src\Controllers\Emprestimo
 * @version 1.0.0
 */
class emprestimoController {

	/**
	 * Renderiza a view de cadastro do empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function index(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll($aDados, false);
		$loFornecedorList = Sistema::PessoaDAO()->findAll($aDados,true);

		require_once "Emprestimo/index.php";
	}

	/**
	 * Cadastra um empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cadastrar(array $aDados ): void {
		$aEmprestimo = $aDados['aEmprestimo'];

		try {
			$oEmprestimo = new Emprestimo();

			if ($aEmprestimo['emo_tipo'] == Pessoa::CLIENTE) {
				$oEmprestimo->setPessoaId($aEmprestimo['cliente_id']);
			} elseif ($aEmprestimo['emo_tipo'] == Pessoa::FORNECEDOR) {
				$oEmprestimo->setPessoaId($aEmprestimo['fornecedor_id']);
			}

			$fValor = str_replace(",",".",preg_replace("/[^0-9,]/", "", $aEmprestimo['emo_valor']));
			$oEmprestimo->setValor($fValor);
			$oEmprestimo->setValorPago(0.0);
			$oEmprestimo->setValorJuros(0.0);
			$oEmprestimo->setTaxaJuros(0);
			$oEmprestimo->setValorDevido($fValor);
			$oEmprestimo->setDataEmprestimo(new \DateTimeImmutable($aEmprestimo['emo_data_emprestimo']));
			$oEmprestimo->setSituacao(SituacaoEmprestimoEnum::EM_ABERTO);

			if (!empty($aEmprestimo['emo_taxa_juros'])) {
				$fTaxaJuros = floatval($aEmprestimo['emo_taxa_juros']);
				$fValorJuros = ($fValor * ($fTaxaJuros / 100));
				$fValorDevido = $fValor + $fValorJuros;

				$oEmprestimo->setTaxaJuros($fTaxaJuros);
				$oEmprestimo->setValorJuros(round($fValorJuros,2));
				$oEmprestimo->setValorDevido(round($fValorDevido,2));
			}

			if ($aEmprestimo['emo_pagamento_parcelado'] != SimNaoEnum::NAO ) {
				$oEmprestimo->setPagamentoParcelado(true);
			}

			if ($aEmprestimo['emo_pagamento_parcelado'] != SimNaoEnum::SIM && !empty($aEmprestimo['emo_data_previsao_pagamento'])) {
				$oEmprestimo->setPagamentoParcelado(false);
				$oEmprestimo->setDataPrevisaoPagamento(new \DateTimeImmutable($aEmprestimo['emo_data_previsao_pagamento']));
			}

			if (!$oEmprestimo->cadastrar($aEmprestimo)) {
				throw new \Exception("Não foi possível cadastrar o empréstimo.");
			}

			Session::setMensagem("Empréstimo cadastrado com sucesso!", "sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../emprestimo");
	}

	/**
	 * Carrega o modal de excluir empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function carregarModalExcluirEmprestimo(array $aDados): void {
		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['iEmoId']);

			require_once "src/Views/Emprestimo/include/excluir.php";
		} catch (\Exception $oExp) {
			$sMensagem = $oExp->getMessage();

			require_once "Sistema/modalExeption.php";
		}
	}

	/**
	 * Exclui um empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function excluirEmprestimo(array $aDados): void {
		$sAcao = $aDados['psa_tipo'];

		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['emo_id']);

			if (!$oEmprestimo->excluirEmprestimo()) {
				throw new \Exception("Não foi possível lançar o pagamento.");
			}

			Session::setMensagem("Empréstimo deletado com sucesso.","sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../gestao{$sAcao}");
	}
}