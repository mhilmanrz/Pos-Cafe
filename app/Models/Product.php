<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // PERBAIKAN: Menambahkan 'stock' ke dalam $fillable
    protected $fillable = [
        'name_product', 
        'category_id', 
        'price',
        'stock', // <-- PASTIKAN INI ADA
        'image', 
        'discount', 
        'description'
    ];

    /**
     * Mendefinisikan relasi ke Category.
     */
    public function category()
    {
        return $this->belongsTo('App\Models\Category');
    }

    /**
     * Mendefinisikan relasi ke OrderItem. 
     * Menambahkan relasi "one-to-many" ke OrderItem.
     * Satu Product bisa ada di banyak OrderItem.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}