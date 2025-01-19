<?php

namespace App\Http\Middleware;

use App\Enum\UserRole;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WriterMiddleware
{
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
	 */
	public function handle(Request $request, Closure $next): Response
	{
		if ($request->user() && $request->user()->role !== UserRole::USER) {
			if (
				$request->user()->isWriter()
				&& in_array(
					$request->route()->getName(),
					['articles.edit', 'articles.update', 'articles.destroy']
				)
				&& $request->user()->id !== $request->route('article')->author_id
			) {
				abort(403, "You don't own the resource");
			}

			return $next($request);
		}

		return to_route('homepage');
	}
}
