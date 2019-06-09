<?php

namespace App\Repositories;

interface TransactionInterface
{
    /**
     * Show transaction.
     *
     * @param integer $id
     * @return array
     */
    public function show(int $id): array;

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
