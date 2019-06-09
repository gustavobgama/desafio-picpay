<?php

namespace Tests;

use Laravel\Lumen\Testing\DatabaseMigrations;
use App \ {
    User,
    Consumer,
    Seller
};

class TransactionTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var array
     */
    protected $transaction;

    /**
     * @inheritDoc
     */
    public function setUp(): void
    {
        parent::setUp();
        // register two consumers to transfer money between each other
        $userOne = factory(User::class)->create($this->userOne);
        $userOne->consumer()->save(factory(Consumer::class)->make());

        $userTwo = factory(User::class)->create($this->userTwo);
        $userTwo->consumer()->save(factory(Consumer::class)->make());

        $this->transaction = [
            'payee_id' => $userOne->consumer->account->id,
            'payer_id' => $userTwo->consumer->account->id,
            'value' => 50,
        ];
    }

    public function missingFieldProvider()
    {
        return [
            'payee_id' => ['payee_id'],
            'payer_id' => ['payer_id'],
            'value' => ['value'],
        ];
    }

    /**
     * @test
     * @dataProvider missingFieldProvider
     */
    public function itTriesToCreateATransactionWithAMissingField($missingField)
    {
        unset($this->transaction[$missingField]);

        $missingFieldForMessage = str_replace('_', ' ', $missingField);
        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(422)
            ->seeJsonEquals([
                'code' => '422',
                'message' => "O campo {$missingFieldForMessage} é obrigatório.",
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenExistentConsumersButWithTooHighValue()
    {
        $this->transaction['value'] = 500;
        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(401)
            ->seeJson([
                'code' => '401',
                'message' => 'Transação não autorizada',
            ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenExistentConsumers()
    {
        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'payee_id' => $this->transaction['payee_id'],
                'payer_id' => $this->transaction['payer_id'],
                'value' => $this->transaction['value'],
            ]);

        $this->seeInDatabase('transactions', [
            'payee_id' => $this->transaction['payee_id'],
            'payer_id' => $this->transaction['payer_id'],
            'value' => $this->transaction['value'],
        ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenAConsumerAndASeller()
    {
        // register the seller
        $userThree = factory(User::class)->create($this->userThree);
        $userThree->seller()->save(factory(Seller::class)->make());
        $this->transaction['payee_id'] = $userThree->seller->account->id;

        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'payee_id' => $this->transaction['payee_id'],
                'payer_id' => $this->transaction['payer_id'],
                'value' => $this->transaction['value'],
            ]);

        $this->seeInDatabase('transactions', [
            'payee_id' => $this->transaction['payee_id'],
            'payer_id' => $this->transaction['payer_id'],
            'value' => $this->transaction['value'],
        ]);
    }

    /**
     * @test
     */
    public function itTriesToCreateATransactionBetweenNonExistentUsers()
    {
        $this->transaction['payee_id'] = 998;
        $this->transaction['payer_id'] = 999;

        $this->post('/transactions', $this->transaction)
            ->seeStatusCode(422)
            ->seeJson([
                'code' => '422',
                'message' => 'Uma das contas informadas não existe.',
            ]);
    }
}
