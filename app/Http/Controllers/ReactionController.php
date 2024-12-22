<?php

namespace App\Http\Controllers;

use App\Actions\ReactionActions;
use App\Http\Requests\CreateReactionRequest;
use App\Http\Requests\DestroyReactionRequest;
use Illuminate\Http\RedirectResponse;

class ReactionController extends Controller
{
	public function store(CreateReactionRequest $request): RedirectResponse
	{
		ReactionActions::handleReaction($request->validated(), isNewReaction: true);

		return back();
	}

	public function destroy(DestroyReactionRequest $request, string $slug): RedirectResponse
	{
		ReactionActions::handleReaction(
			[
				...$request->validated(),
				'slug' => $slug
			],
			isNewReaction: false
		);

		return back(status: 303);
	}
}
