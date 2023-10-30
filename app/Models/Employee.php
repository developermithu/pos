<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'joined_at' => 'date: Y-m-d',
    ];

    /**
     * Get the advance salary that owns the Employee
     */
    public function advanceSalary(): HasOne
    {
        return $this->hasOne(AdvancedSalary::class);
    }

    /**
     * Get the pay salary that owns the Employee
     */
    public function paySalary(): HasOne
    {
        return $this->hasOne(paySalary::class);
    }
}
