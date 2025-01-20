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
		return Session::get('breadcrumbs', [])[0];
	}

	public static function generateCrumbs(): void
	{
		$pieces = Arr::where(self::getRoutePieces(), fn ($p) => $p !== 'index');
		$pieces = Arr::map($pieces, fn ($p) => Str::ucfirst($p));

		if (in_array("Show", $pieces)) {
			$pieces[] = self::getParameterValue();
		}

		Session::remove('breadcrumbs');
		Session::push('breadcrumbs', $pieces);
	}

	private static function getRoutePieces(): array
	{
		return explode('.', Route::currentRouteName());
	}

	private static function getParameterValue(): string
	{
		$params = Route::current()->parameters();

		return match (Arr::first(array_keys($params))) {
			'user' => "@{$params['user']->username}",
			'article' => $params['article']->slug,
			'category' => $params['category']->slug,
			'tag' => $params['tag']->slug
		};
	}
}
