<?php

namespace App\Http\Resources;

use App\Actions\ArticleActions;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class CommentResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$data = [
			'slug' => $this->slug,
			'content' => $this->content,
			'created_at' => $this->created_at->format('F jS, Y')
		];

		if (!($this->whenLoaded('author') instanceof MissingValue)) {
			$data['author'] = ['name' => $this->author->name, 'username' => $this->author->username];
		}

		if (!($this->whenLoaded('article') instanceof MissingValue)) {
			$data['article'] = $this->article->slug;
		}

		if (!($this->whenLoaded('reactions') instanceof MissingValue)) {
			$data['reactions_count'] = ArticleActions::prepareReactionsArray($this->reactions);

			if ($request->user()) {
				$data['userReaction'] = $this->reactions->firstWhere('user_id', $request->user()->id)?->content;
			}
		}

		return $data;
	}
}
