<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Unit extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'short_name',
        'unit_id',
        'operator',
        'operation_value',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucwords($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function shortName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => strtolower($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    protected function operationValue(): Attribute
    {
        return Attribute::make(
            get: fn (int|float|null $value) => $value ? $value / 1000 : null,
            set: fn (int|float|null $value) => $value ? $value * 1000 : null,
        );
    }

    //========== Relationships ===========//
    public function baseUnit()
    {
        return $this->belongsTo(self::class, 'unit_id');
    }

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function convertQuantity(int|float $quantity, $operator, int|float $operationValue): int|float|null
    {
        if ($operator === '*') {
            return $quantity * $operationValue;
        } elseif ($operator === '/' && $operationValue > 0) {
            return $quantity / $operationValue;
        } else {
            return null;
        }
    }
}
