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
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'family' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users',
            'role_id' => 'required|exists:roles,id',
            'circle_id' => 'required|exists:circles,id',
            'area_id' => 'required|exists:areas,id',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
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
