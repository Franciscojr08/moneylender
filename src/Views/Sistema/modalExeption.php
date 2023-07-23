<?php

/** @var string $sMensagem */

?>

<div class="modal-dialog modal-dialog-centered">
	<div class="modal-content">
		<div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">
				Ocorreu um erro</h5>
			<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
		</div>
		<div class="modal-body" style="width: 100%;">
			<div>
				<span style="border: none; color: #ff0000; font-weight: bold;"><?php echo $sMensagem; ?></span>
			</div>
		</div>

		<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
		</div>
	</div>
</div>