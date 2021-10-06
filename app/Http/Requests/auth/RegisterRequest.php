<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email'      => 'email|required|string|unique:users,email',
            'password'   => 'required|confirmed',
            'firstname'  => 'required|min:2',
            'middlename' => 'nullable',
            'lastname'   => 'required|min:2',
            'address'    => 'required|min:2',
            'contact_no' => 'required|min:2'
        ];
    }
}
