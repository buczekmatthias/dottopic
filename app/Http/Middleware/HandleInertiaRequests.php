<?php

namespace App\Http\Middleware;

use App\Services\Routes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
	/**
	 * The root template that's loaded on the first page visit.
	 *
	 * @see https://inertiajs.com/server-side-setup#root-template
	 *
	 * @var string
	 */
	protected $rootView = 'app';

	/**
	 * Determines the current asset version.
	 *
	 * @see https://inertiajs.com/asset-versioning
	 */
	public function version(Request $request): ?string
	{
		return parent::version($request);
	}

	/**
	 * Define the props that are shared by default.
	 *
	 * @see https://inertiajs.com/shared-data
	 *
	 * @return array<string, mixed>
	 */
	public function share(Request $request): array
	{
		return array_merge(parent::share($request), [
			'auth.user' => fn () => $request->user() ? $request->user()->only('name', 'username', 'image', 'initials', 'role') : null,
			'errors' => Session::get('errors') ? Session::get('errors')->getBag('default')->getMessages() : [],
			'routes' => (new Ziggy())->filter(Routes::getSharedRoutes())->toArray()
		]);
	}
}
