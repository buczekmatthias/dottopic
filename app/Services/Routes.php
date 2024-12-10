<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

final class Routes
{
	public static function getSharedRoutes(): array
	{
		/** @var \App\Models\User */
		$currentUser = Auth::user();

		if (!$currentUser) {
			return self::getGuestRoutes();
		}

		if ($currentUser->isWriter()) {
			return self::getWriterRoutes();
		}

		if ($currentUser->isMod()) {
			return self::getModRoutes();
		}

		if ($currentUser->isAdmin() || $currentUser->isDev()) {
			return self::getAdminRoutes();
		}

		return [];
	}

	private static function getSecurityRoutes(): array
	{
		return Auth::user() ?
		['security.logout']
		:
		['security.login', 'security.register'];
	}

	private static function getGuestRoutes(): array
	{
		return [
			...self::getSecurityRoutes()
		];
	}

	private static function getWriterRoutes(): array
	{
		return [
			...self::getGuestRoutes()
		];
	}

	private static function getModRoutes(): array
	{
		return [
			...self::getWriterRoutes()
		];
	}

	private static function getAdminRoutes(): array
	{
		return [
			...self::getModRoutes()
		];
	}
}
