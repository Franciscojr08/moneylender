<?php

namespace MoneyLender\Src\Controllers\Pessoa;

use MoneyLender\Core\Session;
use MoneyLender\Src\Pessoa\Pessoa;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class pessoaController
 * @package MoneyLender\Src\Controllers\Pessoa
 * @version 1.0.0
 */
class pessoaController {

	/**
	 * Renderiza a view padrão
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cliente(array $aDados): void {
		require_once "Pessoa/cliente.php";
	}

	public function fornecedor(array $aDados): void {
		require_once "Pessoa/fornecedor.php";
	}

	/**
	 * Carrega todos os clientes
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function pessoaAjax(array $aDados): void {
		$loPessoaList = Sistema::PessoaDAO()->findAll();
		$aUrl = explode("/",$aDados['sUrl']);
		$bFiltrarFornecedor = end($aUrl) == "fornecedor";

		require_once "Pessoa/include/pessoa.php";
	}

	/**
	 * Cadastra uma pessoa
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cadastrarPessoa(array $aDados): void {
		$sAcao = "";
		$aPessoa = $aDados['aPessoa'];

		try {
			$oPessoa = new Pessoa();
			$oPessoa->setNome($aPessoa['psa_nome']);
			$oPessoa->setTipoPessoa($aPessoa['psa_tipo']);

			$sAcao = $oPessoa->isCliente() ? "cliente" : "fornecedor";

			if (!empty($aPessoa['psa_cpf'])) {
				$sCPF = preg_replace('/[^0-9]/',"",$aPessoa['psa_cpf']);

				$oPessoaVerificacao = Sistema::PessoaDAO()->findByCPFAndTipo($sCPF, $aPessoa['psa_tipo']);
				if ($oPessoaVerificacao->hasCPF()) {
					$sMensagem = "Não foi possível cadastrar o {$oPessoa->getDescricaoTipoPessoa()}. CPF já cadastrado!";
					throw new \Exception($sMensagem);
				}

				$oPessoa->setCPF($sCPF);
			}

			if (!empty($aPessoa['psa_logradouro'])) {
				$oPessoa->setLogradouro($aPessoa['psa_logradouro']);
			}

			if (!empty($aPessoa['psa_bairro'])) {
				$oPessoa->setBairro($aPessoa['psa_bairro']);
			}

			if (!empty($aPessoa['psa_cidade'])) {
				$oPessoa->setCidade($aPessoa['psa_cidade']);
			}

			if (!empty($aPessoa['psa_estado'])) {
				$oPessoa->setEstado($aPessoa['psa_estado']);
			}

			if (!empty($aPessoa['psa_complemento'])) {
				$oPessoa->setComplemento($aPessoa['psa_complemento']);
			}

			if (!empty($aPessoa['psa_telefone'])) {
				$oPessoa->setTelefone(preg_replace('/[^0-9]/',"",$aPessoa['psa_telefone']));
			}

			if (!empty($aPessoa['psa_email'])) {
				$oPessoa->setEmail($aPessoa['psa_email']);
			}

			if ($aPessoa['psa_indicado'] != SimNaoEnum::NAO) {
				$oPessoa->setIndicado($aPessoa['psa_indicado']);
			}

			if ($aPessoa['psa_indicado'] != SimNaoEnum::NAO && !empty($aPessoa['psa_nome_indicador'])) {
				$oPessoa->setNomeIndicador($aPessoa['psa_nome_indicador']);
			}

			if (!$oPessoa->cadastrar()) {
				throw new \Exception("Não foi possível cadastrar a pessoa.");
			}

			Session::setMensagem("{$oPessoa->getDescricaoTipoPessoa()} cadastrado com sucesso!", "sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../pessoa/$sAcao");
	}

	/**
	 * Carrega o modal de editar o cadastro da pessoa
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function modalEditarPessoa(array $aDados): void {
		try {
			$oPessoa = Sistema::PessoaDAO()->find($aDados['iPsaId']);

			require_once "Pessoa/include/editar.php";
		} catch (\Exception $oExp) {
			$sMensagem = $oExp->getMessage();

			require_once "Sistema/modalExeption.php";
		}
	}

	/**
	 * Edita uma pessoa
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function editarPessoa(array $aDados): void {
		$sAcao = "";
		$aPessoa = $aDados['aPessoa'];

		try {
			$oPessoa = Sistema::PessoaDAO()->find($aPessoa['psa_id']);
			$sAcao = $oPessoa->isCliente() ? "cliente" : "fornecedor";

			$sCPF = preg_replace('/[^0-9]/',"",$aPessoa['psa_cpf']);
			$sCPFPessoa = $oPessoa->hasCPF() ? $oPessoa->getCPF() : "";

			if ($sCPF != $sCPFPessoa) {
				$oPessoaVerificacao = Sistema::PessoaDAO()->findByCPFAndTipo($sCPF, $oPessoa->getTipoPessoa());
				if ($oPessoaVerificacao->hasCPF()) {
					$sMensagem = "Não foi possível atualizar o {$oPessoa->getDescricaoTipoPessoa()}. CPF já cadastrado!";
					throw new \Exception($sMensagem);
				}
			}

			$oPessoa->setNome($aPessoa['psa_nome']);
			$oPessoa->setCPF($sCPF);
			$oPessoa->setLogradouro($aPessoa['psa_logradouro']);
			$oPessoa->setBairro($aPessoa['psa_bairro']);
			$oPessoa->setCidade($aPessoa['psa_cidade']);
			$oPessoa->setEstado($aPessoa['psa_estado']);
			$oPessoa->setComplemento($aPessoa['psa_complemento']);
			$oPessoa->setTelefone(preg_replace('/[^0-9]/',"",$aPessoa['psa_telefone']));
			$oPessoa->setEmail($aPessoa['psa_email']);
			$oPessoa->setIndicado($aPessoa['psa_indicado'] == SimNaoEnum::SIM);
			$oPessoa->setNomeIndicador($aPessoa['psa_nome_indicador']);

			if (!$oPessoa->atualizar()) {
				throw new \Exception("Não foi possível atualizar a pessoa.");
			}

			Session::setMensagem("{$oPessoa->getDescricaoTipoPessoa()} atualizado com sucesso!", "sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../pessoa/$sAcao");
	}

	/**
	 * Verifica se a pessoa possui CPF cadastrado
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function verificarCPFCadastrado(array $aDados): void {
		$aRetorno = [];

		if (!empty($aDados['sCPF'])) {
			try {
				$oPessoa = Sistema::PessoaDAO()->findByCPFAndTipo($aDados['sCPF'], $aDados['iTipo']);
				$aRetorno['status'] = $oPessoa->hasCPF();
			} catch (\Exception $oExp) {
				$aRetorno['code'] = true;
				$aRetorno['msg'] = $oExp->getMessage();
			}
		}

		echo json_encode($aRetorno);
	}

	/**
	 * Carrega o modal de deletar pessoa
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function modalExcluirPessoa(array $aDados): void {
		try {
			$oPessoa = Sistema::PessoaDAO()->find($aDados['iPsaId']);

			require_once "Pessoa/include/excluir.php";
		} catch (\Exception $oExp) {
			$sMensagem = $oExp->getMessage();

			require_once "Sistema/modalExeption.php";
		}
	}

	/**
	 * Deleta uma pessoa
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function excluirPessoa(array $aDados): void {
		$sAcao = "";

		try {
			$oPessoa = Sistema::PessoaDAO()->find($aDados['psa_id']);
			$sAcao = $oPessoa->isCliente() ? "cliente" : "fornecedor";

			if (!$oPessoa->excluir()) {
				throw new \Exception("Não foi possível excluir a pessoa.");
			}

			Session::setMensagem("{$oPessoa->getDescricaoTipoPessoa()} deletado com sucesso!", "sucesso");
		} catch (\Exception $oExp) {
			Session::setMensagem($oExp->getMessage(), "erro");
		}

		header("Location: ../pessoa/$sAcao");
	}
}