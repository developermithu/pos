<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Supplier extends Model
{
    use HasFactory, SoftCascadeTrait, SoftDeletes;

    protected $softCascade = ['deposits'];

    protected $guarded = [];

    public function totalPurchase(): ?int
    {
        return $this->purchases->whereNull('deleted_at')->sum('total');
    }

    public function totalPaid(): ?int
    {
        return $this->purchases->whereNull('deleted_at')->sum('paid_amount');
    }

    public function totalDue(): ?int
    {
        return $this->totalPurchase() - $this->totalPaid() + $this->initial_due;
    }

    public function depositBalance(): ?int
    {
        return $this->deposit - $this->expense;
    }

    // Relationships
    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function deposits(): MorphMany
    {
        return $this->morphMany(Deposit::class, 'depositable')->withTrashed();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ulid = (string) strtolower(Str::ulid());
        });
    }
}
