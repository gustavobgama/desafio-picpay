<?php

namespace App\Http\Controllers;

use App\Repositories\SellerInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Seller;

class SellerController extends Controller
{

    /**
     * @var SellerInterface
     */
    protected $seller;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SellerInterface $seller)
    {
        $this->seller = $seller;
    }

    /**
     * Store a seller (linking it to a user).
     *
     * @param Consumer $request
     * @return JsonResponse
     */
    public function store(Seller $request): JsonResponse
    {
        $userId = $request->get('user_id');
        $username = $request->get('username');
        $cnpj = $request->get('cnpj');
        $fantasyName = $request->get('fantasy_name');
        $socialName = $request->get('social_name');

        try {
            $response = $this->seller->create($userId, $username, $cnpj, $fantasyName, $socialName);

            return response()->json($response);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => '404',
                'message' => 'Usuário não encontrado',
            ], 404);
        }
    }
}
