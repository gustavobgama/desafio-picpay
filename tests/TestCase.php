<?php

namespace Tests;

use Laravel\Lumen\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{

    /**
     * @var array
     */
    protected $userOne = [
        'cpf' => '11111111111',
        'email' => 'joao.silva@email.com',
        'full_name' => 'Joao Silva',
        'password' => 'lorem',
        'phone_number' => '(11) 1111-1111',
    ];

    /**
     * @var array
     */
    protected $userTwo = [
        'cpf' => '22222222222',
        'email' => 'maria.silva@email.com',
        'full_name' => 'Maria Silva',
        'password' => 'ipsum',
        'phone_number' => '(11) 2222-2222',
    ];

    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__ . '/../bootstrap/app.php';
    }
}
