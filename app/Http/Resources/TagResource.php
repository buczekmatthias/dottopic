<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TagResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		return [
			'name' => $this->name,
			'slug' => $this->slug,
			'articles_count' => $this->whenCounted('articles'),
			'categories_count' => $this->whenCounted('categories')
		];
	}
}
