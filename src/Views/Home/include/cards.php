<?php

use MoneyLender\Src\Emprestimo\EmprestimoList;

/**
 * @var EmprestimoList $loEmprestimos
 */

?>

<ul class="cards">
	<li>
		<span><i class="fa-solid fa-money-bill-trend-up fa-2xl"></i></span>
		Total Investido
		<br>
		<?php echo "R$ " . number_format($loEmprestimos->getValorTotalInvestido(),2,",","."); ?>
	</li>
	<li>
		<span><i class="fa-solid fa-sack-dollar fa-2xl"></i></span>
		Total Recebido
		<br>
		<?php echo "R$ " . number_format($loEmprestimos->getValorTotalRecebido(),2,",","."); ?>
	</li>
	<li>
		<span><i class="fa-solid fa-piggy-bank fa-2xl"></i></span>
		Total a Receber
		<br>
		<?php echo "R$ " . number_format($loEmprestimos->getValorTotalAReceber(),2,",","."); ?>
	</li>
	<li>
		<span><i class="fa-solid fa-calendar-xmark fa-2xl"></i></span>
		Total Atrasado
		<br>
		<?php echo "R$ " . number_format($loEmprestimos->getValorTotalAtrasado(),2,",","."); ?>
	</li>
	<li>
		<span><i class="fa-solid fa-sack-dollar fa-2xl"></i></i></span>
		Juros Recebido
		<br>
		<?php echo "R$ " . number_format($loEmprestimos->getValorTotalJurosRecebido(),2,",","."); ?>
	</li>
	<li>
		<span><i class="fa-solid fa-piggy-bank fa-2xl"></i></span>
		Juros a Receber
		<br>
		<?php echo "R$ " . number_format($loEmprestimos->getValorTotalJurosRecebido(),2,",","."); ?>
	</li>
</ul>
