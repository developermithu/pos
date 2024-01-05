<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['advanceSalary', 'paySalary', 'attendances'];

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
        return $this->hasOne(PaySalary::class);
    }

    /**
     * Get all of the attendances for the Employee
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }
}
