<?php

namespace App\Models;

use App\Enums\CashbookEntryType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashbookEntry extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'type' => CashbookEntryType::class,
        'date' => 'date',
    ];

    protected function amount(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    /**
     * Get the store that owns the CashbookEntry
     */
    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }
}
