<?php

namespace App\Http\Resources;

use App\Actions\ArticleActions;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'slug' => $this->slug,
			'content' => $this->content,
			'author' => $this->whenLoaded(
				'author',
				fn () => ['name' => $this->author->name, 'username' => $this->author->username]
			),
			'article' => $this->whenLoaded(
				'article',
				fn () => $this->article->slug
			),
			'reactions_count' => $this->whenLoaded(
				'reactions',
				fn () => ArticleActions::prepareReactionsArray($this->reactions)
			),
			'userReaction' => $this->whenLoaded(
				'reactions',
				fn () => $this->reactions->firstWhere('user_id', $request->user()->id)?->content
			),
			'created_at' => $this->created_at->format('F jS, Y')
		];
	}
}
