<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
		return [
			...CompactArticleResource::make($this)->toArray($request),
			'content' => collect(json_decode($this->content))
							->map(function ($c, $i) {
								$c->id = $i;
								if ($c->type === 'file') {
									$filePath = "articles/{$this->slug}/{$c->content}";
									$c->content = asset(Storage::url($filePath));
									$c->fileMime = Storage::mimeType($filePath);
								}

								return $c;
							})
							->toArray(),
			'tags' => $this->whenLoaded(
				'tags',
				fn () => collect($this->tags)->map(fn ($t) => ['name' => $t->name, 'slug' => $t->slug])
			),
			'userReaction' => $this->when(
				$request->user(),
				fn () => $this->reactions->firstWhere('user_id', $request->user()->id)?->content
			)
		];
	}
}
