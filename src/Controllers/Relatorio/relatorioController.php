<?php

namespace MoneyLender\Src\Controllers\Relatorio;

use MoneyLender\Src\Relatorio\ReciboEmprestimo;
use MoneyLender\Src\Relatorio\RelatorioFaturamento;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class relatorioController
 * @package MoneyLender\Src\Controllers\Relatorio
 * @version 1.0.0
 */
class relatorioController {

	/**
	 * Renderiza a view padrão
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function index(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll($aDados, false);
		$loFornecedorList = Sistema::PessoaDAO()->findAll($aDados,true);

		require_once "Relatorio/index.php";
	}

	/**
	 * Gera o recibo do empréstimo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function recibo(array $aDados): void {
		$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['valor']);
		$oRecibo = new ReciboEmprestimo();
		$oRecibo->gerar($oEmprestimo);
		$oRecibo->Output();
	}

	/**
	 * Gera o relatório conforme o tipo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function gerar(array $aDados): void {
		switch ($aDados['tipo_relatorio']) {
			case "rel_recibo":
				$this->gerarSegundaViaRecibo($aDados);
				break;
			case "rel_faturamento":
				$this->gerarRelatorioFaturamento();
				break;
			case "rel_emprestimo":
				$this->gerarRelatorioEmprestimos($aDados);
				break;
			case "rel_cliente":
				$this->gerarRelatorioClientes($aDados);
				break;
			case "rel_fornecedor":
				$this->gerarRelatorioFornecedores($aDados);
				break;
			default:
				throw new \Exception("Tipo de relatório não configurado.");
		}
	}

	/**
	 * Gera a segunda via do recibo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarSegundaViaRecibo(array $aDados): void {
		$oEmprestimo = Sistema::EmprestimoDAO()->find($aDados['filtro_recibo_emprestimo']);
		$oRecibo = new ReciboEmprestimo();
		$oRecibo->gerar($oEmprestimo);
		$oRecibo->Output();
	}

	/**
	 * Gera o relatório de faturamento
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarRelatorioFaturamento(): void {
		$oRelatorioFaturamento = new RelatorioFaturamento();
		$oRelatorioFaturamento->gerar();
		$oRelatorioFaturamento->Output();
	}

	/**
	 * Gera o relatório de empréstimos
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarRelatorioEmprestimos(array $aDados): void {
	
	}

	/**
	 * Gera o relatório de clientes
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarRelatorioClientes(array $aDados): void {
	
	}

	/**
	 * Gera o relatório de fornecedores
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarRelatorioFornecedores(array $aDados): void {
	
	}
}