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
     * @var array
     */
    protected $userThree = [
        'cpf' => '33333333333',
        'email' => 'jose.pereira@email.com',
        'full_name' => 'Jose Pereira',
        'password' => 'dolor',
        'phone_number' => '(11) 3333-3333',
    ];

    /**
     * @var array
     */
    protected $parameters = [
        'user_id' => 1,
        'username' => 'joaosilva',
        'cnpj' => '11111111111111',
        'fantasy_name' => 'Company fantasy name',
        'social_name' => 'Company social name',
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
