<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'supplier_id',
        'name',
        'sku',
        'qty',
        'buying_date',
        'expire_date',
        'buying_price',
        'selling_price'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'buying_date' => 'date:Y-m-d',
        'expire_date' => 'date:Y-m-d',
    ];

    /**
     * Get the supplier that owns the Product
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    // Mutator methods
    protected function buyingPrice(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $value ? $value / 100 : null,
            set: fn ($value) => $value ? $value * 100 : null,
        );
    }

    protected function sellingPrice(): Attribute
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

            // Format the SKU as "SKU000001".
            $product->sku = 'SKU-' . sprintf('%06d', $newSkuNumber);
        });
    }
}
