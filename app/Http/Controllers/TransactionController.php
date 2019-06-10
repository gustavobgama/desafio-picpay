<?php

namespace App\Http\Controllers;

use App\Repositories\TransactionInterface;
use App\Http\Requests\Transaction;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * Show a specific transaction.
     *
     * @param integer $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $response = $this->transaction->show($id);

            return response()->json($response);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => '404',
                'message' => 'Transação não encontrada',
            ], 404);
        }
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

        $response = $this->transaction->create($payeeId, $payerId, $value);

        return response()->json($response);
    }
}
