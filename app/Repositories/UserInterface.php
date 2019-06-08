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

    /**
     * List users filtering by the informed query.
     *
     * @param string|null $query
     * @return array
     */
    public function list(?string $query): array;
}
