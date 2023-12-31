<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'account_no',
        'name',
        'credit',
        'debit',
        'initial_balance',
        'total_balance',
        'is_default',
        'is_active',
        'details'
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'is_active' => 'boolean',
    ];

    protected function initialBalance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : 0,
            set: fn ($value) => $value ? $value * 100 : 0,
        );
    }

    protected function totalBalance(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : 0,
            set: fn ($value) => $value ? $value * 100 : 0,
        );
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($account) {
            $account->total_balance = $account->initial_balance;
        });
    }
}
