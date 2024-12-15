<?php

namespace App\Http\Resources;

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
			'reactions' => $this->whenLoaded('reactions'),
			'created_at' => $this->created_at->format('F jS, Y')
		];

		if (!($this->whenLoaded('author') instanceof MissingValue)) {
			$data['author'] = ['name' => $this->author->name, 'username' => $this->author->username];
		}

		if (!($this->whenLoaded('article') instanceof MissingValue)) {
			$data['article'] = $this->article->slug;
		}

		return $data;
	}
}
