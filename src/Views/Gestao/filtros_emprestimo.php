<?php
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Pessoa\PessoaList;

/** @var PessoaList $loPessoaList */
/** @var EmprestimoList $loEmprestimos */
/** @var bool $bFiltrarFornecedor */

$sDescricaoPessoa = $bFiltrarFornecedor ? "Fornecedor" : "Cliente";
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

		<div id="fornecedor_emp" style="width: 22%; border-bottom: 1px solid; margin-left: 3%;">
			<label><b>Situação</b></label><br>
			<input type="checkbox" id="em_aberto" name="aFiltro[emo_situacao][]" class="emo_situacao_filtro" value="1">
			<label for="em_aberto" style="margin-right: 8px;"> Em Aberto</label>
			<input type="checkbox" id="pago" name="aFiltro[emo_situacao][]" class="emo_situacao_filtro" value="2">
			<label for="pago" style="margin-right: 8px;"> Pago</label>
			<input type="checkbox" id="atrasado" name="aFiltro[emo_situacao][]" class="emo_situacao_filtro" value="3">
			<label for="atrasado"> Atrasado</label>
		</div>

		<div style="width: 15%; border-bottom: 1px solid; margin-left: 3%;">
			<label><b>Data Emprestimo</b></label><br>
			<input style="width: 100%;" type="date" class="select_emp_data emo_data_emprestimo_filtro" name="aFiltro[emo_data_emprestimo]">
		</div>

		<div style="width: 10%; border-bottom: 1px solid; margin-left: 3%;">
			<label><b>Juros</b></label><br>
			<input type="radio" id="juros_sim" name="aFiltro[juros]" class="emo_juros_filtro" value="1">
			<label for="juros_sim" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Sim</label>
			<input type="radio" id="juros_nao" name="aFiltro[juros]" class="emo_juros_filtro" value="2">
			<label for="juros_nao" style="color: rgba(0, 0, 0, 0.8);">Não</label><br>
		</div>

		<div style="width: 10%; border-bottom: 1px solid; margin-left: 3%;">
			<label><b>Parcelado</b></label><br>
			<input type="radio" id="parcelado_sim" name="aFiltro[parcelado]" class="emo_parcelado_filtro" value="1">
			<label for="parcelado_sim" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Sim</label>
			<input type="radio" id="parcelado_nao" name="aFiltro[parcelado]" class="emo_parcelado_filtro" value="2">
			<label for="parcelado_nao" style="color: rgba(0, 0, 0, 0.8);">Não</label><br>
		</div>

		<div style=" margin-left: 2%; margin-top: 1%">
			<button class="btn btn-warning btn_limpar_filtro_emprestimo">Limpar</button>
		</div>

		<div style=" margin-left: 2%; margin-top: 1%">
			<button class="btn btn-success btn_filtrar_emprestimo">Filtrar</button>
		</div>
	</div>
</fieldset>