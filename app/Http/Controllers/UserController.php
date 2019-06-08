<?php

namespace App\Http\Controllers;

use App\Http\Requests\User as UserRequest;
use App\Repositories\UserInterface;
use Illuminate\Http\Request;

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
    public function list(Request $request): array
    {
        return $this->user->list($request->get('q'));
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
