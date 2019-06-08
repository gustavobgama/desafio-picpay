<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
        'username',
        'created_at',
        'updated_at',
    ];

    /**
     * Get consumer.
     *
     * @return HasOne
     */
    public function consumer(): HasOne
    {
        return $this->hasOne(Consumer::class);
    }
}
