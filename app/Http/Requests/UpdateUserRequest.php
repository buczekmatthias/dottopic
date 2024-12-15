<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateUserRequest extends FormRequest
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
			'name' => ['string', 'required'],
			'username' => ['string', 'required', 'unique:users,username,'.$this->route()->parameter('user')->id],
			'password' => ['string', 'nullable', 'exclude'],
			'email' => ['email', 'required', 'unique:users,username,'.$this->route()->parameter('user')->id],
			'bio' => ['string', 'nullable', 'max:50'],
		];
	}

	public function messages(): array
	{
		return [
			'name.string' => 'Name must be a string',
			'name.required' => 'Name must be provided',
			'username.string' => 'Username must be a string',
			'username.required' => 'Username must be provided',
			'username.unique' => 'Username must be unique',
			'email.email' => 'E-mail must be valid email',
			'email.required' => 'E-mail must be provided',
			'email.unique' => 'E-mail must be unique',
			'bio.string' => 'Bio must be a string',
			'bio.max' => 'Bio must be no longer than :max characters'
		];
	}
}
