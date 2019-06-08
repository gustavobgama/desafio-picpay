<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Repositories\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Seller extends Model
{
    /**
     * @inheritDoc
     */
    protected $fillable = [
        'balance',
    ];

    /**
     * Get user.
     *
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
