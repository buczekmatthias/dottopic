<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class LoginRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return !Auth::user();
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		return [
			'email' => ['email', 'required', 'exists:users,email'],
			'password' => ['string', 'required'],
			'remember_me' => ['boolean', 'nullable']
		];
	}

	public function messages()
	{
		return [
			'email.email' => 'Must be a valid e-mail',
			'email.required' => 'E-mail must be provided',
			'email.exists' => 'E-mail doesn\'t exist',
			'password.string' => 'Password must be string',
			'password.required' => 'Password must be provided',
			'remember_me.boolean' => 'Remember me must be a boolean',
		];
	}
}
