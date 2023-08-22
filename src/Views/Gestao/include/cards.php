<?php

use MoneyLender\Src\Emprestimo\EmprestimoList;

/**
 * @var EmprestimoList $loEmprestimos
 * @var bool $bFiltrarFornecedor
 */

$sInvestidoRecebido = $bFiltrarFornecedor ? "Recebido" : "Investido";
$sRecebidoPago = $bFiltrarFornecedor ? "Pago" : "Recebido";
$sReceberPagar = $bFiltrarFornecedor ? "a Pagar" : "a Receber";
?>

<ul class="cards">
	<li id="li_total_investido">
		<span><i class="fa-solid fa-money-bill-trend-up fa-2xl"></i></span>
		Total <?php echo $sInvestidoRecebido; ?>
		<br>
		Aguarde...
	</li>
	<li id="li_total_recebido">
		<span><i class="fa-solid fa-sack-dollar fa-2xl"></i></span>
		Total <?php echo $sRecebidoPago; ?>
		<br>
		Aguarde...
	</li>
	<li id="li_total_a_receber">
		<span><i class="fa-solid fa-piggy-bank fa-2xl"></i></span>
		Total <?php echo $sReceberPagar; ?>
		<br>
		Aguarde...
	</li>
	<li id="li_total_atrasado">
		<span><i class="fa-solid fa-calendar-xmark fa-2xl"></i></span>
		Total Atrasado
		<br>
		Aguarde...
	</li>
	<li id="li_juros_recebido">
		<span><i class="fa-solid fa-sack-dollar fa-2xl"></i></i></span>
		Juros <?php echo $sRecebidoPago; ?>
		<br>
		Aguarde...
	</li>
	<li id="li_juros_a_receber">
		<span><i class="fa-solid fa-piggy-bank fa-2xl"></i></span>
		Juros <?php echo $sReceberPagar; ?>
		<br>
		Aguarde...
	</li>
</ul>
