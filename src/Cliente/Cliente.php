<?php

namespace MoneyLender\Src\Cliente;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class Cliente
 * @package MoneyLender\Src\Cliente
 * @version 1.0.0
 *
 */
class Cliente {

	private int $iId;
	private string $sNome;
	private int $iCPF;
	private string $sLogradouro;
	private string $sBairro;
	private string $sCidade;
	private string $sEstado;
	private string $sComplemento;
	private int $iTelefone;
	private string $sEmail;
	private bool $bIndicado = false;
	private string $sNomeIndicador;
	private EmprestimoList $loEmprestimoList;
	private \DateTimeImmutable $oDataCadastro;
	private \DateTimeImmutable $oDataAtualizacao;

	/**
	 * Cria um objeto Cliente a partir de um array
	 *
	 * @param array $aDados
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return Cliente
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aDados): Cliente {
		$oCliente = new Cliente();
		$oCliente->iId = $aDados['cle_id'];
		$oCliente->sNome = $aDados['cle_nome'];
		$oCliente->oDataCadastro = new \DateTimeImmutable($aDados['cle_data_cadastro']);

		if (!empty($aDados['cle_cpf'])) {
			$oCliente->iCPF = $aDados['cle_cpf'];
		}

		if (!empty($aDados['cle_logradouro'])) {
			$oCliente->sLogradouro = $aDados['cle_logradouro'];
		}

		if (!empty($aDados['cle_bairro'])) {
			$oCliente->sBairro = $aDados['cle_bairro'];
		}

		if (!empty($aDados['cle_cidade'])) {
			$oCliente->sCidade = $aDados['cle_cidade'];
		}

		if (!empty($aDados['cle_estado'])) {
			$oCliente->sEstado = $aDados['cle_estado'];
		}

		if (!empty($aDados['cle_complemento'])) {
			$oCliente->sComplemento = $aDados['cle_complemento'];
		}

		if (!empty($aDados['cle_telefone'])) {
			$oCliente->iTelefone = $aDados['cle_telefone'];
		}

		if (!empty($aDados['cle_email'])) {
			$oCliente->sEmail = $aDados['cle_email'];
		}

		if ($aDados['cle_indicado'] != SimNaoEnum::NAO) {
			$oCliente->bIndicado = $aDados['cle_indicado'];
		}

		if ($aDados['cle_indicado'] != SimNaoEnum::NAO && !empty($aDados['cle_nome_indicador'])) {
			$oCliente->sNomeIndicador = $aDados['cle_nome_indicador'];
		}

		if (!empty($aDados['cle_data_atualizacao'])) {
			$oCliente->oDataAtualizacao = new \DateTimeImmutable($aDados['cle_data_atualizacao']);
		}

		$loEmprestimos = Sistema::EmprestimoDAO()->findByCliente($oCliente);
		if (!$loEmprestimos->isEmpty()) {
			$oCliente->loEmprestimoList = $loEmprestimos;
		}

		return $oCliente;
	}

	/**
	 * Retorna o Id
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getId(): int {
		return $this->iId;
	}

	/**
	 * Atribui o Id
	 *
	 * @param int $iId
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setId(int $iId): void {
		$this->iId = $iId;
	}

	/**
	 * Retorna o nome
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getNome(): string {
		return $this->sNome;
	}

	/**
	 * Atribui o nome
	 *
	 * @param string $sNome
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setNome(string $sNome): void {
		$this->sNome = $sNome;
	}

	/**
	 * Retorna o CPF
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getCPF(): int {
		return $this->iCPF;
	}

	/**
	 * Atribui o CPF
	 *
	 * @param int $iCPF
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setCPF(int $iCPF): void {
		$this->iCPF = $iCPF;
	}

	/**
	 * Retorna o logradouro
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getLogradouro(): string {
		return $this->sLogradouro;
	}

	/**
	 * Atribui o logradouro
	 *
	 * @param string $sLogradouro
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setLogradouro(string $sLogradouro): void {
		$this->sLogradouro = $sLogradouro;
	}

	/**
	 * Retorna o bairro
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getBairro(): string {
		return $this->sBairro;
	}

	/**
	 * Atribui o bairro
	 *
	 * @param string $sBairro
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setBairro(string $sBairro): void {
		$this->sBairro = $sBairro;
	}

	/**
	 * Retorna a cidade
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getCidade(): string {
		return $this->sCidade;
	}

	/**
	 * Atribui a cidade
	 *
	 * @param string $sCidade
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setCidade(string $sCidade): void {
		$this->sCidade = $sCidade;
	}

	/**
	 * Retorna o estado
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getEstado(): string {
		return $this->sEstado;
	}

	/**
	 * Atribui o estado
	 *
	 * @param string $sEstado
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setEstado(string $sEstado): void {
		$this->sEstado = $sEstado;
	}

	/**
	 * Retorna o complemento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getComplemento(): string {
		return $this->sComplemento;
	}

	/**
	 * Atribui o complemento
	 *
	 * @param string $sComplemento
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setComplemento(string $sComplemento): void {
		$this->sComplemento = $sComplemento;
	}

	/**
	 * Retorna o telefone
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getTelefone(): int {
		return $this->iTelefone;
	}

	/**
	 * Atribui o telefone
	 *
	 * @param int $iTelefone
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setTelefone(int $iTelefone): void {
		$this->iTelefone = $iTelefone;
	}

	/**
	 * Retorna o e-mail
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getEmail(): string {
		return $this->sEmail;
	}

	/**
	 * Atribui o e-mail
	 *
	 * @param string $sEmail
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setEmail(string $sEmail): void {
		$this->sEmail = $sEmail;
	}

	/**
	 * Retorna se o cliente foi indicado
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isIndicado(): bool {
		return $this->bIndicado;
	}

	/**
	 * Atribui se o cliente foi indicado
	 *
	 * @param bool $bIndicado
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setIndicado(bool $bIndicado): void {
		$this->bIndicado = $bIndicado;
	}

	/**
	 * Retorna o nome do indicador
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getNomeIndicador(): string {
		return $this->sNomeIndicador;
	}

	/**
	 * Atribui o nome do indicador
	 *
	 * @param string $sNomeIndicador
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setNomeIndicador(string $sNomeIndicador): void {
		$this->sNomeIndicador = $sNomeIndicador;
	}

	/**
	 * Retorna os empréstimos do cliente
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return EmprestimoList
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getEmprestimoList(): EmprestimoList {
		return $this->loEmprestimoList;
	}

	/**
	 * Retorna se o cliente possui empréstimo
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasEmprestimo(): bool {
		return !$this->loEmprestimoList->isEmpty();
	}

	/**
	 * Atribui empréstimos para o cliente
	 *
	 * @param EmprestimoList $loEmprestimoList
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setEmprestimoList(EmprestimoList $loEmprestimoList): void {
		$this->loEmprestimoList = $loEmprestimoList;
	}

	/**
	 * Retorna a data de cadastro
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataCadastro(): \DateTimeImmutable {
		return $this->oDataCadastro;
	}

	/**
	 * Atribui a data de cadastro
	 *
	 * @param \DateTimeImmutable $oDataCadastro
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataCadastro(\DateTimeImmutable $oDataCadastro): void {
		$this->oDataCadastro = $oDataCadastro;
	}

	/**
	 * Retorna a data de atualização
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return \DateTimeImmutable
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDataAtualizacao(): \DateTimeImmutable {
		return $this->oDataAtualizacao;
	}

	/**
	 * Retorna se possui atualização
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasAtualizacao(): bool {
		return !empty($this->oDataAtualizacao);
	}

	/**
	 * Atribui a data de atualização
	 *
	 * @param \DateTimeImmutable $oDataAtualizacao
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setDataAtualizacao(\DateTimeImmutable $oDataAtualizacao): void {
		$this->oDataAtualizacao = $oDataAtualizacao;
	}

}