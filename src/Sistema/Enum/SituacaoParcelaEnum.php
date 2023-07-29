<?php

namespace MoneyLender\Src\Sistema\Enum;

use Exception;

enum SituacaoParcelaEnum implements EnumInterface {

	const EM_ABERTA = 1;
	const PAGA = 2;
	const CANCELADA = 3;

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
			'valor' => self::EM_ABERTA,
			'descricao' => "Em aberta"
		];

		$aValores[] = [
			'valor' => self::PAGA,
			'descricao' => "Paga"
		];

		$aValores[] = [
			'valor' => self::CANCELADA,
			'descricao' => "Cancelada"
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
			self::EM_ABERTA => "Em aberta",
			self::PAGA => "Paga",
			self::CANCELADA => "Cancelada",
			default => throw new Exception("Tipo de arquivo não encontrado.")
		};
	}
}

