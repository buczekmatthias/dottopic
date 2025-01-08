<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'title' => $this->title,
			'slug' => $this->slug,
			'description' => $this->description,
			'created_at' => $this->created_at->format('F j, Y'),
			'reactions_count' => $this->whenCounted('reactions'),
			'comments_count' => $this->whenCounted('comments'),
			'tags_count' => $this->whenCounted('tags'),
			'author' => $this->whenLoaded(
				'author',
				fn () => [
					'name' => $this->author->name,
					'username' => $this->author->username
				]
			),
			'category' => $this->whenLoaded(
				'category',
				fn () => [
					'name' => $this->category->name,
					'slug' => $this->category->slug
				]
			),
		];
	}
}
