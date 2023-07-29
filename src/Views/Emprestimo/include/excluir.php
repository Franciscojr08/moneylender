<?php

use MoneyLender\Src\Emprestimo\Emprestimo;

/** @var Emprestimo $oEmprestimo */
?>

<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<form type="post" action="../emprestimo/excluirEmprestimo">
			<input type="hidden" name="emo_id" value="<?php echo $oEmprestimo->getId(); ?>">
			<input type="hidden" name="psa_tipo" value="<?php echo $oEmprestimo->getPessoa()->isCliente() ? "" : "/pessoal"; ?>">

			<div class="modal-header">
				<h5 class="modal-title" id="">
					Excluir Empréstimo</h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body" style="width: 100%;">
				<div>
					<label style="padding-bottom: 10px">
						<span style="border: none; color: #ff0000; font-weight: bold;">ATENÇÃO! </span>
						Tem certeza que deseja excluir o empréstimo ?
					</label>
				</div>
				<span style="font-size: 12px; font-weight: bold; color: #ff0000;">
					OBS: Isso também irá apagar os pagamentos do empréstimo e suas parcelas, caso possua.
				</span>
			</div>

			<div class="modal-footer">
				<button type="submit" class="btn btn-danger">Excluir</button>
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
			</div>
		</form>
	</div>
</div>