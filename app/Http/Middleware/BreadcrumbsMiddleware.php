<?php

namespace App\Http\Middleware;

use App\Services\Breadcrumbs;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BreadcrumbsMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		Breadcrumbs::generateCrumbs();

		return $next($request);
	}
}
