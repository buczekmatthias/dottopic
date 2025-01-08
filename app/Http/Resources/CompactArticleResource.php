<?php

namespace App\Http\Resources;

use App\Actions\ArticleActions;
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
			'created_at' => $this->created_at->format('F j, Y'),
			'reactions_count' => $this->whenCounted('reactions'),
			'comments_count' => $this->whenCounted('comments'),
		];

		if ($this->description) {
			$data['description'] = $this->description;
		}

		if (!($this->whenLoaded('author') instanceof MissingValue)) {
			$data['author'] = ['name' => $this->author->name, 'username' => $this->author->username];
		}

		if (!($this->whenLoaded('category') instanceof MissingValue)) {
			$data['category'] = ['name' => $this->category->name, 'slug' => $this->category->slug];
		}

		if (!($this->whenLoaded('reactions') instanceof MissingValue)) {
			$data['reactions_count'] = ArticleActions::prepareReactionsArray($this->reactions);
		}

		return $data;
	}
}
