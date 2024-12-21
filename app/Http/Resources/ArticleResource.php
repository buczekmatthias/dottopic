<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
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
		$content = $content->map(function ($c, $i) {
			$c->id = $i;
			if ($c->type === 'file') {
				$c->content = asset(Storage::url("articles/{$this->slug}/{$c->content}"));
			}

			return $c;
		});

		$data = [
			...CompactArticleResource::make($this)->toArray($request),
			'content' => $content,
		];

		if ($this->comments instanceof LengthAwarePaginator) {
			$data['comments'] = [
				'data' => CommentResource::collection($this->comments->items()),
				'pagination' => Arr::except($this->comments->toArray(), 'data')
			];

			if ($request->user()) {
				$data['userReaction'] = $this->reactions->firstWhere('user_id', $request->user()->id)?->content;
			}
		}

		return $data;
	}
}
