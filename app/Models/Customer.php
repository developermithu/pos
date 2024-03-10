<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Customer extends Model
{
    use HasFactory, SoftCascadeTrait, SoftDeletes;

    protected $softCascade = ['deposits'];

    protected $fillable = [
        'ulid',
        'name',
        'company_name',
        'address',
        'phone_number',
        'deposit',
        'expense',
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

    public function depositBalance(): ?int
    {
        return $this->deposit - $this->expense;
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
