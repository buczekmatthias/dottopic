<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\MissingValue;

class CompactArticleResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$data = [
			'title' => $this->title,
			'slug' => $this->slug,
			'description' => $this->description,
			'created_at' => $this->created_at->format('F jS, Y'),
			'reactions_count' => $this->whenCounted('reactions')
		];

		if (!($this->whenLoaded('author') instanceof MissingValue)) {
			$data['author'] = ['name' => $this->author->name, 'username' => $this->author->username];
		}

		if (!($this->whenLoaded('category') instanceof MissingValue)) {
			$data['category'] = ['name' => $this->category->name, 'slug' => $this->category->slug];
		}

		return $data;
	}
}
