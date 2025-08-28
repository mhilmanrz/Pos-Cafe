<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tax;

class TaxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tax = new Tax;
        $tax->create(
            [
                'name'      => 'Diskon awal bulan',
                'value'     => '10',
            ]
        );
    }
}
