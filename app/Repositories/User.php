<?php

namespace App\Repositories;

use App\User as UserModel;

class User implements UserInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $data): array
    {
        $user = UserModel::create($data);

        return $user->toArray();
    }
}
