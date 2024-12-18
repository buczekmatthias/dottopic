<?php

namespace App\Http\Requests;

use App\Enum\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateArticleRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return Auth::user() && Auth::user()->role !== UserRole::USER;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'title' => ['string', 'required'],
			'description' => ['string', 'required'],
			'content' => ['array', 'required', 'min:1'],
			'content.*' => ['array'],
			'content.*.type' => ['string', 'required', 'in:header,text,file'],
			'content.*.content' => ['string', 'required'],
			'category_slug' => ['string', 'required', 'exists:categories,slug'],
			'tags' => ['array'],
			'tags.*' => ['string', 'required', 'exists:tags,slug']
		];
	}

	public function messages(): array
	{
		return [
			'title.string' => 'Title must be a string',
			'title.required' => 'Title must be provided',
			'description.string' => 'Description must be a string',
			'description.required' => 'Description must be provided',
			'content.array' => 'Content must be an array',
			'content.required' => 'Content must be provided',
			'content.min' => 'Content must contain at least :min item(s)',
			'content.*.array' => 'Content item must be an array',
			'content.*.type.string' => 'Content item type must be a string',
			'content.*.type.required' => 'Content item type must be provided',
			'content.*.type.in' => 'Content item type must be in array of :values',
			'content.*.content.string' => 'Content item content must be a string',
			'content.*.content.required' => 'Content item content must be provided',
			'category_slug.string' => 'Category slug must be a string',
			'category_slug.required' => 'Category slug must be provided',
			'category_slug.exists' => 'Category slug must exist',
			'tags.array' => 'Tags must be an array',
			'tags.*.string' => 'Tag item must be a string',
			'tags.*.required' => 'Tag item must be provided',
			'tags.*.exists' => 'Tag item must exist',
		];
	}
}
