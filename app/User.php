<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    /**
     * @inheritDoc
     */
    protected $fillable = [
        'cpf',
        'email',
        'full_name',
        'password',
        'phone_number',
    ];

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
