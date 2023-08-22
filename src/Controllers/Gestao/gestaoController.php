<?php

namespace MoneyLender\Src\Controllers\Gestao;

use MoneyLender\Core\Session;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class gestaoController
 * @package MoneyLender\Src\Controllers\Gestao
 * @version 1.0.0
 */
class gestaoController {

	/**
	 * Renderiza a view da home dos empréstimos pessoais
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function pessoal(array $aDados): void {
		$aDados['filtrar_fornecedor'] = true;

		$loPessoaList = Sistema::PessoaDAO()->findAll($aDados,true);
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll($aDados);
		$bFiltrarFornecedor = true;

		require_once "Gestao/pessoal.php";
	}

	/**
	 * Renderiza a view da home dos empréstimos dos clientes
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function index(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll($aDados,false);
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll($aDados);
		$bFiltrarFornecedor = false;

		require_once "Gestao/index.php";
	}

	/**
	 * Consulta os empréstimos por ajax
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function emprestimoAjax(array $aDados): void {
		$bFiltrarFornecedor = $this->isAcaoFornecedor($aDados);
		$aDados['filtrar_fornecedor'] = $bFiltrarFornecedor;

		$oEmprestimoDAO = Sistema::EmprestimoDAO();

		$loEmprestimos = $oEmprestimoDAO->findAll($aDados);

		require_once "Gestao/include/emprestimos.php";
	}

	/**
	 * Carrega o modal de visualizar os pagamentos
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function carregarModalVisualizarPagamentos(array $aDados): void {
		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['iEmoId']);
			$sDescricaoPessoa = $this->isAcaoFornecedor($aDados) ? "Fornecedor" : "Cliente";

			if ($oEmprestimo->isPagamentoParcelado())  {
				$loParcelas = $oEmprestimo->getParcelas();

				require_once "Gestao/pagamento/visualizar_pagamento_parcelado.php";
			} else {
				$loPagamentoList = Sistema::PagamentoDAO()->findByEmprestimo($oEmprestimo);

				require_once "Gestao/pagamento/visualizar_pagamento.php";
			}
		} catch (\Exception $oExp) {
			$sMensagem = $oExp->getMessage();

			require_once "Sistema/modalExeption.php";
		}
	}

	/**
	 * Carrega o modal de lançar pagamento
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function carregarModalLancarPagamento(array $aDados): void {
		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['iEmoId']);
			$sDescricaoPessoa = $this->isAcaoFornecedor($aDados) ? "Fornecedor" : "Cliente";

			if ($oEmprestimo->isPagamentoParcelado())  {
				$loParcelas = $oEmprestimo->getParcelas();

				require_once "Gestao/pagamento/lancar_pagamento_parcelado.php";
			} else {
				require_once "Gestao/pagamento/lancar_pagamento.php";
			}
		} catch (\Exception $oExp) {
			$sMensagem = $oExp->getMessage();

			require_once "Sistema/modalExeption.php";
		}
	}

	/**
	 * Lança o pagamento do empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function lancarPagamento(array $aDados): void {
		$sAcao = $this->isAcaoFornecedor($aDados) ? "/pessoal" : "";

		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['emo_id']);
			$aDados['pgo_valor'] = str_replace(",",".",preg_replace("/[^0-9,]/", "", $aDados['pgo_valor']));

			if (!$oEmprestimo->lancarPagamento($aDados)) {
				throw new \Exception("Não foi possível lançar o pagamento.");
			}

			Session::setMensagem("Pagamento lançado com sucesso.","sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../gestao{$sAcao}");
	}

	/**
	 * Consulta as informações da parcela
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function consultarInformacoesParcela(array $aDados): void {
		$aRetorno = [];

		try {
			if (!empty($aDados['iPraId'])) {
				$oParcela = Sistema::ParcelaDAO()->find($aDados['iPraId']);

				$aRetorno['status'] = true;
				$aRetorno['valor_devido_parcela'] = number_format($oParcela->getValorDevido(),2,",",".");
				$aRetorno['valor_pago_parcela'] = number_format($oParcela->getValorPago(),2,",",".");
				$aRetorno['vencimento_parcela'] = $oParcela->getDataPrevisaoPagamento()->format("d/m/Y");
			}
		} catch (\Exception $oExp) {
			$aRetorno['status'] = false;
			$aRetorno['msg'] = $oExp->getMessage();
		}

		echo json_encode($aRetorno);
	}

	/**
	 * Retorna se ação é para o fornecedor
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com.br
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function isAcaoFornecedor(array $aDados): bool {
		$aUrl = explode("/",$aDados['sUrl']);
		$sUrl = str_replace("#","",end($aUrl));

		return $sUrl == "pessoal";
	}
}