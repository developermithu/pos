<?php

namespace App\Models;

use App\Enums\BalanceAdjustmentType;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class BalanceAdjustment extends Model
{
    use HasFactory, SoftCascadeTrait, SoftDeletes;

    protected $softCascade = ['payment'];

    protected $guarded = [];

    protected $casts = [
        'type' => BalanceAdjustmentType::class,
        'date' => 'date',
    ];

    public function payment(): MorphOne
    {
        return $this->morphOne(Payment::class, 'paymentable')->withTrashed();
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ulid = (string) strtolower(Str::ulid());
        });
    }
}
