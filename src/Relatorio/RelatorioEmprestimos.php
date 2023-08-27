<?php

namespace MoneyLender\Src\Relatorio;

use Fpdf\Fpdf;
use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Sistema\Enum\SituacaoEmprestimoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class RelatorioEmprestimos
 * @package MoneyLender\Src\Relatorio
 * @version 1.0.0
 */
class RelatorioEmprestimos extends Fpdf {

	use pdf_cellfit;

	const EMPRESTIMO_CLIENTE = 1;
	const EMPRESTIMO_PESSOAL = 2;

	private bool $bFornecedor;

	/**
	 * RelatorioEmprestimos Construtor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct() {
		parent::__construct("L");
		date_default_timezone_set('America/Manaus');

		$this->AddPage();
		$this->SetAutoPageBreak(false);
		$this->SetMargins(10,10,10);
		$this->SetDrawColor(170,170,170);
		$this->setTitle(mb_convert_encoding("Relatório Empréstimos",'ISO-8859-1', 'UTF-8'));
	}

	/**
	 * Gera o relatório
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function gerar(array $aDados): void {
		$aDadosFiltroEmprestimo = $aDados['aFiltro']['rel_emprestimo'];
		$loEmprestimos = $this->getEmprestimos($aDadosFiltroEmprestimo);

		$this->imprimirTitulo();
		$this->imprimirFiltros($aDadosFiltroEmprestimo);
		$this->imprimirEmprestimos($loEmprestimos);
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
		$this->Cell(0,6,mb_convert_encoding("Relatório Empréstimos",'ISO-8859-1', 'UTF-8'),"","","C");
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

		$sTipoEmprestimo = $aDadosFiltroEmprestimo['filtro_tipo_emprestimo'] == self::EMPRESTIMO_CLIENTE ?
			"Tipo do Empréstimo: Cliente" :
			"Tipo do Empréstimo: Pessoal";

		$this->SetFont("arial","",10);
		$this->Cell(0,6,mb_convert_encoding($sTipoEmprestimo,'ISO-8859-1', 'UTF-8'));
		$this->Ln(6);

		if (!empty($aDadosFiltroEmprestimo['emo_situacao'])) {
			$sSituacao = SituacaoEmprestimoEnum::getDescricaoByIds($aDadosFiltroEmprestimo['emo_situacao']);
			$this->Cell(0,6,mb_convert_encoding("Situação do Empréstimo: $sSituacao",'ISO-8859-1', 'UTF-8'));
			$this->Ln(6);
		}

		if (!empty($aDadosFiltroEmprestimo['emo_data_emprestimo'])) {
			$oDataEmprestimo = new \DateTimeImmutable($aDadosFiltroEmprestimo['emo_data_emprestimo']);
			$this->Cell(0,6,mb_convert_encoding("Data do Empréstimo: {$oDataEmprestimo->format("d/m/Y")}",'ISO-8859-1', 'UTF-8'));
		}
	}

	/**
	 * Retorna os empréstimos
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getEmprestimos(array $aDados): EmprestimoList {
		$aDados['filtrar_fornecedor'] = !($aDados['filtro_tipo_emprestimo'] == self::EMPRESTIMO_CLIENTE);
		$this->bFornecedor = $aDados['filtrar_fornecedor'];

		if (!empty($aDados['emo_situacao'])) {
			$aDados['aFiltro']['aSituacaoId'] = $aDados['emo_situacao'];
		}

		if (!empty($aDados['emo_data_emprestimo'])) {
			$aDados['aFiltro']['sDataEmprestimo'] = $aDados['emo_data_emprestimo'];
		}

		try {
			return Sistema::EmprestimoDAO()->findAll($aDados);
		} catch (\Exception $oExp) {
			throw new \Exception("Não foi possível consultar os empréstimos.");
		}
	}

	/**
	 * Imprime os empréstimos
	 *
	 * @param EmprestimoList $loEmprestimos
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirEmprestimos(EmprestimoList $loEmprestimos): void {
		$this->imprimirCabecalhoTabela();

		$fValorTotal = 0.0;
		$fValorDevidoTotal = 0.0;
		$fValorPagoTotal = 0.0;
		$fJurosTotal = 0.0;
		$fJurosPagoTotal = 0.0;

		/** @var Emprestimo $oEmprestimo */
		foreach ($loEmprestimos as $oEmprestimo) {
			$fValor = "R$ " . number_format($oEmprestimo->getValor(),2,",",".");
			$fValorDevido = "R$ " . number_format($oEmprestimo->getValorDevido(),2,",",".");
			$fValorPago = "R$ " . number_format($oEmprestimo->getValorPago(),2,",",".");
			$fValorJuros = $this->getValorJuros($oEmprestimo);
			$fValorJurosPago = $this->getValorJurosRecebido($oEmprestimo);

			$sParcelas = "- - -";
			if ($oEmprestimo->isPagamentoParcelado()) {
				$sParcelas = "{$oEmprestimo->getParcelas()->count()} / {$oEmprestimo->getParcelas()->getParcelasPagas()->count()}";
			}

			$this->Cell(25,6,$oEmprestimo->getId(),1,"","C");
			$this->CellFitScale(50,6,mb_convert_encoding($oEmprestimo->getPessoa()->getNome(),'ISO-8859-1', 'UTF-8'),1,"","C");
			$this->Cell(28,6,mb_convert_encoding($oEmprestimo->getDescricaoSituacao(),'ISO-8859-1', 'UTF-8'),1,"","C");
			$this->Cell(30,6,$sParcelas,1,"","C");
			$this->CellFitScale(30,6,$fValor,1,"","C");
			$this->CellFitScale(28,6,$fValorDevido,1,"","C");
			$this->CellFitScale(28,6,$fValorPago,1,"","C");
			$this->CellFitScale(28,6,"R$ " . number_format($fValorJuros,2,",","."),1,"","C");
			$this->CellFitScale(28,6,"R$ " . number_format($fValorJurosPago,2,",","."),1,"","C");
			$this->Ln(6);

			$fValorTotal += $oEmprestimo->getValor();
			$fValorDevidoTotal += $oEmprestimo->getValorDevido();
			$fValorPagoTotal += $oEmprestimo->getValorPago();
			$fJurosTotal += $fValorJuros;
			$fJurosPagoTotal += $fValorJurosPago;
		}

