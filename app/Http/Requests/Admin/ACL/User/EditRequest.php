<?php

namespace App\Http\Requests\Admin\ACl\User;

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
            /*'username' => 'max:255|string|unique:users,username,'.$this->id.',id',
            'role_id' => 'exists:roles,id',
            'email' => 'email|max:255|string|unique:users,email,'.$this->id.',id',
            'mobile' => 'string|unique:users,mobile,'.$this->id.',id',
            'circle_id' => 'exists:circles,id',
            'area_id' => 'exists:areas,id',
            'name' => 'string|max:255',
            'family' => 'string|max:255',*/
        ];

    }
    public function messages()
    {
        return [
            'password.required' => 'برجاء ادخال كلمه السر',
            'username.required' => 'برجاء ادخال اسم المستخدم',
            'mobile.required' => 'برجاء ادخال الهاتف',
            'role_id.required' => 'برجاء ادخال نوع المستخدم',
            'circle_id.required' => 'برجاء ادخال الدائرة',
            'area_id.required' => 'برجاء ادخال المنطقه',
            'email.required' => 'برجاء ادخال البريد الالكتروني',
            'name.required' => 'برجاء ادخال اسم الاول',
            'family.required' => 'برجاء ادخال اسم العائله',
        ];
    }

}
