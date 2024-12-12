<?php

use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\BreadcrumbsMiddleware;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\ModMiddleware;
use App\Http\Middleware\WriterMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
	->withRouting(
		web: __DIR__.'/../routes/web.php',
		commands: __DIR__.'/../routes/console.php',
		health: '/up',
	)
	->withMiddleware(function (Middleware $middleware) {
		$middleware->web(append: [
			BreadcrumbsMiddleware::class,
			HandleInertiaRequests::class
		]);

		$middleware->alias([
			'writer' => WriterMiddleware::class,
			'mod' => ModMiddleware::class,
			'admin' => AdminMiddleware::class
		]);
	})
	->withExceptions(function (Exceptions $exceptions) {
		//
	})->create();
