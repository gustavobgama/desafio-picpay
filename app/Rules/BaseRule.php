<?php

namespace App\Rules;

abstract class BaseRule
{
    /**
     * Status code to return in case of not pass.
     *
     * @var integer
     */
    protected $statusCode = 422;

    /**
     * Get status code.
     *
     * @return integer
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
