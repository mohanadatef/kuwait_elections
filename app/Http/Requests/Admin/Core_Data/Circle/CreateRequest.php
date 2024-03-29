<?php

namespace App\Http\Requests\Admin\Core_Data\Circle;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
            'title' => 'required|string|max:255|unique:circles',
            'order'=>'required|string|unique:circles',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'برجاء ادخال الاسم',
        ];
    }
}
