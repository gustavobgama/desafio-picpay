<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ConsumerInterface
{
    /**
     * Create consumer and link it to a existent user.
     *
     * @param integer $userId
     * @param string $username
     * @throws ModelNotFoundException
     * @return array
     */
    public function create(int $userId, string $username): array;
}
