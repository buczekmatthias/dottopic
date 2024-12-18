<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;

class ArticleResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$content = collect(json_decode($this->content));
		$content = $content->map(function ($c) {
			if ($c->type === 'file') {
				$c->content = asset(Storage::url("articles/{$this->slug}/{$c->content}"));
			}

			return $c;
		});

		$data = [
			...CompactArticleResource::make($this)->toArray($request),
			'content' => $content,
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
