<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var array
     */
    protected $content = [
        'cpf' => '11111111111',
        'email' => 'joao.silva@email.com',
        'full_name' => 'Joao Silva',
        'password' => 'lorem',
        'phone_number' => '(11) 1111-1111',
    ];

    public function missingFieldProvider()
    {
        return [
            'cpf' => ['cpf'],
            'email' => ['email'],
            'full_name' => ['full_name'],
            'password' => ['password'],
            'phone_number' => ['phone_number'],
        ];
    }

    /**
     * @test
     * @dataProvider missingFieldProvider
     */
    public function itTriesToCreateAUserWithAMissingField($missingField)
    {
        unset($this->content[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/users', $this->content)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }
}
