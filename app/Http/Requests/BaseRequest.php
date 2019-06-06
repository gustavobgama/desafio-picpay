<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;

class BaseRequest extends RequestAbstract
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
     * @inheritDoc
     */
    protected function formatErrors(Validator $validator)
    {
        // show just one error message (the first)
        $error = [
            'code' => '422',
            'message' => $validator->getMessageBag()->first(),
        ];

        return new JsonResponse($error, 422);
    }
}
