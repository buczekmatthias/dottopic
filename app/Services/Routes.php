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

		if ($currentUser) {
			return self::getUserRoutes();
		}

		return [];
	}

	private static function getSecurityRoutes(): array
	{
		return Auth::user() ?
		['security.logout', 'homepage']
		:
		['security.login', 'security.register', 'homepage'];
	}

	private static function getGuestRoutes(): array
	{
		return [
			...self::getSecurityRoutes(),
			'articles.index',
			'articles.show',
			'categories.index',
			'categories.show',
			'tags.index',
			'tags.show',
			'users.index',
			'users.show'
		];
	}

	private static function getUserRoutes(): array
	{
		return [
			...self::getGuestRoutes(),
			'users.edit',
			'users.update',
			'users.update.image',
			'users.destroy',
			'comments.store',
			'comments.update',
			'comments.destroy',
			'reactions.store',
			'reactions.destroy'
		];
	}

	private static function getWriterRoutes(): array
	{
		return [
			...self::getUserRoutes(),
			'articles.create',
			'articles.store',
			'articles.edit',
			'articles.update',
			'articles.destroy',
		];
	}

	private static function getModRoutes(): array
	{
		return [
			...self::getWriterRoutes(),
			'admin.dashboard',
			'admin.categories.create',
			'admin.categories.store',
			'admin.categories.edit',
			'admin.categories.update',
			'admin.categories.destroy',
			'admin.tags.create',
			'admin.tags.store',
			'admin.tags.edit',
			'admin.tags.update',
			'admin.tags.destroy',
		];
	}

	private static function getAdminRoutes(): array
	{
		return [
			...self::getModRoutes(),
			'admin.users.promote',
			'admin.users.demote',
		];
	}
}