		$this->SetFont("arial","B",10);
		$this->SetFillColor(200, 200, 200);
		$this->Cell(133,6,mb_convert_encoding("Total: {$loEmprestimos->count()} Empréstimos",'ISO-8859-1', 'UTF-8'),1,"","C",true);
		$this->CellFitScale(30,6,"R$ " . number_format($fValorTotal,2,",","."),1,"","C",true);
		$this->CellFitScale(28,6,"R$ " . number_format($fValorDevidoTotal,2,",","."),1,"","C",true);
		$this->CellFitScale(28,6,"R$ " . number_format($fValorPagoTotal,2,",","."),1,"","C",true);
		$this->CellFitScale(28,6,"R$ " . number_format($fJurosTotal,2,",","."),1,"","C",true);
		$this->CellFitScale(28,6,"R$ " . number_format($fJurosPagoTotal,2,",","."),1,"","C",true);
		$this->Ln(6);
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

		$sPessoa = $this->bFornecedor ? "Fornecedor" : "Cliente";
		$sReceber = $this->bFornecedor ? "A Pagar": "A Receber";
		$sRecebido = $this->bFornecedor ? "Pago" : "Recebido";
		$sJuros = $this->bFornecedor ? "Juros Pago" : "Juros Recebido";

		$this->Cell(25,6,"Cod","B","","C");
		$this->Cell(50,6,$sPessoa,"B","","C");
		$this->Cell(28,6,mb_convert_encoding("Situação",'ISO-8859-1', 'UTF-8'),"B","","C");
		$this->Cell(30,6,"Parcelado","B","","C");
		$this->Cell(30,6,"Valor","B","","C");
		$this->Cell(28,6,$sReceber,"B","","C");
		$this->Cell(28,6,$sRecebido,"B","","C");
		$this->Cell(28,6,"Juros","B","","C");
		$this->Cell(28,6,$sJuros,"B","","C");

		$this->SetFont("arial","",10);
		$this->Ln(6);
	}

	/**
	 * Retorna o valor do juros
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getValorJuros(Emprestimo $oEmprestimo): float {
		if (!$oEmprestimo->hasTaxaJuros()) {
			return 0.00;
		}

		$fValor = $oEmprestimo ->getValor();
		$fValorPago = $oEmprestimo->getValorPago();
		$fValorJuros = $oEmprestimo->getValorJuros();

		if ($fValorPago > $fValor) {
			$fJurosPago = $fValorPago - $fValor;

			if ($fJurosPago < $fValorJuros) {
				return ($fValorJuros - $fJurosPago);
			}

			return 0.00;
		} else {
			return $fValorJuros;
		}
	}

	/**
	 * Retorna o valor do juros pago
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return float
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getValorJurosRecebido(Emprestimo $oEmprestimo): float {
		if (!$oEmprestimo->hasTaxaJuros()) {
			return 0.00;
		}

		$fValor = $oEmprestimo ->getValor();
		$fValorPago = $oEmprestimo->getValorPago();
		$fValorJuros = $oEmprestimo->getValorJuros();

		if ($fValorPago > $fValor) {
			$fJurosPago = $fValorPago - $fValor;

			if ($fJurosPago < $fValorJuros) {
				return $fJurosPago;
			}

			return $fValorJuros;
		} else {
			return 0.00;
		}
	}
}