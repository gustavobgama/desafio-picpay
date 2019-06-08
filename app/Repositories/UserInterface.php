<?php

namespace App\Repositories;

interface UserInterface
{
    /**
     * Create user.
     *
     * @param array $data
     * @return array
     */
    public function create(array $data): array;
}
