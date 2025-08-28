<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'qty',
        'price'
    ];

    /**
     * Mendefinisikan relasi "belongs-to" ke Product.
     * Setiap OrderItem milik satu Product.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}