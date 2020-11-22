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
            'family_name' => 'string|max:255',
            'name' => 'string|max:255',
            'first_name' => 'string|max:255',
            'second_name' => 'string|max:255',
            'third_name' => 'string|max:255',
            'forth_name' => 'exists:areas,id',
            'area_id' => 'exists:areas,id',
            'gender' => 'string',
            'internal_reference' => 'string',
            'civil_reference' => 'string|unique:users',
            'job' => 'string|max:255',
            'address' => 'string|max:255',
            'registration_status' => 'string|max:255',
            'registration_number' => 'string|max:255',
            'registration_data' => 'string|max:255',
            'circle_id' => 'exists:circles,id',
            'password' => 'string|min:6|confirmed',
            'mobile' => 'string|max:255|unique:users',
            'about' => 'string|max:255',
            'email' => 'email|max:255|string|unique:users',
            'birth_day' => 'data',
        ];
    }
}
