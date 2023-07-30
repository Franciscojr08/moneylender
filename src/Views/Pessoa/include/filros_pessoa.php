<?php
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Pessoa\PessoaList;

/** @var PessoaList $loPessoaList */
/** @var EmprestimoList $loEmprestimos */
/** @var bool $bFiltrarFornecedor */

$sDescricaoPessoa = $bFiltrarFornecedor ? "Fornecedor" : "Cliente";
$sDescricaoEmprestimo = $bFiltrarFornecedor ? "Fornecimento" : "Empréstimo";
?>

<fieldset>
	<legend>Filtros</legend>
	<div class="d-flex">
		<div id="cliente_emp" style="width: 22%; border-bottom: 1px solid">
			<label style="margin-left: 1.5%;"><b><?php echo $sDescricaoPessoa; ?></b></label><br>
			<select style="width: 100%;" class="select_emp_data psa_id_filtro" name="aFiltro[psa_id]" required>
				<option selected style="display: none;" value="">Selecione o <?php echo $sDescricaoPessoa; ?></option>
				<?php foreach ($loPessoaList as $oPessoa) { ?>
					<option value="<?php echo $oPessoa->getId(); ?>"><?php echo $oPessoa->getNome(); ?></option>
				<?php } ?>
			</select>
		</div>

		<div style="width: 14%; border-bottom: 1px solid; margin-left: 2%;">
			<label><b>Data Cadastro</b></label><br>
			<input style="width: 100%;" type="date" class="select_emp_data psa_data_cadastro_filtro" name="aFiltro[psa_data_cadastro]">
		</div>

		<div style="width: 10%; border-bottom: 1px solid; margin-left: 2%;">
			<label><b><?php echo $sDescricaoEmprestimo; ?></b></label><br>
			<input type="radio" id="emprestimo_sim" name="aFiltro[emprestimo]" class="psa_filtro_emprestimo" value="1">
			<label for="emprestimo_sim" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Sim</label>
			<input type="radio" id="emprestimo_nao" name="aFiltro[emprestimo]" class="psa_filtro_emprestimo" value="2">
			<label for="emprestimo_nao" style="color: rgba(0, 0, 0, 0.8);">Não</label><br>
		</div>

		<div style="width: 10%; border-bottom: 1px solid; margin-left: 2%;">
			<label><b>Indicado</b></label><br>
			<input type="radio" id="indicado_sim" name="aFiltro[psa_indicado]" class="psa_filtro_indicado" value="1">
			<label for="indicado_sim" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Sim</label>
			<input type="radio" id="indicado_nao" name="aFiltro[psa_indicado]" class="psa_filtro_indicado" value="2">
			<label for="indicado_nao" style="color: rgba(0, 0, 0, 0.8);">Não</label><br>
		</div>

		<div style="width: 20%; border-bottom: 1px solid; margin-left: 2%;">
			<label><b>Nome Indicador</b></label><br>
			<input type="text" class="select_emp_data psa_filtro_nome_indicador" name="aFiltro[psa_nome_indicador]" disabled>
		</div>

		<div style=" margin-left: 2%; margin-top: 1%">
			<button class="btn btn-warning btn_limpar_filtro_pessoa">Limpar</button>
		</div>

		<div style=" margin-left: 2%; margin-top: 1%">
			<button class="btn btn-success btn_filtrar_pessoa">Filtrar</button>
		</div>
	</div>
</fieldset>