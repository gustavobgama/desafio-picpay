<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use GuzzleHttp\Client;
use Exception;

class IsAuthorized extends BaseRule implements Rule
{

    /**
     * @inheritDoc
     */
    protected $statusCode = 401;

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  float  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        $client = app(Client::class);

        try {
            $response = $client->post('/transactions/authorize', ['json' => ['value' => $value]]);
        } catch (Exception $e) {
            return false;
        }

        return ($response->getStatusCode() === 200);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Transação não autorizada';
    }
}
