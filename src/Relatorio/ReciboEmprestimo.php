<?php

namespace MoneyLender\Src\Relatorio;

use Fpdf\Fpdf;
use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Pessoa\Pessoa;

/**
 * Class ReciboEmprestimo
 * @package MoneyLender\Src\Relatorio
 * @version 1.0.0
 */
class ReciboEmprestimo extends Fpdf {

	private Pessoa $oPessoa;
	private Emprestimo $oEmprestimo;

	/**
	 * ReciboEmprestimo Construtor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function __construct() {
		parent::__construct('L', 'mm', [95,205]);
		date_default_timezone_set('America/Manaus');

		$this->AddPage();
		$this->SetAutoPageBreak(false);
		$this->setTitle(mb_convert_encoding("Recibo Empréstimo Realizado",'ISO-8859-1', 'UTF-8'));
	}

	/**
	 * Header do recibo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function Header(): void {
		$this->SetY(8);
		$this->SetFont("arial","B",11);
		$this->SetFillColor(247, 252, 233);
		
		$this->Rect(0, 0, $this->GetPageWidth(), $this->GetPageHeight(), 'F');
		$this->Cell(190,8,mb_convert_encoding("RECIBO DE EMPRÉSTIMO REALIZADO", 'ISO-8859-1', 'UTF-8'));
	}

	/**
	 * Gera o recibo
	 *
	 * @param Emprestimo $oEmprestimo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function gerar(Emprestimo $oEmprestimo): void {
		$this->oEmprestimo = $oEmprestimo;
		$this->oPessoa = $oEmprestimo->getPessoa();

		$this->imprimirTextoRecibo();
		$this->imprimirRodape();
	}

	/**
	 * Imprime o texto do recibo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirTextoRecibo(): void {
		$this->SetY(22);
		$this->SetFont("arial","",10);
		$this->MultiCell(185,6,mb_convert_encoding($this->getTextoRecibo(), 'ISO-8859-1', 'UTF-8'));
	}

	/**
	 * Retorna o texto do recibo do empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getTextoRecibo(): string {
		$fValorEmprestimo = number_format($this->oEmprestimo->getValorComJuros(),2,",",".");
		$sDataEmprestimo = $this->oEmprestimo->getDataEmprestimo()->format("d/m/Y");

		if ($this->oPessoa->isCliente()) {
			$sTexto = "Eu, {$this->oPessoa->getNome()}, inscrito(a) no CPF sob o nº {$this->oPessoa->getCPFComMascara()}";
			$sTexto .= " tomei emprestado junto a Matheus Silva Pereira, inscrito no CPF sob o nº 045.355.655-50, a";
		} else {
			$sTexto = "Eu, Matheus Silva Pereira, inscrito no CPF sob o nº 045.355.655-50, tomei emprestado junto a";
			$sTexto .= " {$this->oPessoa->getNome()}, inscrito(a) no CPF sob o nº {$this->oPessoa->getCPFComMascara()}, a";
		}

		$sTexto .= " importância de R$ $fValorEmprestimo ({$this->extenso($this->oEmprestimo->getValorComJuros())})";
		$sTexto .= " no dia $sDataEmprestimo{$this->getDescricaoTipoPagamento()}";

		return $sTexto;
	}

	/**
	 * Retorna o valor em extenso
	 *
	 * @param float $valor
	 * @return string
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function extenso(float $valor = 0): string {
		$singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
		$plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
		$u = ["", "um", "dois", "três", "quatro", "cinco", "seis",  "sete", "oito", "nove"];

		$c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
		$d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
		$d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];

		$z = 0;
		$rt = "";

		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " de " : "").$plural[$t];
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}

		$return = $rt ? $rt : "zero";

		return mb_strtoupper(trim($return));
	}

	/**
	 * Retorna a descrição do pagamento e/ou data de pagamento do empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getDescricaoTipoPagamento(): string {
		if ($this->oEmprestimo->isPagamentoParcelado()) {
			$oParcela = $this->oEmprestimo->getParcelas()->first();

			$sDataPagamento = $oParcela->getDataPrevisaoPagamento()->format("d/m/Y");
			$fValor = number_format($oParcela->getValor(),2,",",".");
			$iTotalParcelas = $this->oEmprestimo->getParcelas()->count();

			$sTexto = ". O pagamento será em $iTotalParcelas parcelas no valor de R$ $fValor ({$this->extenso($oParcela->getValor())})";
			$sTexto .= ", sendo a primeira parcela com a data do pagamento para o dia $sDataPagamento.";

			return $sTexto;
		} else {
			return ", com previsão de pagamento para o dia {$this->oEmprestimo->getDataPrevisaoPagamento()->format("d/m/Y")}.";
		}
	}

	/**
	 * Imprime o rodapé
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function imprimirRodape(): void {
		$this->Image("public/assets/img/assinatura.png",100,$this->GetY() + 15,10);
		$this->SetXY(80,$this->GetY() + 8);
		$this->Cell(50,6,"Manaus - AM, {$this->getDataAtualExtenso()}","",1,"C");
		
		$this->SetFont("arial","B",10);
		$this->SetXY(80,$this->GetY() + 15);
		$this->Cell(50,6,"Matheus Sila Pereira","T","1","C");

		$sDescricaoTipo = $this->oPessoa->isCliente() ? "Credor" : "Devedor";
		$this->SetX(80);
		$this->Cell(50,6,$sDescricaoTipo,"","","C");
	}

	/**
	 * Retorna a data em extenso
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getDataAtualExtenso(): string {
		$oData = new \DateTimeImmutable("now");
		$sMes = $this->getMesExtenso($oData->format("m"));
		$sData = "{$oData->format("d")} de $sMes de {$oData->format("Y")}";

		return mb_convert_encoding($sData, 'ISO-8859-1', 'UTF-8');
	}

	/**
	 * Retorna o mês em extenso
	 *
	 * @param int $iMes
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	private function getMesExtenso(int $iMes): string {
		return match ($iMes) {
			1 => "Janeiro",
			2 => "Fevereiro",
			3 => "Março",
			4 => "Abril",
			5 => "Maio",
			6 => "Junho",
			7 => "Julho",
			8 => "Agosto",
			9 => "Setembro",
			10 => "Outubro",
			11 => "Novembro",
			12 => "Dezembro",
			default => throw new \Exception('Mês incorreto'),
		};
	}

}