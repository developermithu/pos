<?php

namespace App\Models;

use Askedio\SoftCascade\Traits\SoftCascadeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use HasFactory, SoftDeletes, SoftCascadeTrait;

    protected $softCascade =  ['expenses'];

    protected $guarded = [];

    /**
     * Get all of the expenses for the ExpenseCategory
     */
    public function expenses(): HasMany
    {
        return $this->hasMany(Expense::class);
    }
}
