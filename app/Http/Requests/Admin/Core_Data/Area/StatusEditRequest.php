<?php

namespace App\Http\Requests\Admin\Core_Data\Area;

use Illuminate\Foundation\Http\FormRequest;

class StatusEditRequest extends FormRequest
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
            'change_status' => 'required|exists:areas,id',
        ];
    }
    public function messages()
    {
        return [
            'change_status.required' => 'برجاء ادخال المنطقه',

        ];
    }
}
