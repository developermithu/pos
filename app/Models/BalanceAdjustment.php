<?php

namespace App\Models;

use App\Enums\BalanceAdjustmentType;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;

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

    // public function account(): HasOneThrough
    // {
    //     return $this->hasOneThrough(
    //         Account::class,
    //         Payment::class,
    //         'paymentable_type', // Foreign key column in Payment table for polymorphic relation
    //         'id', // Foreign key column in Account table
    //         'id', // Local key column in BalanceAdjustment table
    //         'paymentable_id' // Local key column in Payment table for polymorphic relation
    //     );
    // }
}
