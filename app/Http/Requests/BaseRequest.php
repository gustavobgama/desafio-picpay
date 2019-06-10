<?php

namespace App\Http\Requests;

use Pearl\RequestValidate\RequestAbstract;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\Validation\Rule;

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
        $statusCode = 422;
        $failedRule = key(array_values($validator->failed())[0]);
        if (class_exists($failedRule) && $interfaces = class_implements($failedRule)) {
            if (isset($interfaces[Rule::class])) {
                $statusCode = (new $failedRule)->getStatusCode();
            }
        }

        // show just one error message (the first)
        $error = [
            'code' => (string)$statusCode,
            'message' => $validator->getMessageBag()->first(),
        ];

        return new JsonResponse($error, $statusCode);
    }
}
