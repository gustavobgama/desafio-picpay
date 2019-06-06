<?php

namespace App\Http\Requests;

class User extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf' => 'required',
            'email' => 'required',
            'full_name' => 'required',
            'password' => 'required',
            'phone_number' => 'required',
        ];
    }
}
