<?php

namespace App\Actions;

use App\Enum\UserRole;
use App\Http\Resources\UserResource;
use App\Models\Reaction;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UserActions
{
	public static function getUsersList(string $type, int $page): AnonymousResourceCollection
	{
		$users = User::withCount(['articles', 'comments']);

		if ($type) {
			if (in_array($type, UserRole::values())) {
				$users->type($type);
			} else {
				return to_route('users.index');
			}
		}

		$type = $type === '' ? 'all' : $type;

		return UserResource::collection($users->paginate(50));
	}

	public static function updateProfilePicture(UploadedFile $file, User $user): void
	{
		$name = Str::random(35).".".$file->extension();

		Storage::putFileAs("pfp", $file, $name);

		$user->image = $name;
		$user->save();
	}

	public static function destroyUser(User $user): void
	{
		DB::transaction(function () use ($user) {
			$user->articles()->get()->each(function ($article) {
				$article->author_id = null;
				$article->save();
			});

			$user->comments()->get()->each(function ($comment) {
				$comment->author_id = null;
				$comment->save();
			});

			Reaction::where('user_id', $user->id)->delete();

			if ($user->image) {
				Storage::delete("pfp/{$user->image}");
			}

			$user->delete();
		});
	}
}
