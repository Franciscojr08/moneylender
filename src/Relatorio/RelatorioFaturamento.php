<?php

namespace MoneyLender\Src\Relatorio;

use Fpdf\Fpdf;
use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class RelatorioFaturamento
 * @package MoneyLender\Src\Relatorio
 * @version 1.0.0
 */
class RelatorioFaturamento extends Fpdf {

	private float $fFaturamentoAtual = 0.0;
	private float $fFaturamentoPrevisto = 0.0;

	/**
	 * RelatorioFaturamento Construtor
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct() {
		parent::__construct();
		date_default_timezone_set('America/Manaus');

		$this->AddPage();
		$this->SetAutoPageBreak(false);
		$this->SetMargins(10,10,10);
		$this->SetDrawColor(170,170,170);
		$this->setTitle(mb_convert_encoding("Relatório Faturamento",'ISO-8859-1', 'UTF-8'));
	}

	/**
	 * Gera o relatório
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function gerar(): void {
		$this->imprimirTitulo();
		$this->imprimirQuadroClientes();
		$this->imprimirQuadroFornecedores();
		$this->imprimirBoxFaturamento();
	}

	/**
	 * Imprime o título do relatório
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirTitulo(): void {
		$this->SetFont("arial","B",12);
		$this->Cell(0,6,mb_convert_encoding("Relatório Faturamento",'ISO-8859-1', 'UTF-8'),"","","C");
	}

	/**
	 * Imprime as informações dos empréstimos dos clientes
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirQuadroClientes(): void {
		$aaDadosCliente = $this->getDadosPessoas(false);

		$this->SetFont("arial","B",10);
		$this->SetY(25);
		$this>$this->Cell(0,6,"Clientes","B");

		$this->Ln(10);
		$this->Cell(25,6,"Quantidade","B","","C");
		$this->Cell(25,6,mb_convert_encoding("Situação",'ISO-8859-1', 'UTF-8'),"B","","C");
		$this->Cell(28,6,"Valor","B","","C");
		$this->Cell(28,6,"A Receber","B","","C");
		$this->Cell(28,6,"Recebido","B","","C");
		$this->Cell(28,6,"Juros","B","","C");
		$this->Cell(28,6,"Juros Recebido","B","","C");
		$this->Ln(6);

		$fValorTotal = 0.0;
		$fValorDevidoTotal = 0.0;
		$fValorPagoTotal = 0.0;
		$fJurosTotal = 0.0;
		$fJurosPagoTotal = 0.0;

		$this->SetFont("arial","",10);
		foreach ($aaDadosCliente as $aDadoCliente) {
			$fValor = "R$ " . number_format($aDadoCliente['valor'],2,",",".");
			$fValorDevido = "R$ " . number_format($aDadoCliente['valor_devido'],2,",",".");
			$fValorPago = "R$ " . number_format($aDadoCliente['valor_pago'],2,",",".");
			$fValorJuros = "R$ " . number_format($aDadoCliente['juros'],2,",",".");
			$fValorJurosPago = "R$ " . number_format($aDadoCliente['juros_pago'],2,",",".");

			$this->Cell(25,6,$aDadoCliente['quantidade'],1,"","C");
			$this->Cell(25,6,mb_convert_encoding($aDadoCliente['situacao_descricao'],'ISO-8859-1', 'UTF-8'),1,"","C");
			$this->Cell(28,6,$fValor,1,"","C");
			$this->Cell(28,6,$fValorDevido,1,"","C");
			$this->Cell(28,6,$fValorPago,1,"","C");
			$this->Cell(28,6,$fValorJuros,1,"","C");
			$this->Cell(28,6,$fValorJurosPago,1,"","C");
			$this->Ln(6);

			$fValorTotal += $aDadoCliente['valor'];
			$fValorDevidoTotal += $aDadoCliente['valor_devido'];
			$fValorPagoTotal += $aDadoCliente['valor_pago'];
			$fJurosTotal += $aDadoCliente['juros'];
			$fJurosPagoTotal += $aDadoCliente['juros_pago'];
		}
		
		$this->fFaturamentoAtual += $fValorPagoTotal;
		$this->fFaturamentoPrevisto += $fValorDevidoTotal;

		$fValorTotal = "R$ " . number_format($fValorTotal,2,",",".");
		$fValorDevidoTotal = "R$ " . number_format($fValorDevidoTotal,2,",",".");
		$fValorPagoTotal = "R$ " . number_format($fValorPagoTotal,2,",",".");
		$fJurosTotal = "R$ " . number_format($fJurosTotal,2,",",".");
		$fJurosPagoTotal = "R$ " . number_format($fJurosPagoTotal,2,",",".");

		$this->SetFont("arial","B",10);
		$this->SetFillColor(200, 200, 200);
		$this->Cell(50,6,"Total",1,"","C",true);
		$this->Cell(28,6,$fValorTotal,1,"","C",true);
		$this->Cell(28,6,$fValorDevidoTotal,1,"","C",true);
		$this->Cell(28,6,$fValorPagoTotal,1,"","C",true);
		$this->Cell(28,6,$fJurosTotal,1,"","C",true);
		$this->Cell(28,6,$fJurosPagoTotal,1,"","C",true);
		$this->Ln(6);
	}

	/**
	 * Imprime as informações dos empréstimos dos fornecedores
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirQuadroFornecedores(): void {
		$aaDadosFornecedores = $this->getDadosPessoas(true);

		$this->SetFont("arial","B",10);
		$this->SetY($this->GetY() + 10);
		$this>$this->Cell(0,6,"Fornecedores","B");

		$this->Ln(10);
		$this->Cell(25,6,"Quantidade","B","","C");
		$this->Cell(25,6,mb_convert_encoding("Situação",'ISO-8859-1', 'UTF-8'),"B","","C");
		$this->Cell(28,6,"Valor","B","","C");
		$this->Cell(28,6,"A Pagar","B","","C");
		$this->Cell(28,6,"Pago","B","","C");
		$this->Cell(28,6,"Juros","B","","C");
		$this->Cell(28,6,"Juros Pago","B","","C");
		$this->Ln(6);

		$fValorTotal = 0.0;
		$fValorDevidoTotal = 0.0;
		$fValorPagoTotal = 0.0;
		$fJurosTotal = 0.0;
		$fJurosPagoTotal = 0.0;

		$this->SetFont("arial","",10);
		foreach ($aaDadosFornecedores as $aDadoCliente) {
			$fValor = "R$ " . number_format($aDadoCliente['valor'],2,",",".");
			$fValorDevido = "R$ " . number_format($aDadoCliente['valor_devido'],2,",",".");
			$fValorPago = "R$ " . number_format($aDadoCliente['valor_pago'],2,",",".");
			$fValorJuros = "R$ " . number_format($aDadoCliente['juros'],2,",",".");
			$fValorJurosPago = "R$ " . number_format($aDadoCliente['juros_pago'],2,",",".");

			$this->Cell(25,6,$aDadoCliente['quantidade'],1,"","C");
			$this->Cell(25,6,mb_convert_encoding($aDadoCliente['situacao_descricao'],'ISO-8859-1', 'UTF-8'),1,"","C");
			$this->Cell(28,6,$fValor,1,"","C");
			$this->Cell(28,6,$fValorDevido,1,"","C");
			$this->Cell(28,6,$fValorPago,1,"","C");
			$this->Cell(28,6,$fValorJuros,1,"","C");
			$this->Cell(28,6,$fValorJurosPago,1,"","C");
			$this->Ln(6);

			$fValorTotal += $aDadoCliente['valor'];
			$fValorDevidoTotal += $aDadoCliente['valor_devido'];
			$fValorPagoTotal += $aDadoCliente['valor_pago'];
			$fJurosTotal += $aDadoCliente['juros'];
			$fJurosPagoTotal += $aDadoCliente['juros_pago'];
		}

		$this->fFaturamentoAtual -= $fValorPagoTotal;
		$this->fFaturamentoPrevisto += $this->fFaturamentoAtual;
		$this->fFaturamentoPrevisto -= $fValorDevidoTotal;

		$fValorTotal = "R$ " . number_format($fValorTotal,2,",",".");
		$fValorDevidoTotal = "R$ " . number_format($fValorDevidoTotal,2,",",".");
		$fValorPagoTotal = "R$ " . number_format($fValorPagoTotal,2,",",".");
		$fJurosTotal = "R$ " . number_format($fJurosTotal,2,",",".");
		$fJurosPagoTotal = "R$ " . number_format($fJurosPagoTotal,2,",",".");

		$this->SetFont("arial","B",10);
		$this->SetFillColor(200, 200, 200);
		$this->Cell(50,6,"Total",1,"","C",true);
		$this->Cell(28,6,$fValorTotal,1,"","C",true);
		$this->Cell(28,6,$fValorDevidoTotal,1,"","C",true);
		$this->Cell(28,6,$fValorPagoTotal,1,"","C",true);
		$this->Cell(28,6,$fJurosTotal,1,"","C",true);
		$this->Cell(28,6,$fJurosPagoTotal,1,"","C",true);
		$this->Ln(6);
	}

	/**
	 * Retorna os dados dos empréstimos das pessoas
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return array
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getDadosPessoas(bool $bFiltrarFornecedor): array {
		$aDadosAgrupado = [];
		$aDados['filtrar_fornecedor'] = $bFiltrarFornecedor;
		$aDados['aFiltro']['aSituacaoId'] = [
			SituacaoEmprestimoEnum::EM_ABERTO,
			SituacaoEmprestimoEnum::PAGO,
			SituacaoEmprestimoEnum::ATRASADO
		];

		$loEmprestimosClientes = Sistema::EmprestimoDAO()->findAll($aDados);

		/** @var Emprestimo $oEmprestimo */
		foreach ($loEmprestimosClientes as $oEmprestimo) {
			$iSituacao = $oEmprestimo->getSituacaoId();
			$fValorJurosPago = 0.0;

			if ($oEmprestimo->getValorPago() > $oEmprestimo->getValor()) {
				$fValorJurosPago = ($oEmprestimo->getValorPago() - $oEmprestimo->getValor());
			}

			$aDadosAgrupado[$iSituacao]['quantidade']++;
			$aDadosAgrupado[$iSituacao]['situacao_descricao'] = $oEmprestimo->getDescricaoSituacao();
			$aDadosAgrupado[$iSituacao]['valor'] += $oEmprestimo->getValor();
			$aDadosAgrupado[$iSituacao]['valor_devido'] += $oEmprestimo->getValorDevido();
			$aDadosAgrupado[$iSituacao]['valor_pago'] += $oEmprestimo->getValorPago();
			$aDadosAgrupado[$iSituacao]['juros'] += $oEmprestimo->getValorJuros();
			$aDadosAgrupado[$iSituacao]['juros'] -= $fValorJurosPago;
			$aDadosAgrupado[$iSituacao]['juros_pago'] += $fValorJurosPago;
		}

		return $aDadosAgrupado;
	}

	/**
	 * Imprime o box de faturamento
	 *
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirBoxFaturamento(): void {
		$this->SetY($this->GetY() + 10);
		$this>$this->Cell(0,6,"Faturamento","B");
		
		$fFaturamentoAtual = "R$ " . number_format($this->fFaturamentoAtual,2,",",".");
		$fFaturamentoPrevisto = "R$ " . number_format($this->fFaturamentoPrevisto,2,",",".");

		$this->Ln(10);
		$this->Cell(30,6,"Atual",1,"","C",true);
		$this->Cell(30,6,$fFaturamentoAtual,1,"","C",false);
		
		$this->Ln(6);
		$this->Cell(30,6,"Previsto",1,"","C",true);
		$this->Cell(30,6,$fFaturamentoPrevisto,1,"","C",false);
	}
}