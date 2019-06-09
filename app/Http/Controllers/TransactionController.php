<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionInterface;
use App\Http\Requests\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;

class TransactionController extends Controller
{
    /**
     * @var TransactionInterface
     */
    protected $transaction;

    /**
     * @var Client
     */
    protected $client;

    /**
     * Create a new controller instance.
     *
     * @param TransactionInterface $transaction
     * @param Client $client
     * @return void
     */
    public function __construct(TransactionInterface $transaction, Client $client)
    {
        $this->transaction = $transaction;
        $this->client = $client;
    }

    /**
     * Store transaction.
     *
     * @param Transaction $request
     * @param Client $client
     * @return JsonResponse
     */
    public function store(Transaction $request): JsonResponse
    {
        $payeeId = $request->get('payee_id');
        $payerId = $request->get('payer_id');
        $value = $request->get('value');

        if ($this->transactionIsValid($value)) {
            $response = $this->transaction->create($payeeId, $payerId, $value);

            return response()->json($response);
        } else {
            return response()->json([
                'code' => '401',
                'message' => 'Transação não autorizada',
            ], 401);
        }
    }

    /**
     * Check if transaction is valid.
     *
     * @param float $value
     * @return boolean
     */
    protected function transactionIsValid(float $value): bool
    {
        // TODO: move this method to Transaction validation request class
        try {
            $response = $this->client->post('/transactions/authorize', ['json' => ['value' => $value]]);
        } catch (\Exception $e) {
            return false;
        }

        return ($response->getStatusCode() === 200);
    }
}
