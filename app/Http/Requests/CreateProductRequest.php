<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'category_id' => 'required',
			'name' => 'required|string|min:2|max:255|unique:products',
			'price' => 'required|numeric',
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

			'price.required' => 'Цена должна быть заполнена.',

			'category_id.required' => 'Не выбрана категория.',
		];
	}
}
