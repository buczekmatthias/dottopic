<?php

namespace App\Services;

use App\Enum\UserRole;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

final class Roles
{
	public static function getRoleToPromoteTo(User $user): UserRole
	{
		return match ($user->role) {
			UserRole::USER => UserRole::WRITER,
			UserRole::WRITER => UserRole::MOD,
			UserRole::MOD => UserRole::ADMIN,
			UserRole::ADMIN => UserRole::DEV,
			UserRole::CREATOR => UserRole::DEV,
			default => $user->role
		};
	}

	public static function getRoleToDemoteTo(User $user): UserRole
	{
		return match ($user->role) {
			UserRole::CREATOR => UserRole::DEV,
			UserRole::DEV => UserRole::ADMIN,
			UserRole::ADMIN => UserRole::MOD,
			UserRole::MOD => UserRole::WRITER,
			UserRole::WRITER => UserRole::USER,
			default => $user->role
		};
	}

	public static function canBePromoted(User $user): bool
	{
		if (Auth::user()->role === UserRole::ADMIN && ($user->isDeveloper() || $user->isAdmin())) {
			return false;
		}

		if (Auth::user()->role === UserRole::DEV && $user->isDeveloper()) {
			return false;
		}

		return $user->role !== UserRole::CREATOR;
	}

	public static function canBeDemoted(User $user): bool
	{
		if (Auth::user()->role === UserRole::ADMIN && ($user->isDeveloper() || $user->isAdmin())) {
			return false;
		}

		if (Auth::user()->role === UserRole::DEV && $user->isDeveloper()) {
			return false;
		}

		return $user->role !== UserRole::USER;
	}
}
