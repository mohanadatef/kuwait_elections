<?php

namespace App\Http\Requests\Admin\Setting\About_us;

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
                'description'=>'required|string',
                'title'=>'required|string|max:255',
                'image' => 'image|mimes:jpg,jpeg,png,gif|max:2048',
            ];


    }
    public function messages()
    {
        return [
            'title.required' => 'برجاء ادخال العنوان',
            'description.required' => 'برجاء ادخال الوصف',


        ];
    }
}
