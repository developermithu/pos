<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade =  ['deposits'];

    protected $fillable = [
        'name',
        'company_name',
        'address',
        'phone_number',
        'deposit',
        'expense',
    ];

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    /**
     * Get the deposits associated with the Customer
     */
    public function deposits(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable')->withTrashed();
    }
}
