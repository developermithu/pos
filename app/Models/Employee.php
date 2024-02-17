<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftCascadeTrait, SoftDeletes;

    protected $softCascade = ['advancePayments', 'attendances', 'overtimes'];

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'joined_at' => 'date',
        'salary_updated_at' => 'date',
    ];

    // ========= Relationships ======== //
    public function advancePayments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'paymentable')->withTrashed();
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function overtimes(): HasMany
    {
        return $this->hasMany(Overtime::class);
    }
    // ========= Relationships ======== //

    // total earning balance
    public function totalBalance(): ?int
    {
        return $this->balance + $this->totalOvertimeEarnings() - $this->totalPaymentsTaken();
    }

    private function totalOvertimeEarnings(): ?int
    {
        return $this->overtimes->whereNull('deleted_at')->sum('total_amount');
    }

    private function totalPaymentsTaken(): ?int
    {
        return $this->advancePayments->whereNull('deleted_at')->sum('amount');
    }

    // last month attendance counts
    public function lastMonthTotalPresent(): ?int
    {
        return $this->lastMonthAttendance(AttendanceStatus::PRESENT);
    }

    public function lastMonthTotalAbsent(): ?int
    {
        return $this->lastMonthAttendance(AttendanceStatus::ABSENT);
    }

    private function lastMonthAttendance(AttendanceStatus $status): ?int
    {
        $firstDayLastMonth = now()->subMonth()->startOfMonth();
        $lastDayLastMonth = now()->subMonth()->endOfMonth();

        return $this->attendances
            ->whereBetween('date', [$firstDayLastMonth, $lastDayLastMonth])
            ->where('status', $status)
            ->count();
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
                    $formattedDiff = 'today';
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
