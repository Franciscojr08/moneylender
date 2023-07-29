<?php

use MoneyLender\Src\Pessoa\Pessoa;

/** @var Pessoa $oPessoa */

$sTxtFornecedor = "Você ainda não quitou os seus empréstimos pessoais com o fornecedor <b>{$oPessoa->getNome()}</b>, por esse motivo, não é possível excluí-lo.";
$sTxtCliente = "O cliente <b>{$oPessoa->getNome()}</b> possui empréstimos em aberto, por esse motivo, não é possível excluí-lo.";

$sTxtDelFornecedor = "O fornecedor {$oPessoa->getNome()} possui fornecimentos cadastrados (já pagos), tem certeza que deseja excluir o mesmo ? Isso irá apagar os fornecimentos do mesmo.";
$sTxtDelCliente = "O cliente {$oPessoa->getNome()} possui empréstimos cadastrados (já pagos), te certeza que deseja excluir o mesmo ? Isso irá apagar os fornecimentos do mesmo.";
?>

<div class="modal-dialog modal-dialog-centered modal-lg">
	<div class="modal-content">
		<form type="POST" action="../../pessoa/excluirPessoa">
			<input type="hidden" name="psa_id" value="<?php echo $oPessoa->getId(); ?>">

			<div class="modal-header">
				<h5 class="modal-title" id="">
					Excluir <?php echo $oPessoa->getDescricaoTipoPessoa(); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<?php
			if ($oPessoa->hasEmprestimos()) {
				$loEmprestimos = $oPessoa->getEmprestimos();
				
				if ($loEmprestimos->isEmprestimosQuitados()) { ?>
					<div class="modal-body" style="width: 100%;">
						<div>
							<label style="padding-bottom: 10px"><span
										style="border: none; color: #ff0000; font-weight: bold;">ATENÇÃO! </span><?php echo $oPessoa->isCliente() ? $sTxtDelCliente : $sTxtDelFornecedor; ?>
							</label><br>
							<span><?php echo $oPessoa->getDescricaoTipoPessoa(); ?>: </span> <span
									style="border: none; color: #ff0000; font-weight: bold;"><?php echo $oPessoa->getNome(); ?></span>
						</div>
					</div>

					<div class="modal-footer">
						<button type="submit" class="btn btn-danger">Excluir</button>
						<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					</div>
				<?php } elseif ($loEmprestimos->hasEmAberto()) { ?>
					<div class="modal-body" style="width: 100%;">
						<span style="border: none; color: #ff0000; font-weight: bold;">ATENÇÃO! </span>
						<span><?php echo $oPessoa->isCliente() ? $sTxtCliente : $sTxtFornecedor; ?></span>
					</div>
				<?php } ?>
			<?php } else { ?>
				<div class="modal-body" style="width: 100%;">
					<div>
						<label style="padding-bottom: 10px">Tem certeza que deseja excluir
							o <?php echo $oPessoa->getDescricaoTipoPessoa(); ?> ?</label><br>
						<span><?php echo $oPessoa->getDescricaoTipoPessoa(); ?>: </span> <span
								style="border: none; color: #ff0000; font-weight: bold;"><?php echo $oPessoa->getNome(); ?></span>
					</div>
				</div>

				<div class="modal-footer">
					<button type="submit" class="btn btn-danger">Excluir</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				</div>
			<?php } ?>
		</form>
	</div>
</div>