<?php

namespace App\Http\Requests\Admin\Core_Data\Circle;

use Illuminate\Foundation\Http\FormRequest;

class EditRequest extends FormRequest
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
            'title' => 'required|max:255|string|unique:circles,title,'.$this->id.',id',
            'order' => 'required|max:255|number|unique:circles,order,'.$this->id.',id',
        ];

    }
    public function messages()
    {
        return [
            'title.required' => 'برجاء ادخال الاسم',
        ];
    }
}
