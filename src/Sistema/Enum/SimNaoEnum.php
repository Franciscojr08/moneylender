<?php

namespace MoneyLender\Src\Sistema\Enum;

use Exception;

/**
 * Class SimNaoEnum
 * @package MoneyLender\Src\Sistema\Enum
 * @version 1.0.0
 */
enum SimNaoEnum implements EnumInterface {

	const SIM = 1;
	const NAO = 2;

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
			'valor' => self::SIM,
			'descricao' => "Sim"
		];

		$aValores[] = [
			'valor' => self::NAO,
			'descricao' => "Não"
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
			self::SIM => "Sim",
			self::NAO => "Não",
			default => throw new Exception("Tipo de relatório não encontrado.")
		};
	}
}
