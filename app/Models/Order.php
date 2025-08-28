<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // PERBAIKAN: Menghapus cart_id dan card_id yang tidak lagi digunakan di tabel ini.
    // Menambahkan status.
    protected $fillable = [
        'invoice', 
        'user_id', // Mengganti cashier_id menjadi user_id untuk konsistensi
        'table_id',
        'payment', 
        'total',
        'status'
    ];

    /**
     * PERBAIKAN: Mendefinisikan relasi "one-to-many" ke OrderItem.
     * Sebuah Order memiliki banyak Item.
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Mendefinisikan relasi "belongs-to" ke User (kasir).
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

 public function table()
    {
        return $this->belongsTo(Table::class);
    }
}