<?php

namespace App\Models;

use App\Enums\AttendanceStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = ['employee_id', 'date', 'status'];

    protected $casts = [
        'status' => AttendanceStatus::class,
        'date' => 'date: Y-m-d'
    ];

    /**
     * Get the employee that owns the Attendance
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
