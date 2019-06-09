<?php

namespace App\Repositories;

interface TransactionInterface
{
    /**
     * Create transaction.
     *
     * @param integer $payeeId
     * @param integer $payerId
     * @param float $value
     * @return array
     */
    public function create(int $payeeId, int $payerId, float $value): array;
}
