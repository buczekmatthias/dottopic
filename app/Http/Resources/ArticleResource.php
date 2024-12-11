<?php

namespace App\Http\Resources;

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
			...CompactArticleResource::make($this)->toArray($request),
			'content' => $this->content,
			'comments' => CommentResource::collection($this->comments),
			'reactions' => $this->reactions
		];
	}
}
