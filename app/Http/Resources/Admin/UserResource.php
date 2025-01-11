<?php

namespace App\Http\Resources\Admin;

use App\Services\Roles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
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
			'id' => $this->id,
			'name' => $this->name,
			'username' => $this->username,
			'email' => $this->email,
			'role' => Str::ucfirst($this->role->value),
			'articles_count' => $this->whenCounted('articles'),
			'comments_count' => $this->whenCounted('comments'),
			'created_at' => $this->created_at->format('F j, Y'),
			'can_be_promoted' => Roles::canBePromoted($this->resource),
			'can_be_demoted' => Roles::canBeDemoted($this->resource)
		];
	}
}
