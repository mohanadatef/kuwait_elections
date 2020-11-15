<?php

namespace App\Http\Requests\Admin\Core_Data\Area;

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
            'title' => 'required|string|max:255|unique:areas',
            'country_id' => 'required|exists:countries,id',
            'city_id' => 'required|exists:cities,id',
            'order'=>'required|number|unique:areas',
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
