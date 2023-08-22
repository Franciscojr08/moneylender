<?php

namespace MoneyLender\Src\Controllers\Emprestimo;

use MoneyLender\Core\Session;
use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Relatorio\ReciboEmprestimo;
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

			$sMensagem = "Empréstimo cadastrado com sucesso!";
			if ($oEmprestimo->getPessoa()->hasCPF()) {
				$sMensagem .= " Para baixar o recibo do empréstimo ";
				$sMensagem .= "<a style='color: #000;' target='_blank' href='../relatorio/recibo/{$oEmprestimo->getId()}'>Clique aqui</a>.";
			}

			Session::setMensagem($sMensagem, "sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../emprestimo");
	}

	/**
	 * Carrega o modal de cancelar empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function carregarModalCancelarEmprestimo(array $aDados): void {
		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['iEmoId']);

			require_once "Emprestimo/include/cancelar.php";
		} catch (\Exception $oExp) {
			$sMensagem = $oExp->getMessage();
			
			require_once "Sistema/modalExeption.php";
		}
	}

	/**
	 * Cancela um empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cancelarEmprestimo(array $aDados): void {
		$sAcao = $aDados['psa_tipo'];

		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['emo_id']);

			if (!$oEmprestimo->cancelar()) {
				throw new \Exception("Não foi possível cancelar o empréstimo.");
			}

			Session::setMensagem("Empréstimo cancelado com sucesso.","sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../gestao{$sAcao}");
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

			require_once "Emprestimo/include/excluir.php";
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
				throw new \Exception("Não foi possível excluir o empréstimo.");
			}

			Session::setMensagem("Empréstimo deletado com sucesso.","sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../gestao{$sAcao}");
	}

	/**
	 * Consulta o empréstimo por pessoa
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function consultarPorPessoaAjax(array $aDados): void {
		$aRetorno = [];

		try {
			if (!empty($aDados['iPsaId'])) {
				$oPessoa = Sistema::PessoaDAO()->find($aDados['iPsaId']);
				$loEmprestimoList = Sistema::EmprestimoDAO()->findByPessoa($oPessoa);

				if ($loEmprestimoList->isEmpty()){
					$aRetorno['status'] = false;
					$aRetorno['msg'] = "O {$oPessoa->getDescricaoTipoPessoa()} não possui empréstimos!";
				} else {
					$aRetorno['opcoes'] = $loEmprestimoList->getArrayCombo();
					$aRetorno['status'] = true;
				}
			}
		} catch (\Exception $oExp) {
			$aRetorno['status'] = false;
			$aRetorno['msg'] = $oExp->getMessage();
		}

		echo json_encode($aRetorno);
	}

	/**
	 * Consulta o valor total investido
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalInvestido(array $aDados): void {
		$fValorTotalInvestido = "R$ 0,00";

		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$aValorInvestido = Sistema::EmprestimoDAO()->getValorTotalInvestido($bFiltrarFornecedor);
		if (empty($aValorInvestido['valor_investido'])) {
			echo json_encode($fValorTotalInvestido);

			return;
		}

		$fValorTotalInvestido = "R$ " . number_format($aValorInvestido['valor_investido'],2,",",".");

		echo json_encode($fValorTotalInvestido);
	}

	/**
	 * Consulta o valor total recebido
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalRecebido(array $aDados): void {
		$fValorTotalInvestido = "R$ 0,00";

		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$aValorRecebido = Sistema::EmprestimoDAO()->getValorTotalRecebido($bFiltrarFornecedor);
		if (empty($aValorRecebido['valor_recebido'])) {
			echo json_encode($fValorTotalInvestido);
			
			return;
		}

		$fValorTotalInvestido = "R$ " . number_format($aValorRecebido['valor_recebido'],2,",",".");

		echo json_encode($fValorTotalInvestido);
	}

	/**
	 * Consulta o valor total a receber
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAReceber(array $aDados): void {
		$fValorTotalInvestido = "R$ 0,00";

		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$aValorAReceber = Sistema::EmprestimoDAO()->getValorTotalAReceber($bFiltrarFornecedor);
		if (empty($aValorAReceber['valor_a_receber'])) {
			echo json_encode($fValorTotalInvestido);

			return;
		}

		$fValorTotalInvestido = "R$ " . number_format($aValorAReceber['valor_a_receber'],2,",",".");

		echo json_encode($fValorTotalInvestido);
	}

	/**
	 * Consulta o valor total atrasado
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorTotalAtrasado(array $aDados): void {
		$fValorTotalInvestido = 0.00;

		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$aaValorTotalAtrasado = Sistema::EmprestimoDAO()->getValorTotalAtrasado($bFiltrarFornecedor);
		if (empty($aaValorTotalAtrasado)) {
			echo json_encode("R$ 0,00");

			return;
		}

		foreach ($aaValorTotalAtrasado as $aValorAtrasado) {
			$fValorTotalInvestido += floatval($aValorAtrasado['valor_a_receber']);
		}

		$fValorTotalInvestido = "R$ " . number_format($fValorTotalInvestido,2,",",".");

		echo json_encode($fValorTotalInvestido);
	}

	/**
	 * Consulta o valor total do juros recebido
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorJurosRecebido(array $aDados): void {
		$fValorTotalInvestido = 0.00;

		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$aaValorJurosRecebido = Sistema::EmprestimoDAO()->getValorJurosRecebido($bFiltrarFornecedor);
		if (empty($aaValorJurosRecebido)) {
			echo json_encode("R$ 0,00");

			return;
		}

		foreach ($aaValorJurosRecebido as $aValorJurosRecebido) {
			$fValorTotalInvestido += floatval($aValorJurosRecebido['valor_recebido']);
		}

		$fValorTotalInvestido = "R$ " . number_format($fValorTotalInvestido,2,",",".");
		
		echo json_encode($fValorTotalInvestido);
	}

	/**
	 * Consulta o valor total de juros a receber
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getValorJurosAReceber(array $aDados): void {
		$fValorTotalInvestido = 0.00;

		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$aaValorJurosAReceber = Sistema::EmprestimoDAO()->getValorJurosAReceber($bFiltrarFornecedor);
		if (empty($aaValorJurosAReceber)) {
			echo json_encode("R$ 0,00");

			return;
		}

		foreach ($aaValorJurosAReceber as $aValorJurosAReceber) {
			$fValorTotalInvestido += floatval($aValorJurosAReceber['valor_a_receber']);
		}

		$fValorTotalInvestido = "R$ " . number_format($fValorTotalInvestido,2,",",".");

		echo json_encode($fValorTotalInvestido);
	}

	/**
	 * Atualiza as situações do empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function atualizarSituacoesEmprestimo(array $aDados): void {
		$loEmprestimo = Sistema::EmprestimoDAO()->findAllEmAberto();

		/** @var Emprestimo $oEmprestimo */
		foreach ($loEmprestimo as $oEmprestimo) {
			$oEmprestimo->atualizaraSituacao();
		}
	}
}