<?php

namespace App\Http\Requests;

use App\Services\Reactions;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateReactionRequest extends FormRequest
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
			'model' => ['string', 'required', 'in:article,comment'],
			'reaction' => ['string', 'required', Rule::in(array_keys(Reactions::getAvailableReactions()))],
			'slug' => ['string', 'required', 'exists:articles,slug']
		];
	}
}
