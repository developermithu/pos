<?php

namespace App\Models;

use App\Enums\PaymentPaidBy;
use App\Enums\PaymentType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'ulid',
        'account_id',
        'amount',
        'reference',
        'details',
        'type',
        'paid_by',
        'paymentable_id',
        'paymentable_type',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'type' => PaymentType::class,
        'paid_by' => PaymentPaidBy::class,
    ];

    public function paymentable(): MorphTo
    {
        return $this->morphTo()->withTrashed();
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'paymentable_id')->withTrashed();
    }

    /**
     * Get the account that owns the Payment
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->ulid = (string) strtolower(Str::ulid());
        });
    }
}
