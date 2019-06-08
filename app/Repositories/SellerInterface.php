<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

interface SellerInterface
{
    /**
     * Create seller and link it to a existent user.
     *
     * @param integer $userId
     * @param string $username
     * @param string $cnpj
     * @param string $fantasyName
     * @param string $socialName
     * @return array
     */
    public function create(
        int $userId,
        string $username,
        string $cnpj,
        string $fantasyName,
        string $socialName
    ): array;
}
