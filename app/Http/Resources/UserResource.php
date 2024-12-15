<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class UserResource extends JsonResource
{
	/**
	 * Transform the resource into an array.
	 *
	 * @return array<string, mixed>
	 */
	public function toArray(Request $request): array
	{
		$data = [
			'name' => $this->name,
			'username' => $this->username,
			'image' => $this->image,
			'initials' => $this->initials,
			'role' => Str::ucfirst($this->role->value),
			'articles_count' => $this->whenCounted('articles'),
			'comments_count' => $this->whenCounted('comments'),
		];

		if ($this->articles instanceof LengthAwarePaginator) {
			$data['articles'] = [
				'data' => CompactArticleResource::collection($this->articles->items()),
				'pagination' => Arr::except($this->articles->toArray(), 'data')
			];
		}

		if ($this->comments instanceof LengthAwarePaginator) {
			$data['comments'] = [
				'data' => CommentResource::collection($this->comments->items()),
				'pagination' => Arr::except($this->comments->toArray(), 'data')
			];
		}

		return $data;
	}
}
