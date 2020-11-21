<?php

namespace App\Http\Requests\Admin\ACl\User;

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
            'username' => 'string|max:255|unique:users',
            'name' => 'string|max:255',
            'family' => 'string|max:255',
            'mobile' => 'string|unique:users',
            'role_id' => 'exists:roles,id',
            'circle_id' => 'exists:circles,id',
            'area_id' => 'exists:areas,id',
            'email' => 'string|email|max:255|unique:users',
            'password' => 'string|min:6|confirmed',
        ];
    }
    public function messages()
    {
        return [
            'password.required' => 'برجاء ادخال كلمه السر',
            'username.required' => 'برجاء ادخال اسم المستخدم',
            'name.required' => 'برجاء ادخال اسم ',
            'family.required' => 'برجاء ادخال اسم القابيله',
            'mobile.required' => 'برجاء ادخال الهاتف',
            'role_id.required' => 'برجاء ادخال نوع المستخدم',
            'circle_id.required' => 'برجاء ادخال الدائرة',
            'area_id.required' => 'برجاء ادخال المنطقه',
            'email.required' => 'برجاء ادخال البريد الالكتروني',
        ];
    }
}
