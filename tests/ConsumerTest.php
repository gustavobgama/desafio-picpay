<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\User;

class ConsumerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var array
     */
    protected $parameters = [
        'user_id' => 1,
        'username' => 'joao.silva',
    ];

    public function missingFieldProvider()
    {
        return [
            'user_id' => ['user_id'],
            'username' => ['username'],
        ];
    }

    /**
     * @test
     * @dataProvider missingFieldProvider
     */
    public function itTriesToCreateAConsumerWithAMissingField($missingField)
    {
        unset($this->parameters[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/users/consumers', $this->parameters)
            ->seeStatusCode(422)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateAConsumerForAnExistentUser()
    {
        factory(User::class)->create($this->userOne);
        $username = 'joaosilva';

        $this->post('/users/consumers', ['user_id' => 1, 'username' => $username])
            ->seeStatusCode(200)
            ->seeJsonEquals([
                'id' => 1,
                'user_id' => 1,
                'username' => $username,
            ]);

        $this->seeInDatabase('users', [
            'id' => 1,
            'cpf' => $this->userOne['cpf'],
            'email' => $this->userOne['email'],
            'username' => $username,
            'full_name' => $this->userOne['full_name'],
            'password' => $this->userOne['password'],
            'phone_number' => $this->userOne['phone_number'],
        ]);

        $this->seeInDatabase('consumers', [
            'user_id' => 1,
        ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateAConsumerForANonExistentUser()
    {
        $username = 'joaosilva';

        $this->post('/users/consumers', ['user_id' => 999, 'username' => $username])
            ->seeStatusCode(404)
            ->seeJsonEquals([
                'code' => '404',
                'message' => 'Usuário não encontrado',
            ]);
    }
}
