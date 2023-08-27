<?php

namespace MoneyLender\Src\Controllers\Relatorio;

use MoneyLender\Src\Relatorio\ReciboEmprestimo;
use MoneyLender\Src\Relatorio\RelatorioEmprestimos;
use MoneyLender\Src\Relatorio\RelatorioFaturamento;
use MoneyLender\Src\Relatorio\RelatorioPessoas;
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
	 * @author Francisco Santos franciscojuniordh@gmail.com
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
	 * @author Francisco Santos franciscojuniordh@gmail.com
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
			case "rel_pessoa":
				$this->gerarRelatorioPessoa($aDados);
				break;
			default:
				throw new \Exception("Tipo de relatório não configurado.");
		}
	}

	/**
	 * Gera a segunda via do recibo
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarSegundaViaRecibo(array $aDados): void {
		$iEmoId = $aDados['aFiltro']['rel_recibo']['filtro_recibo_emprestimo'];

		$oEmprestimo = Sistema::EmprestimoDAO()->find($iEmoId);
		$oRecibo = new ReciboEmprestimo();
		$oRecibo->gerar($oEmprestimo);
		$oRecibo->Output();
	}

	/**
	 * Gera o relatório de faturamento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
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
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarRelatorioEmprestimos(array $aDados): void {
		$oRelatorioEmprestimo = new RelatorioEmprestimos();
		$oRelatorioEmprestimo->gerar($aDados);
		$oRelatorioEmprestimo->Output();
	}

	/**
	 * Gera o relatório de pessoas
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function gerarRelatorioPessoa(array $aDados): void {
		$oRelatorioPessoa = new RelatorioPessoas($aDados);
		$oRelatorioPessoa->gerar($aDados);
		$oRelatorioPessoa->Output();
	}

}