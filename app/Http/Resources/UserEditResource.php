<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserEditResource extends JsonResource
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
			'email' => $this->email,
			'image' => $this->when($this->image, asset(Storage::url("pfp/{$this->image}"))),
			'bio' => $this->bio,
		];
	}
}
