<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserImageRequest extends FormRequest
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
			'image' => ['image', 'required', 'max:5000']
		];
	}

	public function messages(): array
	{
		return [
			'image.image' => 'Image must be in valid format (jpg/jpeg/png/webp)',
			'image.required' => 'Image must be provided',
			'image.max' => 'Image size must be below 5MB'
		];
	}
}
