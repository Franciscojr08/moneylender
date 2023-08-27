<div style="width: 54.5%; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
	<label>Tipo do Empréstimo</label><br>
	<input type="radio" checked id="filtro_emprestimo_nao" name="aFiltro[rel_emprestimo][filtro_tipo_emprestimo]" value="1">
	<label for="filtro_emprestimo_nao" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Cliente</label>
	<input type="radio" id="filtro_emprestimo_sim" name="aFiltro[rel_emprestimo][filtro_tipo_emprestimo]" value="2">
	<label for="filtro_emprestimo_sim" style="color: rgba(0, 0, 0, 0.8);">Pessoal</label><br>
</div>

<div style="width: 100%; padding: 1.2rem 0;">
	<label><b>Situação do Empréstimo</b></label><br>
	<input type="checkbox" id="em_aberto" name="aFiltro[rel_emprestimo][emo_situacao][]" class="emo_situacao_filtro" value="1">
	<label for="em_aberto" style="margin-right: 8px;"> Aberto</label>
	<input type="checkbox" id="atrasado" name="aFiltro[rel_emprestimo][emo_situacao][]" class="emo_situacao_filtro" value="3">
	<label for="atrasado" style="margin-right: 8px;"> Atrasado</label>
	<input type="checkbox" id="pago" name="aFiltro[rel_emprestimo][emo_situacao][]" class="emo_situacao_filtro" value="2">
	<label for="pago" style="margin-right: 8px;"> Pago</label>
	<input type="checkbox" id="cancelado" name="aFiltro[rel_emprestimo][emo_situacao][]" class="emo_situacao_filtro" value="4">
	<label for="cancelado"> Cancelado</label>
</div>

<div style="width: 54.5%; padding-bottom: 7rem;">
	<label>Data do Emprestimo</label><br>
	<input style="width: 100%;" type="date" id="emo_data_emprestimo" name="aFiltro[rel_emprestimo][emo_data_emprestimo]">
</div>

