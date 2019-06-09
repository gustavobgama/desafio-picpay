<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use App\User;

class SellerTest extends TestCase
{
    use DatabaseMigrations;

    public function missingFieldProvider()
    {
        return [
            'user_id' => ['user_id'],
            'username' => ['username'],
            'cnpj' => ['cnpj'],
            'fantasy_name' => ['fantasy_name'],
            'social_name' => ['social_name'],
        ];
    }

    /**
     * @test
     * @dataProvider missingFieldProvider
     */
    public function itTriesToCreateASellerWithAMissingField($missingField)
    {
        unset($this->parameters[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/users/sellers', $this->parameters)
            ->seeStatusCode(422)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateASellerForAnExistentUser()
    {
        factory(User::class)->create($this->userOne);

        $this->post('/users/sellers', $this->parameters)
            ->seeStatusCode(200)
            ->seeJsonEquals([
                'id' => 1,
                'user_id' => 1,
                'username' => $this->parameters['username'],
            ]);

        $this->seeInDatabase('users', [
            'id' => 1,
            'cpf' => $this->userOne['cpf'],
            'email' => $this->userOne['email'],
            'username' => $this->parameters['username'],
            'full_name' => $this->userOne['full_name'],
            'password' => $this->userOne['password'],
            'phone_number' => $this->userOne['phone_number'],
        ]);

        $this->seeInDatabase('sellers', [
            'user_id' => 1,
            'account_id' => 1,
            'cnpj' => $this->parameters['cnpj'],
            'fantasy_name' => $this->parameters['fantasy_name'],
            'social_name' => $this->parameters['social_name'],
        ]);

        $this->seeInDatabase('accounts', [
            'id' => 1,
            'balance' => 0.00,
        ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateASellerForANonExistentUser()
    {
        $this->post('/users/sellers', $this->parameters)
            ->seeStatusCode(404)
            ->seeJsonEquals([
                'code' => '404',
                'message' => 'Usuário não encontrado',
            ]);
    }
}
