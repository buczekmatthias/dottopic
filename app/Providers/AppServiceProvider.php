<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
	/**
	 * Register any application services.
	 */
	public function register(): void
	{
		//
	}

	/**
	 * Bootstrap any application services.
	 */
	public function boot(): void
	{
		JsonResource::withoutWrapping();

		Validator::extend('string_or_file', function ($attribute, $value, $parameters, $validator) {
        return is_string($value) || is_file($value);
    });
	}
}
