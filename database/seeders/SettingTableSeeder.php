<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $setting = new Setting;
        $setting->create(
            [
                'name'      => 'CAFFEE_IN',
                'address'   => 'JL IN Aja Dulu',
                'images'    => 'logo.png',
                'instagram' => 'mhilmanrz',
                'phone'     => '081296723674',
            ]
        );
    }
}
