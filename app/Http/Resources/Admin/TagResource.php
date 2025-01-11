<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\TagResource as UserTagResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
			'id' => $this->id,
			...UserTagResource::make($this)->toArray($request)
		];
	}
}
