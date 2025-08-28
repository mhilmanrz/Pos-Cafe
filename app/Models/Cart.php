<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'qty', 'is_active'];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
