<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['employee_id', 'date', 'status'];

    protected $casts = [
        'status' => AttendanceStatus::class,
        'date' => 'date',
    ];

    /**
     * Get the employee that owns the Attendance
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
