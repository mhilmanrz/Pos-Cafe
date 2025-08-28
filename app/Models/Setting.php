<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // PERBAIKAN: Menambahkan semua kolom dari tabel 'settings'
    // agar bisa disimpan saat admin menekan tombol "Simpan".
    protected $fillable = [
        'name',
        'address',
        'images',
        'qris_image',
        'instagram',
        'phone',
    ];
}
