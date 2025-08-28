<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Mengubah tabel 'orders'
        Schema::table('orders', function (Blueprint $table) {
            // Mengubah kolom 'payment' agar boleh NULL (nullable)
            // Pastikan tipe data string() atau yang sesuai dengan milik Anda
            $table->string('payment')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Kode ini akan dijalankan jika Anda melakukan rollback migrasi
        Schema::table('orders', function (Blueprint $table) {
            // Mengembalikan kolom 'payment' menjadi tidak boleh NULL
            $table->string('payment')->nullable(false)->change();
        });
    }
};
