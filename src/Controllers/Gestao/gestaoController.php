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
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll(true);
		$bFiltrarFornecedor = true;

		require_once "Gestao/pessoal.php";
	}

	/**
	 * Renderiza a view da home dos empréstimos dos clientes
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function index(array $aDados): void {
		$loEmprestimos = Sistema::EmprestimoDAO()->findAll();
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
		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "pessoal";

		$loEmprestimos = Sistema::EmprestimoDAO()->findAll($bFiltrarFornecedor);

		require_once "Gestao/include/emprestimos.php";
	}

	/**
	 * Carrega o modal de visualizar os pagamentos
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function carregarModalVisualizarPagamentos(array $aDados): void {
		// TODO: Implementar método.
	}

	/**
	 * Carrega o modal de lançar pagamento
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function carregarModalLancarPagamento(array $aDados): void {
		try {
			$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['iEmoId']);

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
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function lancarPagamento(array $aDados): void {
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

		header("Location: ../gestao");
	}

	/**
	 * Consulta as informações da parcela
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
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
}