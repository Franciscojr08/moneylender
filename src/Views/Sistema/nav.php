<?php

use MoneyLender\Core\Functions;

?>

<nav style="">
	<?php Functions::addImage("logo","png","../gestao","Portal da Qualidade"); ?>

	<ul class="nav_ul">
		<li style="margin-right: 0 !important; width: 100px !important;">
			<a href="#"><i class="fa-solid fa-gear fa-sm" style="margin-right: 5px"></i>Gestão</a>
			<ul class="nav_ul_sub">
				<li><a href="../gestao">Cliente</a></li>
				<li><a href="../gestao/pessoal">Pessoal</a></li>
			</ul>
		</li>
		<li>
			<a href="#"><i class="fa-solid fa-users fa-sm" style="margin-right: 5px"></i>Pessoal</a>
			<ul class="nav_ul_sub">
				<li><a href="../pessoa/cliente">Cliente</a></li>
				<li><a href="../pessoa/fornecedor">Fornecedor</a></li>
			</ul>
		</li>
		<li><a href="../emprestimo"><i class="fa-solid fa-hand-holding-dollar fa-sm" style="margin-right: 5px"></i>Empréstimo</a></li>
		<li><a href="../relatorio"><i class="fa-solid fa-chart-simple fa-sm" style="margin-right: 5px"></i>Relatório</a></li>
	</ul>
</nav>

<div class="toggle_spinner">
	<div class="spinner_moneylender">
		<div class="spinner-border" role="status"></div>
		Aguarde...
	</div>
</div>