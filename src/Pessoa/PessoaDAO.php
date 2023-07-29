<?php

namespace MoneyLender\Src\Pessoa;

use Exception;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class ClienteDAO
 * @package MoneyLender\Src\Pessoa
 * @version 1.0.0
 */
class PessoaDAO implements PessoaDAOInterface {

	/**
	 * Consulta a pessoa pelo Id
	 *
	 * @param int $iPsaId
	 * @return Pessoa
	 * @throws Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function find(int $iPsaId): Pessoa {
		$sSql = "SELECT * FROM psa_pessoa WHERE psa_id = ?";
		$aParam[] = $iPsaId;

		try {
			$aPessoa = Sistema::connection()->getRow($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar a pessoa.");
		}

		if (empty($aPessoa)) {
			throw new Exception("Nenhuma pessoa encontrado.");
		}

		return Pessoa::createFromArray($aPessoa);
	}

	/**
	 *Consulta todas as pessoas
	 *
	 * @param bool $bFiltrarFornecedor
	 * @author Francisco Santos franciscosantos@moobitech.com.br
	 * @return PessoaList
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findAll(bool $bFiltrarFornecedor = false): PessoaList {
		$sSql = "SELECT * FROM psa_pessoa WHERE psa_tipo = ?";
		$aParam[] = $bFiltrarFornecedor ? Pessoa::FORNECEDOR : Pessoa::CLIENTE;

		try {
			$aaPessoas = Sistema::connection()->getArray($sSql,$aParam);
		} catch (\PDOException $oExp) {
			throw new Exception("Não foi possível consultar as pessoas.");
		}

		if (empty($aaPessoas)) {
			return new PessoaList();
		}

		return PessoaList::createFromArray($aaPessoas);
	}

	/**
	 * Salva uma pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function save(Pessoa $oPessoa): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "INSERT INTO psa_pessoa (
							psa_nome,
							psa_cpf,
							psa_logradouro,
							psa_bairro,
							psa_cidade,
							psa_estado,
							psa_complemento,
							psa_telefone,
							psa_email,
							psa_indicado,
							psa_nome_indicador,
							psa_tipo,
							psa_data_cadastro)
							VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";

			$aParams = [
				$oPessoa->getNome(),
				$oPessoa->hasCPF() ? $oPessoa->getCPF() : null,
				$oPessoa->hasLogradouro() ? $oPessoa->getLogradouro() : null,
				$oPessoa->hasBairro() ? $oPessoa->getBairro() : null,
				$oPessoa->hasCidade() ? $oPessoa->getCidade() : null,
				$oPessoa->hasEstado() ? $oPessoa->getEstado() : null,
				$oPessoa->hasComplemento() ? $oPessoa->getComplemento() : null,
				$oPessoa->hasTelefone() ? $oPessoa->getTelefone() : null,
				$oPessoa->hasEmail() ? $oPessoa->getEmail() : null,
				$oPessoa->isIndicado() ? SimNaoEnum::SIM : SimNaoEnum::NAO,
				$oPessoa->isIndicado() ? $oPessoa->getNomeIndicador() : null,
				$oPessoa->isCliente() ? Pessoa::CLIENTE : Pessoa::FORNECEDOR,
				$oPessoa->getDataCadastro()->format("Y-m-d")
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
			$oPessoa->setId($oConnection->getLasInsertId());
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível cadastrar a pessoa.");
		}

		$oConnection->commit();
		return $bStatus;
	}

	/**
	 * Atualiza uma pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function update(Pessoa $oPessoa): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "UPDATE psa_pessoa
					SET
						psa_nome = ?,
						psa_cpf = ?,
						psa_logradouro = ?,
						psa_bairro = ?,
						psa_cidade = ?,
						psa_estado = ?,
						psa_complemento = ?,
						psa_telefone = ?,
						psa_email = ?,
						psa_indicado = ?,
						psa_nome_indicador = ?,
						psa_tipo = ?,
						psa_data_cadastro = ?,
						psa_data_atualizacao = ?
					WHERE
						psa_id = ?";

			$aParams = [
				$oPessoa->getNome(),
				$oPessoa->hasCPF() ? $oPessoa->getCPF() : null,
				$oPessoa->hasLogradouro() ? $oPessoa->getLogradouro() : null,
				$oPessoa->hasBairro() ? $oPessoa->getBairro() : null,
				$oPessoa->hasCidade() ? $oPessoa->getCidade() : null,
				$oPessoa->hasEstado() ? $oPessoa->getEstado() : null,
				$oPessoa->hasComplemento() ? $oPessoa->getComplemento() : null,
				$oPessoa->hasTelefone() ? $oPessoa->getTelefone() : null,
				$oPessoa->hasEmail() ? $oPessoa->getEmail() : null,
				$oPessoa->isIndicado() ? SimNaoEnum::SIM : SimNaoEnum::NAO,
				$oPessoa->isIndicado() ? $oPessoa->getNomeIndicador() : null,
				$oPessoa->isCliente() ? Pessoa::CLIENTE : Pessoa::FORNECEDOR,
				$oPessoa->getDataCadastro()->format("Y-m-d"),
				$oPessoa->getDataAtualizacao()->format("Y-m-d"),
				$oPessoa->getId()
			];

			$bStatus = $oConnection->execute($sSql,$aParams);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível atualizar a pessoa.");
		}

		$oConnection->commit();
		return $bStatus;
	}

	/**
	 * Deleta uma pessoa
	 *
	 * @param Pessoa $oPessoa
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function delete(Pessoa $oPessoa): bool {
		$oConnection = Sistema::connection();
		$oConnection->begin();
		$bStatus = false;

		try {
			$sSql = "DELETE FROM psa_pessoa WHERE  psa_id = ?";
			$aParams[] = $oPessoa->getId();

			$bStatus = $oConnection->execute($sSql,$aParams);
		} catch (\PDOException $oExp) {
			$oConnection->rollBack();
			throw new Exception("Não foi possível excluir a pessoa.");
		}
		
		$oConnection->commit();
		return $bStatus;
	}

	/**
	 * Verifica se já existe o CPF cadastrado
	 *
	 * @param string $sCPF
	 * @param int $iTipo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Pessoa
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function findByCPFAndTipo(string $sCPF, int $iTipo): Pessoa {
		try {
			$sSql = "SELECT * FROM psa_pessoa WHERE psa_cpf = ? AND psa_tipo = ?";
			$aParam = [$sCPF,$iTipo];

			$aPessoa = Sistema::connection()->getRow($sSql,$aParam);

			if (empty($aPessoa)) {
				return new Pessoa();
			}

			return Pessoa::createFromArray($aPessoa);
		} catch (\PDOException $oExp) {
			throw new Exception("Falha ao consultar CPF.");
		}
	}
}