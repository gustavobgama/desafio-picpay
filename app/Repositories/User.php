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

    /**
     * @inheritDoc
     */
    public function show(int $id): array
    {
        $user = UserModel::findOrFail($id);
        $userData = $user->toArray();

        $response = [
            'accounts' => [
                'user' => $userData,
            ]
        ];

        if (isset($user->consumer)) {
            $consumerData = $user->consumer->toArray();
            $response['accounts']['consumer'] = [
                'id' => $consumerData['id'],
                'user_id' => $userData['id'],
                'username' => $user['username'],
            ];
        }

        if (isset($user->seller)) {
            $sellerData = $user->seller->toArray();
            $response['accounts']['seller'] = [
                'id' => $sellerData['id'],
                'user_id' => $userData['id'],
                'username' => $user['username'],
                'cnpj' => $sellerData['cnpj'],
                'fantasy_name' => $sellerData['fantasy_name'],
                'social_name' => $sellerData['social_name'],
            ];
        }

        return $response;
    }
}
