<?php

use MoneyLender\Src\Pessoa\Pessoa;

/** @var Pessoa $oPessoa */

$sTxtFornecedor = "ATENÇÃO! Você ainda não quitou os seus empréstimos pessoais com o fornecedor {$oPessoa->getNome()}, por esse motivo não é possível apagar o mesmo.";
$sTxtCliente = "ATENÇÃO! O cliente {$oPessoa->getNome()} possui empréstimos em aberto, por esse motivo não é possível apagar o mesmo.";

$sTxtDelFornecedor = "ATENÇÃO! O fornecedor {$oPessoa->getNome()} possui fornecimentos cadastrados (já pagos), tem certeza que deseja excluir o mesmo ? Isso irá apagar os fornecimentos do mesmo.";
$sTxtDelCliente = "ATENÇÃO! O cliente {$oPessoa->getNome()} possui empréstimos cadastrados (já pagos), te certeza que deseja excluir o mesmo ? Isso irá apagar os fornecimentos do mesmo.";
?>

<form type="POST" action="../../pessoa/excluirPessoa">
	<input type="hidden" name="psa_id" value="<?php echo $oPessoa->getId(); ?>">

	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">
					Excluir <?php echo $oPessoa->getDescricaoTipoPessoa(); ?></h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
				<?php
					if ($oPessoa->hasEmprestimos()) {
						$loEmprestimos = $oPessoa->getEmprestimos();

						if ($loEmprestimos->isEmprestimosQuitados()) { ?>
							<div class="modal-body" style="width: 100%;">
								<div>
									<label style="padding-bottom: 10px"><?php echo $oPessoa->isCliente() ? $sTxtCliente : $sTxtFornecedor; ?></label><br>
									<span><?php echo $oPessoa->getDescricaoTipoPessoa(); ?>: </span> <span style="border: none; color: #ff0000; font-weight: bold;"><?php echo $oPessoa->getNome(); ?></span>
								</div>
							</div>

							<div class="modal-footer">
								<button type="submit" class="btn btn-danger">Excluir</button>
								<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
							</div>
						<?php } elseif ($loEmprestimos->hasEmAberto()) { ?>
							<div class="modal-body" style="width: 100%;">
								<span style="border: none; color: #ff0000; font-weight: bold;"><?php echo $oPessoa->isCliente() ? $sTxtCliente : $sTxtFornecedor; ?></span>
							</div>
						<?php } ?>
				<?php } else { ?>
						<div class="modal-body" style="width: 100%;">
							<div>
								<label style="padding-bottom: 10px">Tem certeza que deseja excluir o <?php echo $oPessoa->getDescricaoTipoPessoa(); ?> ?</label><br>
								<span><?php echo $oPessoa->getDescricaoTipoPessoa(); ?>: </span> <span style="border: none; color: #ff0000; font-weight: bold;"><?php echo $oPessoa->getNome(); ?></span>
							</div>
						</div>

						<div class="modal-footer">
							<button type="submit" class="btn btn-danger">Excluir</button>
							<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
						</div>
				<?php } ?>
		</div>
	</div>

</form>