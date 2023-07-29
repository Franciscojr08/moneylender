<?php
/** @var string $sDescricaoTipoPessoa */
?>

<div class="modal fade" id="exampleModal">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Cadastrar <?php echo $sDescricaoTipoPessoa; ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body cad_emp_data" style="width: 100%;">
				<div class="d-flex justify-content-between" style="padding-bottom: 1.2rem;">
					<div style="width: 50%;">
						<label>Nome</label><br>
						<input style="width: 100%" type="text" name="aPessoa[psa_nome]" placeholder="Nome" required>
					</div>

					<div>
						<label>CPF</label><br>
						<input type="text" class="cpf" name="aPessoa[psa_cpf]" placeholder="CPF" maxlength="14">
					</div>
				</div>

				<div class="d-flex justify-content-between" style="padding-bottom: 1.2rem;">
					<div style="width: 50%;">
						<label>Logradouro</label><br>
						<input style="width: 100%" type="text" name="aPessoa[psa_logradouro]" placeholder="Logradouro">
					</div>

					<div>
						<label>Bairro</label><br>
						<input type="text" name="aPessoa[psa_bairro]" placeholder="Bairro">
					</div>
				</div>

				<div class="d-flex" style="padding-bottom: 1.2rem;">
					<div style="width: 22.5%;">
						<label>Cidade</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_cidade]" placeholder="Cidade">
					</div>

					<div style="width: 22.5%; margin-left: 5%">
						<label>Estado</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_estado]" placeholder="Estado">
					</div>

					<div style="width: 34%; margin-left: 16%">
						<label>Complemento</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_complemento]" placeholder="Complemento">
					</div>
				</div>

				<div class="d-flex justify-content-between" style="padding-bottom: 1.2rem;">
					<div style="width: 50%;">
						<label>E-mail</label><br>
						<input style="width: 100%" type="email" name="aPessoa[psa_email]" placeholder="E-mail">
					</div>

					<div>
						<label>Telefone</label><br>
						<input type="text" class="telefone" name="aPessoa[psa_telefone]" placeholder="Telefone">
					</div>
				</div>

				<div class="d-flex">
					<div style="width: 22.5%; border: none; border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
						<label>Indicado</label><br>
						<input type="radio" id="sim" name="aPessoa[psa_indicado]" class="psa_indicado" value="1">
						<label for="sim" style="margin-right: 15px; color: rgba(0, 0, 0, 0.8);">Sim</label>
						<input type="radio" checked id="nao" name="aPessoa[psa_indicado]" class="psa_indicado" value="2">
						<label for="nao" style="color: rgba(0, 0, 0, 0.8);">Não</label><br>
					</div>

					<div id="div_indicador" style="width: 73%; margin-left: 5%; display: none">
						<label>Nome Indicador</label><br>
						<input style="width: 100%;" type="text" name="aPessoa[psa_nome_indicador]" placeholder="Nome Indicador">
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="btn btn-success">Cadastrar</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			</div>
		</div>
	</div>
</div>
