<?php

namespace App\Http\Requests\Admin\ACl\Role;

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
            'name'=>'required|unique:roles',
            'display_name'=>'required|max:255|string',
            'description'=>'required|max:255|string',
            'permission' => 'required|exists:permissions,id',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'برجاء ادخال الاسم',
            'display_name.required' => 'برجاء ادخال اسم العرض',
            'description.required' => 'برجاء ادخال الوصف',
            'permission.required' => 'برجاء ادخال الاذن',
        ];
    }
}
