<?php

namespace App\Http\Requests\Admin\Election\Vote;

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
            'change_status' => 'required|exists:votes,id',
        ];
    }
    public function messages()
    {
        return [
            'change_status.required' => 'برجاء ادخال الاستبيان',

        ];
    }
}
