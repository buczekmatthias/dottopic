<?php

namespace App\Http\Controllers;

use App\Actions\UserActions;
use App\Enum\UserRole;
use App\Http\Requests\UpdateUserImageRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CompactArticleResource;
use App\Http\Resources\UserEditResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
	public function index(Request $request): Response
	{
		$type = $request->get('type', '');

		return inertia('Users/Index', [
			'users' => Inertia::defer(fn () => UserActions::getUsersList($type, $request->get('page', 1))),
			'types' => UserRole::values(),
			'tab' => $type
		]);
	}

	public function show(Request $request, User $user): Response
	{
		$tab = $request->get('tab', 'articles');

		return inertia('Users/Show', [
			'user' => UserResource::make($user),
			'content' => Inertia::defer(function () use ($tab, $user) {
				return $tab === 'articles'
				?
				CompactArticleResource::collection($user->articles()->with('category')->paginate(30))
				:
				CommentResource::collection($user->comments()->with('article')->paginate(50));
			}),
			'tab' => $tab
		]);
	}

	public function edit(User $user): Response
	{
		return inertia('Users/Edit', [
			'user' => UserEditResource::make($user),
			'mimes' => ['image/jpeg', 'image/png', 'image/webp']
		]);
	}

	public function update(UpdateUserRequest $request, User $user): RedirectResponse
	{
		$data = $request->validated();

		if ($request->post('password') !== null) {
			$data['password'] = Hash::make($request->post('password'));
		}
		DB::transaction(function () use ($user, $data) {
			$user->update($data);
		});

		return to_route('users.show', ['user' => $user->username], status: 303);
	}

	public function updateImage(UpdateUserImageRequest $request, User $user): RedirectResponse
	{
		try {
			UserActions::updateProfilePicture($request->validated()['image'], $user);
		} catch (\Exception $e) {
			return back()->withErrors(['err' => $e->getMessage()]);
		}

		return to_route('users.show', ['user' => $user->username]);
	}

	public function deleteImage(User $user): RedirectResponse
	{
		Storage::delete("pfp/{$user->image}");

		$user->image = null;
		$user->save();

		return to_route('users.show', ['user' => $user->username], status: 303);
	}

	public function destroy(User $user): RedirectResponse
	{
		UserActions::destroyUser($user);

		return to_route('homepage', status: 303);
	}

	public function promote(User $user)
	{
	}

	public function demote(User $user)
	{
	}
}
