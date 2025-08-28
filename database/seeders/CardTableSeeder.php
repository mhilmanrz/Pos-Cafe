<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Card;

class CardTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name_card' => 'BCA'],
            ['name_card' => 'BRI'],
            ['name_card' => 'MANDIRI'],
            ['name_card' => 'OVO'],
            ['name_card' => 'GOPAY'],
        ];

        Card::insert($data);
    }
}
