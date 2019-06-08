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

    /**
     * @inheritDoc
     */
    public function list(?string $query): array
    {
        if (isset($query)) {
            $users = UserModel::where('full_name', 'like', "%{$query}%")->get();
        } else {
            $users = UserModel::all();
        }

        return $users->sortBy('full_name')->toArray();
    }
}
