<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory, SoftCascadeTrait, SoftDeletes;

    // protected $softCascade = [''];

    protected $guarded = [];

    public function totalSale(): ?int
    {
        return $this->purchases->whereNull('deleted_at')->sum('total');
    }

    public function totalPaid(): ?int
    {
        return $this->purchases->whereNull('deleted_at')->sum('paid_amount');
    }

    public function totalDue(): ?int
    {
        return $this->totalSale() - $this->totalPaid();
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
