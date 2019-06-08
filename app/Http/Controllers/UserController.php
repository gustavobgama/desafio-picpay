<?php

namespace App\Http\Controllers;

use App\Http\Requests\User as UserRequest;
use App\Repositories\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * Create a new controller instance.
     *
     * @param UserInterface $user
     * @return void
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * List users.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {
        return $this->user->list($request->get('q'));
    }

    /**
     * Show a specific user.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        try {
            $response = $this->user->show($id);

            return response()->json($response);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'code' => '404',
                'message' => 'Usuário não encontrado',
            ], 404);
        }
    }

    /**
     * Store user.
     *
     * @param UserRequest $request
     * @return array
     */
    public function store(UserRequest $request): array
    {
        return $this->user->create($request->all());
    }
}
