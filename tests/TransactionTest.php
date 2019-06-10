<?php

namespace Tests;

use App \ {
    User,
    Consumer,
    Seller,
    Transaction
};

class TransactionTest extends TestCase
{
    /**
     * @var array
     */
    protected $transaction;

    /**
     * @var int
     */
    protected $accountUserOne;

    /**
     * @var int
     */
    protected $accountUserTwo;

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

        $this->accountUserOne = $userOne->consumer->account->id;
        $this->accountUserTwo = $userTwo->consumer->account->id;
        $this->transaction = [
            'payee_id' => $this->accountUserOne,
            'payer_id' => $this->accountUserTwo,
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
            ->seeJsonEquals([
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
            ->seeJsonEquals([
                'code' => '422',
                'message' => 'Uma das contas informadas não existe.',
            ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveOneTransaction()
    {
        factory(Transaction::class)->create([
            'payee_id' => $this->accountUserOne,
            'payer_id' => $this->accountUserTwo,
            'value' => 50,
        ]);
        $this->get('/transactions/1')
            ->seeStatusCode(200)
            ->seeJson([
                'id' => 1,
                'payee_id' => $this->accountUserOne,
                'payer_id' => $this->accountUserTwo,
                'value' => 50,
            ]);
    }

    /**
     * @test
     */
    public function itTriesToRetrieveAUnexistentTransaction()
    {
        $this->get('/transactions/1')
            ->seeStatusCode(404)
            ->seeJsonEquals([
                'code' => '404',
                'message' => 'Transação não encontrada',
            ]);
    }
}
