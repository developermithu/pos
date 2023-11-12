<?php

namespace App\Models;

use App\Enums\SaleStatus;
use Dyrynda\Database\Support\CascadeSoftDeletes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
    use HasFactory, SoftDeletes, CascadeSoftDeletes;

    protected $cascadeDeletes = ['items', 'transaction'];

    protected $guarded = [];

    protected $casts = [
        'status' => SaleStatus::class,
        'date' => 'date:Y-m-d',
    ];

    /**
     * Get the customer that owns the Sale
     */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Get all of the items for the Sale
     */
    public function items(): HasMany
    {
        return $this->hasMany(SaleItem::class);
    }

    /**
     * Get the transaction associated with the Sale
     */
    public function transaction(): HasOne
    {
        return $this->hasOne(Transaction::class);
    }

    // Mutators
    protected function subtotal(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function total(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value / 100,
            set: fn ($value) => $value * 100,
        );
    }

    protected function tax(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value ? $value * 100 : null,
        );
    }
}
