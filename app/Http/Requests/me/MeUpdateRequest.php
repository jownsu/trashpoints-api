<?php

namespace App\Http\Requests\me;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MeUpdateRequest extends FormRequest
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
            'email'            => 'email|required|string|unique:users,email,'. $this->id,
            'firstname'        => 'required|min:2',
            'middlename'       => 'nullable',
            'lastname'         => 'required|min:2',
            'address'          => 'required|min:2',
            'contact_no'       => 'required|min:2',
            'confirm_password' => 'required'
        ];
    }
}
