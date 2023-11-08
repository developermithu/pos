<?php

namespace App\Models;

use App\Enums\TransactionStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'status' => TransactionStatus::class,
    ];

    /**
     * Get the sale that owns the Transaction
     */
    public function sale(): BelongsTo
    {
        return $this->belongsTo(Sale::class);
    }
}
