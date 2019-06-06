<?php

namespace App\Http\Controllers;

use App\Http\Requests\User as UserRequest;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function store(UserRequest $request)
    {
        // TODO: save user
    }
}
