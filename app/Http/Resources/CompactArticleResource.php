<?php

namespace App\Http\Resources;

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
			'slug' => $this->slug,
			'description' => $this->description,
			'author' => ['name' => $this->author->name, 'username' => $this->author->username],
			'category' => ['name' => $this->category->name, 'slug' => $this->category->slug],
			'created_at' => $this->created_at->format('F jS, Y')
		];
	}
}
