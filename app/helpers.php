<?php

if (!function_exists('currentUser')) {
	function currentUser(): ?\App\Models\User
	{
		return auth()->user();
	}
}