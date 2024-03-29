<?php

namespace App\Http\Requests\Admin\Setting\Setting;

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
            'facebook'=> 'required',
            'youtube'=> 'required',
            'twitter'=> 'required',
            'title'=>'required|string|max:255',
            'image'=> 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
            'logo'=> 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ];
    }
    public function messages()
    {
        return [
            'title.required' => 'برجاء ادخال العنوان',
            'facebook.required' => 'برجاء ادخال الفيس بوك',
            'twitter.required' => 'برجاء ادخال تويتر',
            'youtube.required' => 'برجاء ادخال اليوتيوب',
            'image.required' => 'برجاء ادخال الصوره الموقع',
            'logo.required' => 'برجاء ادخال الصوره الشعار',

        ];
    }
}
