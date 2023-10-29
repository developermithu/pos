<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaySalary extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    /**
     * Get the employee that owns the PaySalary
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
