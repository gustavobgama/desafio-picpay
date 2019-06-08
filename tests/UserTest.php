<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

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
        unset($this->userOne[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/users', $this->userOne)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }

    /**
     * @test
     */
    public function itTriesToListTwoUsersWithoutFilter()
    {
        factory(User::class)->create($this->userOne);
        factory(User::class)->create($this->userTwo);

        $this->get('/users')
            ->seeJsonEquals([
                [
                    'id' => 1,
                    'cpf' => $this->userOne['cpf'],
                    'email' => $this->userOne['email'],
                    'full_name' => $this->userOne['full_name'],
                    'password' => $this->userOne['password'],
                    'phone_number' => $this->userOne['phone_number'],

                ],
                [
                    'id' => 2,
                    'cpf' => $this->userTwo['cpf'],
                    'email' => $this->userTwo['email'],
                    'full_name' => $this->userTwo['full_name'],
                    'password' => $this->userTwo['password'],
                    'phone_number' => $this->userTwo['phone_number'],

                ],
            ]);
    }

    /**
     * @test
     */
    public function itTriesToListOneUserWithFilter()
    {
        factory(User::class)->create($this->userOne);
        factory(User::class)->create($this->userTwo);

        $this->get('/users?q=maria')
            ->seeJsonEquals([
                [
                    'id' => 2,
                    'cpf' => $this->userTwo['cpf'],
                    'email' => $this->userTwo['email'],
                    'full_name' => $this->userTwo['full_name'],
                    'password' => $this->userTwo['password'],
                    'phone_number' => $this->userTwo['phone_number'],

                ],
            ]);
    }

    /**
     * @test
     */
    public function itTriesToListNoUserWithFilter()
    {
        factory(User::class)->create($this->userOne);
        factory(User::class)->create($this->userTwo);

        $this->get('/users?q=UserNotExistent')
            ->seeJsonEquals([]);
    }

    /**
     * @test
     */
    public function itTriesToCreateAUser()
    {
        $this->post('/users', $this->userOne)
            ->seeJsonEquals([
                'id' => 1,
                'cpf' => $this->userOne['cpf'],
                'email' => $this->userOne['email'],
                'full_name' => $this->userOne['full_name'],
                'password' => $this->userOne['password'],
                'phone_number' => $this->userOne['phone_number'],
            ]);

        $this->assertEquals(200, $this->response->getStatusCode());

        $this->seeInDatabase('users', [
            'id' => 1,
            'cpf' => $this->userOne['cpf'],
            'email' => $this->userOne['email'],
            'full_name' => $this->userOne['full_name'],
            'password' => $this->userOne['password'],
            'phone_number' => $this->userOne['phone_number'],
        ]);
    }
}
