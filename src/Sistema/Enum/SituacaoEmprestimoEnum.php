<?php

namespace MoneyLender\Src\Sistema\Enum;

use Exception;

/**
 * Class TipoArquivoEnum
 * @package MoneyLender\Src\Sistema\Enum
 * @version 1.0.0
 */
enum SituacaoEmprestimoEnum implements EnumInterface {

	const EM_ABERTO = 1;
	const PAGO = 2;
	const ATRASADO = 3;
	const CANCELADO = 4;

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
			'valor' => self::EM_ABERTO,
			'descricao' => "Em aberto"
		];

		$aValores[] = [
			'valor' => self::PAGO,
			'descricao' => "Pago"
		];

		$aValores[] = [
			'valor' => self::ATRASADO,
			'descricao' => "Atrasado"
		];

		$aValores[] = [
			'valor' => self::CANCELADO,
			'descricao' => "Cancelado"
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
			self::EM_ABERTO => "Em aberto",
			self::PAGO => "Pago",
			self::ATRASADO => "Atrasado",
			self::CANCELADO => "Cancelado",
			default => throw new Exception("Tipo de arquivo não encontrado.")
		};
	}

	/**
	 * Retorna as descrições das situações do empréstimo conforme o array de id do enum
	 *
	 * @param array $aIds
	 * @author Francisco Santos franciscojuniordh@gmail.com
	 * @return string
	 * @throws Exception
	 *
	 * @since 1.0.0 - Definição do versionamento da classe
	 */
	public static function getDescricaoByIds(array $aIds): string {
		$aSituacao = [];

		foreach ($aIds as $iId) {
			$sDescricaoSituacao = self::getDescricaoById($iId);
			$aSituacao[] = $sDescricaoSituacao;
		}

		return implode(", ",$aSituacao);
	}
}
