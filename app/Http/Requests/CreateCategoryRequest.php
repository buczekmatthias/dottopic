<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCategoryRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		/** @var \App\Model\User */
		$user = Auth::user();

		return $user->isMod() || $user->isAdmin() || $user->isDev();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'name' => ['string', 'required', 'unique:tags,name'],
			'tags' => ['array'],
			'tags.*' => ['string', 'required', 'exists:tags,name']
		];
	}

	public function messages(): array
	{
		return [
			'name.string' => 'Name must be string',
			'name.required' => 'Name must be provided',
			'name.unique' => 'Name must be unique',
			'tags.array' => 'Tags must be array',
			'tags.*.string' => 'Tag must be string',
			'tags.*.required' => 'Tag must be provided',
			'tags.*.exists' => 'Tag must exist',
		];
	}
}
