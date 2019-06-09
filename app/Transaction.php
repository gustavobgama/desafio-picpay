<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    /**
     * @inheritDoc
     */
    protected $guarded = [];

    /**
     * @inheritDoc
     */
    protected $dateFormat = 'Y-m-d\TH:i:s.u\Z';

    /**
     * @inheritDoc
     */
    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    /**
     * @inheritDoc
     */
    protected $appends = [
        'transaction_date',
    ];

    protected $casts = [
        'payee_id' => 'integer',
        'payer_id' => 'integer',
        'value' => 'integer',
    ];

    /**
     * Get created_at.
     *
     * @return string
     */
    public function getTransactionDateAttribute(): string
    {
        return $this->attributes['created_at'];
    }
}
