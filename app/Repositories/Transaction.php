<?php

namespace App\Repositories;

use App\Transaction as TransactionModel;

class Transaction implements TransactionInterface
{

    /**
     * @inheritDoc
     */
    public function show(int $id): array
    {
        $transaction = TransactionModel::findOrFail($id);

        return $transaction->toArray();
    }

    /**
     * @inheritDoc
     */
    public function create(int $payeeId, int $payerId, float $value): array
    {
        $transaction = TransactionModel::create([
            'payee_id' => $payeeId,
            'payer_id' => $payerId,
            'value' => $value,
        ]);

        return $transaction->toArray();
    }
}
