<?php

namespace MoneyLender\Src\Relatorio;

use Fpdf\Fpdf;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class RelatorioPessoas
 * @package MoneyLender\Src\Relatorio
 * @version 1.0.0
 */
class RelatorioPessoas extends Fpdf {

	use pdf_cellfit;

	private array $aDados;
	private bool $bFornecedor;
	private bool $bPessoaFiltrada = false;
	private string $sTitulo;
	private Pessoa $oPessoa;

	/**
	 * RelatorioPessoas Construtor
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct(array $aDados) {
		date_default_timezone_set('America/Manaus');
		parent::__construct("L");

		$this->aDados = $aDados['aFiltro']['rel_pessoa'];
		$this->bFornecedor = ($aDados['aFiltro']['rel_pessoa']['psa_tipo'] == Pessoa::FORNECEDOR);
		$this->sTitulo = $this->bFornecedor ? "Relatório Fornecedores" : "Relatório Clientes";

		$this->verificarSeExistePessoaFiltrada();

		$this->AddPage();
		$this->SetAutoPageBreak(false);
		$this->SetMargins(10,10,10);
		$this->SetDrawColor(170,170,170);
		$this->setTitle(mb_convert_encoding($this->sTitulo,'ISO-8859-1', 'UTF-8'));
	}

	/**
	 * Gera o relatório
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function gerar(): void {
		$this->imprimirTitulo();
		$this->imprimirFiltros($this->aDados);
		$this->imprimirDadosPessoa();
	}

	/**
	 * Imprime o título do relatório
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirTitulo(): void {
		$this->SetFont("arial","B",12);
		$this->Cell(0,6,mb_convert_encoding($this->sTitulo,'ISO-8859-1', 'UTF-8'),"","","C");
	}

	/**
	 * Imprime os filtros do relatório
	 *
	 * @param array $aDadosFiltroEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirFiltros(array $aDadosFiltroEmprestimo): void {
		if (empty($aDadosFiltroEmprestimo)) {
			return;
		}

		$this->SetY(22);
		$this->SetFont("arial","B",10);
		$this->Cell(0,6,"Filtros:");
		$this->Ln(6);

		$sTipoEmprestimo = $this->bFornecedor ?
			"Tipo do Pessoa: Fornecedores" :
			"Tipo do Pessoa: Clientes";

		$this->SetFont("arial","",10);
		$this->Cell(0,6,mb_convert_encoding($sTipoEmprestimo,'ISO-8859-1', 'UTF-8'));
		$this->Ln(6);

		if (!empty($this->oPessoa)) {
			$sDescricao = $this->bFornecedor ? "Fornecedor:" : "Cliente:";
			$this->Cell(0,6,mb_convert_encoding("$sDescricao {$this->oPessoa->getNome()}",'ISO-8859-1', 'UTF-8'));
			$this->Ln(6);
		}
	}

	/**
	 * Verifica se existe pessoa filtrada
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function verificarSeExistePessoaFiltrada(): void {
		if ($this->bFornecedor && !empty($this->aDados['fornecedor_id'])) {
			$this->oPessoa = Sistema::PessoaDAO()->find($this->aDados['fornecedor_id']);
			$this->bPessoaFiltrada = true;
			return;
		}

		if (!$this->bFornecedor && !empty($this->aDados['cliente_id'])) {
			$this->oPessoa = Sistema::PessoaDAO()->find($this->aDados['cliente_id']);
			$this->bPessoaFiltrada = true;
		}
	}

	/**
	 * Imprime os dados da pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirDadosPessoa(): void {
		$this->imprimirCabecalhoTabela();

		if ($this->bPessoaFiltrada) {
			$this->imprimirPessoa($this->oPessoa);
		} else {
			$loPessoaList = Sistema::PessoaDAO()->findAll([],$this->bFornecedor);
			foreach ($loPessoaList as $oPessoa) {
				$this->imprimirPessoa($oPessoa);
				$this->Ln(6);
			}

			$sPessoa = $this->bFornecedor ? "Fornecedores" : "Clientes";
			$this->SetFont("arial","B",10);
			$this->SetFillColor(200, 200, 200);
			$this->Cell(275,6,mb_convert_encoding("Total: {$loPessoaList->count()} {$sPessoa}",'ISO-8859-1', 'UTF-8'),1,"","C",true);
		}
	}
	
	/**
	 * Imprime o cabeçalho da tabela
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirCabecalhoTabela(): void {
		$this->SetFont("arial","B",10);
		$this->Ln(10);

		$sEmprestimo = $this->bFornecedor ? "Fornecimentos" : "Empréstimos";

		$this->Cell(15,6,"Cod","B","","C");
		$this->Cell(15,6,"Cadastro","B","","C");
		$this->Cell(50,6,"Nome","B","","C");
		$this->Cell(20,6,"CPF","B","","C");
		$this->Cell(30,6,"E-mail","B","","C");
		$this->Cell(25,6,"Telefone","B","","C");
		$this->Cell(20,6,"Indicado","B","","C");
		$this->Cell(50,6,"Nome Indicador","B","","C");
		$this->Cell(20,6,mb_convert_encoding($sEmprestimo,'ISO-8859-1', 'UTF-8'),"B","","C");
		$this->Cell(30,6,"Valor Total","B","","C");

		$this->SetFont("arial","",10);
		$this->Ln(6);
	}

	/**
	 * Imprime os dados da pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirPessoa(Pessoa $oPessoa): void {
		$this->CellFitScale(15,6,$oPessoa->getId(),"B","","C");
		$this->CellFitScale(15,6,$oPessoa->getDataCadastro()->format("d/m/Y"),"B","","C");
		$this->CellFitScale(50,6,mb_convert_encoding($oPessoa->getNome(),'ISO-8859-1', 'UTF-8'),"B","","C");
		$this->CellFitScale(20,6,$oPessoa->hasCPF() ? $oPessoa->getCPFComMascara() : "- - -","B","","C");
		$this->CellFitScale(30,6,$oPessoa->hasEmail() ? $oPessoa->getEmail() : "- - -","B","","C");
		$this->CellFitScale(25,6,$oPessoa->hasTelefone() ? $oPessoa->getTelefoneComMascara() : "- - -","B","","C");
		$this->CellFitScale(20,6,mb_convert_encoding($oPessoa->isIndicado() ? "Sim" : "Não",'ISO-8859-1', 'UTF-8'),"B","","C");
		$this->CellFitScale(50,6,$oPessoa->isIndicado() ? $oPessoa->getNomeIndicador() : "- - -","B","","C");
		$this->CellFitScale(20,6,$oPessoa->hasEmprestimos() ? $oPessoa->getEmprestimos()->count() : "- - -","B","","C");
		$this->CellFitScale(30,6,$oPessoa->hasEmprestimos() ? "R$ " . number_format($oPessoa->getEmprestimos()->getValorTotalComJuros(),2,",",".") : "- - -","B","","C");
	}
}