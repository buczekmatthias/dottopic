<?php

namespace App\Services;

final class Roles
{
	public static function getRoleToPromoteTo(): ?string
	{
		return null;
	}

	public static function getRoleToDemoteTo(): ?string
	{
		return null;
	}

	public static function canBePromoted(): bool
	{
		return false;
	}

	public static function canBeDemoted(): bool
	{
		return false;
	}
}
