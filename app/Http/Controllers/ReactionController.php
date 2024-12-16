<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateReactionRequest;
use App\Models\Reaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReactionController extends Controller
{
	public function store(CreateReactionRequest $request)
	{
		$data = $request->validated();
		$model = "\\App\\Models\\".Str::ucfirst($data['model']);

		$model::where('slug', $data['slug'])->first()->reactions()->create([
			'content' => $data['reaction'],
			'user_id' => $request->user()->id,
		]);

		return back();
	}

	public function destroy(Request $request, string $slug)
	{
		$data = $request->validate(['model' => ['string', 'required', 'in:article,comment']]);
		if ($data) {
			$model = "App\\Models\\".Str::ucfirst($data['model']);
			Reaction::where([
				['reactionable_id', "\\{$model}"::select('id')->where('slug', $slug)->first()->id],
				['reactionable_type', $model],
				['user_id', $request->user()->id]
			])->first()->delete();
		}

		return back(status:303);
	}
}
