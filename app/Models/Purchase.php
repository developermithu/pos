<?php

namespace App\Models;

use App\Enums\PurchasePaymentStatus;
use App\Enums\PurchaseStatus;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade =  ['items', 'payments'];

    protected $guarded = [];

    protected $casts = [
        'status' => PurchaseStatus::class,
        'payment_status' => PurchasePaymentStatus::class,
        'date' => 'date:Y-m-d',
    ];

    /**
     * Get the supplier that owns the purchase
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    /**
     * Get all of the items for the purchase
     */
    public function items(): HasMany
    {
        return $this->hasMany(PurchaseItem::class);
    }

    /**
     * Get the payments associated with the purchase
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable')->withTrashed();
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
