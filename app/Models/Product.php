<?php

namespace App\Models;

use App\Enums\ProductType;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'type' => ProductType::class,
    ];

    // Methods
    public function created_at(): string
    {
        return $this->created_at->format('d M, Y');
    }

    // Mutator methods
    protected function price(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value ? $value * 100 : null,
        );
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Generating product sku number based on product id
        static::creating(function ($product) {
            $lastProduct = static::withTrashed()->latest('id')->first(); // Get the latest product by ID with trashed.
            $newSkuNumber = $lastProduct ? $lastProduct->id + 1 : 1; // Generate a new SKU number.

            // Format the SKU as "001".
            $product->sku = sprintf('%03d', $newSkuNumber);
        });
    }

    //========== Relationships ===========//
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }
}
