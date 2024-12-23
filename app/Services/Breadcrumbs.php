<?php

namespace App\Services;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

final class Breadcrumbs
{
	public static function getBreadcrumbs(): array
	{
		return Session::get('breadcrumbs', []);
	}

	public static function generateCrumbs(): void
	{
		$pieces = Arr::where(self::getRoutePieces(), fn ($p) => $p !== 'index');
		$pieces = Arr::map($pieces, fn ($p) => Str::ucfirst($p));

		Session::remove('breadcrumbs');
		Session::push('breadcrumbs', $pieces);
	}

	private static function getRoutePieces(): array
	{
		return explode('.', Route::currentRouteName());
	}
}
