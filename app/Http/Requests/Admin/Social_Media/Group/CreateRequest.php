<?php

namespace App\Http\Requests\Admin\Social_Media\Group;

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
            'about'=>'required|string',
            'title'=>'required|string|max:255',
            'image'=> 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'برجاء ادخال العنوان',
            'about.required' => 'برجاء ادخال الوصف',
            'image.required' => 'برجاء ادخال الصوره',

        ];
    }
}
