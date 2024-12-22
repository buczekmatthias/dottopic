<?php

namespace App\Actions;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

final class UserActions
{
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

			$user->delete();
		});
	}
}
