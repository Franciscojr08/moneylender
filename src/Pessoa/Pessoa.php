<?php

namespace MoneyLender\Src\Pessoa;

use MoneyLender\Src\Emprestimo\Emprestimo;
use MoneyLender\Src\Emprestimo\EmprestimoList;
use MoneyLender\Src\Sistema\Enum\SimNaoEnum;
use MoneyLender\Src\Sistema\Sistema;

/**
 * Class Pessoa
 * @package MoneyLender\Src\Pessoa
 * @version 1.0.0
 */
class Pessoa {

	const CLIENTE = 1;
	const FORNECEDOR = 2;

	private int $iId;
	private string $sNome;
	private string $sCPF;
	private string $sLogradouro;
	private string $sBairro;
	private string $sCidade;
	private string $sEstado;
	private string $sComplemento;
	private string $sTelefone;
	private string $sEmail;
	private bool $bIndicado = false;
	private string $sNomeIndicador;
	private int $iTipo;
	private EmprestimoList $loEmprestimoList;
	private \DateTimeImmutable $oDataCadastro;
	private \DateTimeImmutable $oDataAtualizacao;

	/**
	 * Cria um objeto Pessoa a partir de um array
	 *
	 * @param array $aDados
	 * @return Pessoa
	 * @throws \Exception
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function createFromArray(array $aDados): Pessoa {
		$oPessoa = new Pessoa();
		$oPessoa->iId = $aDados['psa_id'];
		$oPessoa->sNome = $aDados['psa_nome'];
		$oPessoa->oDataCadastro = new \DateTimeImmutable($aDados['psa_data_cadastro']);
		$oPessoa->iTipo = $aDados['psa_tipo'];

		if (!empty($aDados['psa_cpf'])) {
			$oPessoa->sCPF = $aDados['psa_cpf'];
		}

		if (!empty($aDados['psa_logradouro'])) {
			$oPessoa->sLogradouro = $aDados['psa_logradouro'];
		}

		if (!empty($aDados['psa_bairro'])) {
			$oPessoa->sBairro = $aDados['psa_bairro'];
		}

		if (!empty($aDados['psa_cidade'])) {
			$oPessoa->sCidade = $aDados['psa_cidade'];
		}

		if (!empty($aDados['psa_estado'])) {
			$oPessoa->sEstado = $aDados['psa_estado'];
		}

		if (!empty($aDados['psa_complemento'])) {
			$oPessoa->sComplemento = $aDados['psa_complemento'];
		}

		if (!empty($aDados['psa_telefone'])) {
			$oPessoa->sTelefone = $aDados['psa_telefone'];
		}

		if (!empty($aDados['psa_email'])) {
			$oPessoa->sEmail = $aDados['psa_email'];
		}

		if ($aDados['psa_indicado'] != SimNaoEnum::NAO) {
			$oPessoa->bIndicado = $aDados['psa_indicado'];
		}

		if ($aDados['psa_indicado'] != SimNaoEnum::NAO && !empty($aDados['psa_nome_indicador'])) {
			$oPessoa->sNomeIndicador = $aDados['psa_nome_indicador'];
		}

		if (!empty($aDados['psa_data_atualizacao'])) {
			$oPessoa->oDataAtualizacao = new \DateTimeImmutable($aDados['psa_data_atualizacao']);
		}

		$loEmprestimos = Sistema::EmprestimoDAO()->findByPessoa($oPessoa);
		if (!$loEmprestimos->isEmpty()) {
			$oPessoa->loEmprestimoList = $loEmprestimos;
		}

		return $oPessoa;
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
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getCPF(): string {
		return $this->sCPF;
	}

	/**
	 * Retorna o CPF com a máscara
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getCPFComMascara(): string {
		return substr($this->sCPF, 0, 3) .
			'.' . substr($this->sCPF, 3, 3) .
			'.' . substr($this->sCPF, 6, 3) .
			'-' . substr($this->sCPF, 9, 2);
	}

	/**
	 * Retorna se a pessoa possui CPF
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasCPF(): bool {
		return !empty($this->sCPF);
	}

	/**
	 * Atribui o CPF
	 *
	 * @param string $sCPF
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setCPF(string $sCPF): void {
		$this->sCPF = $sCPF;
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
	 * Retorna se possui logradouro
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasLogradouro(): bool {
		return !empty($this->sLogradouro);
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
	 * Retorna se possui bairro
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasBairro(): bool {
		return !empty($this->sBairro);
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
	 * Retorna se possui cidade
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasCidade(): bool {
		return !empty($this->sCidade);
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
	 * Retorna se possui estado
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasEstado(): bool {
		return !empty($this->sEstado);
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
	 * Retorna se possui complemento
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasComplemento(): bool {
		return !empty($this->sComplemento);
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
		return $this->sTelefone;
	}

	/**
	 * Retorna o telefone com máscara
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getTelefoneComMascara(): string {
		return '(' . substr($this->sTelefone, 0, 2) . ') '
			. substr($this->sTelefone, 2, 5) .
			'-' . substr($this->sTelefone, 7, 4);
	}

	/**
	 * Retorna se possui telefone
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasTelefone(): bool {
		return !empty($this->sTelefone);
	}

	/**
	 * Atribui o telefone
	 *
	 * @param string $sTelefone
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setTelefone(string $sTelefone): void {
		$this->sTelefone = $sTelefone;
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
	 * Retorna se possui e-mail
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function hasEmail(): bool {
		return !empty($this->sEmail);
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
	public function getEmprestimos(): EmprestimoList {
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
	public function hasEmprestimos(): bool {
		return !empty($this->loEmprestimoList);
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
	public function setEmprestimos(EmprestimoList $loEmprestimoList): void {
		$this->loEmprestimoList = $loEmprestimoList;
	}

	/**
	 * Retorna o tipo de pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return int
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getTipoPessoa(): int {
		return $this->iTipo;
	}

	/**
	 * Retorna a descrição do tipo de pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function getDescricaoTipoPessoa(): string {
		if ($this->iTipo == self::CLIENTE) {
			return "Cliente";
		} else {
			return "Fornecedor";
		}
	}

	/**
	 * Atribui o tipo de pessoa
	 *
	 * @param int $iTipo
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return void
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function setTipoPessoa(int $iTipo): void {
		$this->iTipo = $iTipo;
	}

	/**
	 * Retorna se a pessoa é cliente
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isCliente(): bool {
		return $this->iTipo == self::CLIENTE;
	}

	/**
	 * Retorna se a pessoa é um fornecedor
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function isFornecedor(): bool {
		return $this->iTipo == self::FORNECEDOR;
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

	/**
	 * Cadastra uma pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function cadastrar(): bool {
		$this->oDataCadastro = new \DateTimeImmutable("now");

		return Sistema::PessoaDAO()->save($this);
	}

	/**
	 * Atualiza uma pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function atualizar(): bool {
		$this->oDataAtualizacao = new \DateTimeImmutable("now");

		return Sistema::PessoaDAO()->update($this);
	}

	/**
	 * Deleta uma pessoa
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return bool
	 * @throws \Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public function excluir(): bool {
		return Sistema::PessoaDAO()->delete($this);
	}
}