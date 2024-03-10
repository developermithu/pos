<?php

namespace App\Models;

use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected function initialBalance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : 0,
            set: fn ($value) => $value ? $value * 100 : 0,
        );
    }

    /**
     * Get the total credit & debit amount for the account.
     */
    public function totalCredit(): ?int
    {
        return $this->payments
            ->where('type', PaymentType::CREDIT)
            ->whereNull('deleted_at')
            ->sum('amount');
    }

    public function totalDebit(): ?int
    {
        return $this->payments
            ->where('type', PaymentType::DEBIT)
            ->whereNull('deleted_at')
            ->sum('amount');
    }

    public function totalBalance(): ?int
    {
        return $this->totalCredit() + $this->initial_balance - $this->totalDebit();
    }

    // ========== Relationships =========== //
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ulid = (string) strtolower(Str::ulid());
        });
    }
}
