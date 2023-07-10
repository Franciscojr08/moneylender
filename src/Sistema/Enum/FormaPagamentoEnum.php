<?php

namespace MoneyLender\Src\Sistema\Enum;

use Exception;

/**
 * Class FormaPagamentoEnum
 * @package MoneyLender\Src\Sistema\Enum
 * @version 1.0.0
 */
enum FormaPagamentoEnum implements EnumInterface {

	const CARTAO_CREDITO = 1;
	const CARTAO_DEBITO = 2;
	const DINHEIRO = 3;
	const PIX = 4;
	const TRANSFERENCIA = 5;
	const DEPOSITO = 6;

	/**
	 * Retorna um array de valores do enum
	 *
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return array
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function getValores(): array {
		$aValores = [];

		$aValores[] = [
			'valor' => self::CARTAO_CREDITO,
			'descricao' => "Cartão (Crédito)"
		];

		$aValores[] = [
			'valor' => self::CARTAO_DEBITO,
			'descricao' => "Cartão (Crédito)"
		];

		$aValores[] = [
			'valor' => self::DINHEIRO,
			'descricao' => "Dinheiro"
		];

		$aValores[] = [
			'valor' => self::PIX,
			'descricao' => "PIX"
		];

		$aValores[] = [
			'valor' => self::TRANSFERENCIA,
			'descricao' => "Transferência Eletrônica"
		];

		$aValores[] = [
			'valor' => self::DEPOSITO,
			'descricao' => "Depósito Bancário"
		];

		return $aValores;
	}

	/**
	 * Retorna a descrição do enum com base no valor
	 *
	 * @param int $iValorEnum
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function getDescricaoById(int $iValorEnum): string {
		return match ($iValorEnum) {
			self::CARTAO_CREDITO => "Cartão (Crédito)",
			self::CARTAO_DEBITO => "Cartão (Débito)",
			self::DINHEIRO => "Dinheiro",
			self::PIX => "PIX",
			self::TRANSFERENCIA => "Transferência Eletrônica",
			self::DEPOSITO => "Depósito Bancário",
			default => throw new Exception("Tipo de relatório não encontrado.")
		};
	}
}
