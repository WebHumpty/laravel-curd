<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'parent_id' => 'required',
			'name' => 'required|string|min:2|max:255|unique:categories,name,' . $this->category->id,
		];
	}

	/**
	 * вернуть массив сообщений об ошибках
	 *
	 * @return string[]
	 */
	public function messages()
	{
		return [
			'name.required' => 'Название должно быть заполнено.',
			'name.min' => 'Название должно быть не менее 3 символов.',
			'name.string' => 'Название должно быть строкой.',
			'name.unique' => 'Это Название уже используется.',

			'parent_id.required' => 'ID категории не передан.',
		];
	}
}
