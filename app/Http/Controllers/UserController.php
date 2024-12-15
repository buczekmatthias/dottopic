<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Response;

class UserController extends Controller
{
	public function index(Request $request): Response
	{
		$users = User::withCount(['articles', 'comments']);

		$type = $request->get('type');

		if ($type) {
			if (in_array($type, UserRole::values())) {
				$users->type($type);
			} else {
				return to_route('users.index');
			}
		}

		return inertia('Users/Index', [
			'users' => UserResource::collection($users->paginate(50)),
			'types' => UserRole::values()
		]);
	}

	public function show(Request $request, User $user): Response
	{
		$tab = $request->get('tab', 'articles');

		match ($tab) {
			'articles' => $user->articles = $user->articles()->with('category')->paginate(30),
			'comments' => $user->comments = $user->comments()->with('article')->paginate(50),
		};

		return inertia('Users/Show', [
			'user' => UserResource::make($user)
		]);
	}

	public function edit(User $user): Response
	{
		return inertia('Users/Edit');
	}

	public function update(UpdateUserRequest $request, User $user)
	{
		//
	}

	public function destroy(User $user)
	{
		//
	}

	public function promote(User $user)
	{
	}

	public function demote(User $user)
	{
	}
}
