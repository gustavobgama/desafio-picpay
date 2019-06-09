<?php

namespace App\Repositories;

use App \ {
    Consumer as ConsumerModel,
    Account,
    User
};
use Illuminate\Support\Facades\DB;
use Exception;

class Consumer implements ConsumerInterface
{
    /**
     * @inheritDoc
     */
    public function create(int $userId, string $username): array
    {
        try {
            DB::beginTransaction();
            $user = User::findOrFail($userId);
            $user->username = $username;
            $user->save();

            $account = Account::create();
            $consumer = new ConsumerModel();
            $consumer->account_id = $account->id;
            $consumer = $user->consumer()->save($consumer);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return [
            'id' => $consumer['id'],
            'user_id' => $userId,
            'username' => $username,
        ];
    }
}
