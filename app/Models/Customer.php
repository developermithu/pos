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
        'deposit'
    ];

    public function totalSale(): ?int
    {
        return $this->sales->whereNull('deleted_at')->sum('total');
    }

    public function totalPaid(): ?int
    {
        return $this->sales->whereNull('deleted_at')->sum('paid_amount');
    }

    public function totalDue(): ?int
    {
        return $this->totalSale() - $this->totalPaid();
    }

    /**
     * Relationships
    */

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function deposits(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable')->withTrashed();
    }
}
