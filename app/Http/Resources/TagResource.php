<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;

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
			'articles' => [
				'data' => CompactArticleResource::collection($this->articles->items()),
				'pagination' => Arr::except($this->articles->toArray(), 'data')
			],
			'categories' => [
				'data' => collect($this->categories->items())->map(fn ($cat) => ['name' => $cat->name, 'slug' => $cat->slug]),
				'pagination' => Arr::except($this->categories->toArray(), 'data')
			],
		];
	}
}
