<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CreateCommentRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return Auth::user() !== null;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'content' => ['string', 'required'],
			'author' => ['string', 'required', 'exists:users,username'],
			'article' => ['string', 'required', 'exists:articles,slug']
		];
	}

	public function messages(): array
	{
		return [
			'content.string' => 'Content must be a string',
			'content.required' => 'Content must be provided',
			'author.string' => 'Author must be a string',
			'author.required' => 'Author must be provided',
			'author.exists' => 'Author must exist',
			'article.string' => 'Article must be a string',
			'article.required' => 'Article must be provided',
			'article.exists' => 'Article must exist',
		];
	}
}
