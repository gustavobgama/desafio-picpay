<?php

namespace App\Http\Controllers;

use App\Http\Requests\User as UserRequest;
use App\Repositories\UserInterface;

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
     * Store user.
     *
     * @param UserRequest $request
     * @return Response
     */
    public function store(UserRequest $request)
    {
        return $this->user->create($request->all());
    }
}
