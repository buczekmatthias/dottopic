<?php

namespace App\Http\Resources;

use App\Actions\ArticleActions;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompactArticleResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'title' => $this->title,
			'description' => $this->description,
			'slug' => $this->slug,
			'created_at' => $this->created_at->format('F j, Y'),
			'author' => $this->whenLoaded(
				'author',
				fn () => ['name' => $this->author->name, 'username' => $this->author->username]
			),
			'category' => $this->whenLoaded(
				'category',
				fn () => ['name' => $this->category->name, 'slug' => $this->category->slug]
			),
			'reactions' => $this->whenLoaded(
				'reactions',
				fn () => ArticleActions::prepareReactionsArray($this->reactions)
			),
			'reactions_count' => $this->whenCounted('reactions'),
			'comments_count' => $this->whenCounted('comments'),
		];
	}
}
