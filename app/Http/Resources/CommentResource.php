<?php

namespace App\Http\Resources;

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
			'content' => $this->content,
			'author' => ['name' => $this->author->name, 'username' => $this->author->username],
			'reactions' => $this->reactions,
			'created_at' => $this->created_at->format('F jS, Y')
		];
	}
}
