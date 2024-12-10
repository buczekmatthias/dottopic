<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class RegisterRequest extends FormRequest
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
			'name' => ['string', 'required'],
			'username' => ['string', 'required', 'unique:users,username'],
			'email' => ['email', 'required', 'unique:users,email'],
			'password' => ['string', 'required'],
		];
	}

	public function messages()
	{
		return [
			'name.string' => 'Must be a valid string',
			'name.required' => 'Name must be provided',
			'username.string' => 'Must be a valid string',
			'username.required' => 'Username must be provided',
			'username.unique' => 'Username must be unique',
			'email.email' => 'Must be a valid e-mail',
			'email.required' => 'E-mail must be provided',
			'email.unique' => 'E-mail must be unique',
			'password.string' => 'Password must be string',
			'password.required' => 'Password must be provided',
		];
	}
}
