<?php

namespace App\Actions;

use App\Models\Reaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

final class ReactionActions
{
	public static function handleReaction(array $data, bool $isNewReaction): void
	{
		$model = "App\\Models\\".Str::ucfirst($data['model']);
		$userId = Auth::user()->id;

		if ($isNewReaction) {
			"\\{$model}"::where('slug', $data['slug'])->first()->reactions()->create([
				'content' => $data['reaction'],
				'user_id' => $userId,
			]);
		} else {
			Reaction::where([
				['reactionable_id', "\\{$model}"::select('id')->where('slug', $data['slug'])->first()->id],
				['reactionable_type', $model],
				['user_id', $userId]
			])
			->first()
			->delete();
		}
	}
}
