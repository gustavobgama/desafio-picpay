<?php

namespace App\Http\Controllers;

use App\Http\Requests\Consumer;
use App\Repositories\ConsumerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

class ConsumerController extends Controller
{

    /**
     * @var ConsumerInterface
     */
    protected $consumer;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ConsumerInterface $consumer)
    {
        $this->consumer = $consumer;
    }

    /**
     * Store a consumer (updating a user with a username).
     *
     * @param Consumer $request
     * @return JsonResponse
     */
    public function store(Consumer $request): JsonResponse
    {
        $userId = $request->get('user_id');
        $username = $request->get('username');

        try {
            $response = $this->consumer->create($userId, $username);

            return response()->json($response);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => '404',
                'message' => 'Usuário não encontrado',
            ], 404);
        }
    }
}
