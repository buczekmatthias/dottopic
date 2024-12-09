<?php

namespace App\Enum;

use BackedEnum;

trait EnumTraits
{
	public static function names(): array
	{
		return array_column(static::cases(), 'name');
	}

	public static function values(): array
	{
		$cases = static::cases();

		return isset($cases[0]) && $cases[0] instanceof BackedEnum
			? array_column($cases, 'value')
			: array_column($cases, 'name');
	}
}
