<?php

namespace App\Repositories;

use App\Transaction as TransactionModel;
use App\Account;

class Transaction implements TransactionInterface
{
    /**
     * @inheritDoc
     */
    public function create(int $payeeId, int $payerId, float $value): array
    {
        Account::findOrFail($payeeId);
        Account::findOrFail($payerId);

        $transaction = TransactionModel::create([
            'payee_id' => $payeeId,
            'payer_id' => $payerId,
            'value' => $value,
        ]);

        return $transaction->toArray();
    }
}
