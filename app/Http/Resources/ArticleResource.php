<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

class ArticleResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$data = [
			...CompactArticleResource::make($this)->toArray($request),
			'content' => $this->content,
			'comments' => [
				'data' => CommentResource::collection($this->comments->items()),
				'pagination' => Arr::except($this->comments->toArray(), 'data')
			],
		];

		if ($request->user()) {
			$data['userReaction'] = $this->reactions->firstWhere('user_id', $request->user()->id)?->content;
		}

		return $data;
	}
}
