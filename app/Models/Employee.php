<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade = ['advancePayments', 'paySalary', 'attendances'];

    protected $guarded = [];

    protected $casts = [
        'joined_at' => 'date',
        'salary_updated_at' => 'date',
    ];

    public function advancePayments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable')->withTrashed();
    }

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

    public function salary_updated_at()
    {
        $diff = $this->salary_updated_at->diff(now());

        $years = $diff->y;
        $months = $diff->m;
        $days = $diff->d;

        // Format the output like 1 Year 5 Months Ago
        if ($years > 0) {
            if ($months > 0) {
                $formattedDiff = "{$years} year" . ($years > 1 ? 's' : '') . " {$months} month" . ($months > 1 ? 's' : '');
            } else {
                $formattedDiff = "{$years} year" . ($years > 1 ? 's' : '');
            }
        } else {
            if ($months >= 1) {
                $formattedDiff = "{$months} month" . ($months > 1 ? 's' : '');
            } else {
                if ($days >= 1) {
                    $formattedDiff = "{$days} days";
                } else {
                    $formattedDiff = "today";
                }
            }
        }

        if ($days >= 1 || $months >= 1 || $years >= 1) {
            return $formattedDiff . ' ago';
        } else {
            return $formattedDiff;
        }
    }
}
