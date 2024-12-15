<?php

namespace App\Http\Controllers;

use App\Enum\UserRole;
use App\Http\Requests\UpdateUserImageRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserEditResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Inertia\Response;
use Illuminate\Support\Str;

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
		return inertia('Users/Edit', [
			'user' => UserEditResource::make($user),
			'mimes' => ['image/jpeg', 'image/png', 'image/webp']
		]);
	}

	public function update(UpdateUserRequest $request, User $user)
	{
		$data = $request->validated();

		if ($request->post('password') !== null) {
			$data['password'] = Hash::make($request->post('password'));
		}
		$user->update($data);

		return to_route('users.show', ['user' => $user->username], 303);
	}

	public function updateImage(UpdateUserImageRequest $request, User $user)
	{
		$img = $request->file('image');
		$name = Str::random(35).".".$img->extension();

		try {
			Storage::putFileAs("pfp", $img, $name);

			$user->image = $name;
			$user->save();
		} catch (\Exception $e) {
			return back()->withErrors(['err' => $e->getMessage()]);
		}

		return to_route('users.show', ['user' => $user->username]);
	}

	public function deleteImage(User $user)
	{
		Storage::delete("pfp/{$user->image}");

		$user->image = null;
		$user->save();

		return back();
	}

	public function destroy(User $user)
	{
		$user->articles()->get()->each(function ($article) {
			$article->author_id = null;
			$article->save();
		});
		$user->comments()->get()->each(function ($comment) {
			$comment->author_id = null;
			$comment->save();
		});

		$user->delete();

		return to_route('homepage', status:303);
	}

	public function promote(User $user)
	{
	}

	public function demote(User $user)
	{
	}
}
