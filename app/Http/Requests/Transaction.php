<?php

namespace App\Http\Requests;

class Transaction extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'payee_id' => 'required|exists:accounts,id',
            'payer_id' => 'required|exists:accounts,id',
            'value' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'payee_id.exists' => 'Uma das contas informadas não existe.',
            'payer_id.exists' => 'Uma das contas informadas não existe.',
        ];
    }
}
