<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
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
		return [
			'name' => $this->name,
			'username' => $this->username,
			'image' => $this->when($this->image, asset(Storage::url("pfp/{$this->image}"))),
			'initials' => $this->initials,
			'bio' => $this->bio,
			'role' => Str::ucfirst($this->role->value),
			'articles_count' => $this->whenCounted('articles'),
			'comments_count' => $this->whenCounted('comments'),
			'created_at' => $this->created_at->format('F j, Y'),
		];
	}
}
