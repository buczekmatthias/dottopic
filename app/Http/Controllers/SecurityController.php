<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;

class SecurityController extends Controller
{
	public function login(): Response
	{
		return inertia('Security/Login');
	}

	public function handleLogin(LoginRequest $request): RedirectResponse
	{
		if (Auth::attempt($request->only('email', 'password'), $request->post('remember_me'))) {
			return to_route('homepage');
		}

		return back()->withErrors(['email' => 'Wrong credentials', 'password' => 'Wrong credentials']);
	}

	public function register(): Response
	{
		return inertia('Security/Register');
	}

	public function handleRegister(RegisterRequest $request): RedirectResponse
	{
		$user = User::create(array_merge($request->validated(), ['role' => UserRole::USER]));

		Auth::loginUsingId($user->id);

		return to_route('homepage');
	}

	public function logout(): RedirectResponse
	{
		Auth::logout();

		return to_route('homepage');
	}
}
