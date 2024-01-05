<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'account_id',
        'amount',
        'payment_method',
        'reference',
        'note',
        'paymentable_id',
        'paymentable_type'
    ];

    public function paymentable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Get the account that owns the Payment
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
