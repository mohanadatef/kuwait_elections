<?php

namespace App\Http\Requests\Admin\Setting\Contact_Us;

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
            'email' => 'required|string|email|max:255',
            'latitude'=>'required',
            'longitude'=>'required',
            'phone'=>'required|min:1',
            'address'=>'required|string|max:255',
            'time_work'=>'required|string|max:255',
        ];
    }
    public function messages()
    {
        return [
            'email.required' => 'برجاء ادخال البريد الالكتورني',
            'time_work.required' => 'برجاء ادخال وقت العمل',
            'address.required' => 'برجاء ادخال العنوان',
            'phone.required' => 'برجاء ادخال الهاتف',
            'longitude.required' => 'برجاء ادخال خط الطول',
            'latitude.required' => 'برجاء ادخال خط العرض',

        ];
    }
}
