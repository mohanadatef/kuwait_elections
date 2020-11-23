<?php

namespace App\Http\Requests\Admin\Election\Vote;

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
            'title' => 'required|string|unique:votes,title,'.$this->id.',id',
            'circle_id' => 'required|exists:circles,id',
        ];
    }

}
