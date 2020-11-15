<?php

namespace App\Http\Requests\Admin\ACl\Permission;

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
                'name'=>'unique:permissions,title,'.$this->id.',id',
                'display_name'=>'required|max:255|string',
                'description'=>'required|max:255|string',
            ];
    }
    public function messages()
    {
        return [
            'name.required' => 'برجاء ادخال الاسم',
            'display_name.required' => 'برجاء ادخال اسم العرض',
            'description.required' => 'برجاء ادخال الوصف',
        ];
    }
}
