<?php

namespace App\Http\Requests\Admin\Core_Data\Area;

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
            'title' => 'required|max:255|string|unique:areas,title,'.$this->id.',id',
            'order' => 'required|max:255|number|unique:areas,order,'.$this->id.',id',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
        ];

    }
    public function messages()
    {
        return [
            'city_id.required' => 'برجاء ادخال المدينه',
            'country_id.required' => 'برجاء ادخال البلد',
            'title.required' => 'برجاء ادخال الاسم',

        ];
    }
}
