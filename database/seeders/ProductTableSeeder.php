<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name_product'=>'Ayam goreng'  ,'category_id'=> 1 ,'price'=> 13000, 'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Nasi goreng'  ,'category_id'=> 1 ,'price'=> 17000, 'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Mie goreng'   ,'category_id'=> 1 ,'price'=> 15000, 'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Ayam bakar'   ,'category_id'=> 1 ,'price'=> 15000, 'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Ikan bakar'   ,'category_id'=> 1 ,'price'=> 19000, 'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Ayam BBQ'     ,'category_id'=> 1 ,'price'=> 17000, 'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Es teh manis' ,'category_id'=> 1 ,'price'=> 7000,  'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
            ['name_product'=>'Jus jeruk'    ,'category_id'=> 1 ,'price'=> 9000,  'discount' => 0, 'description' => 'sample', 'image' => 'ayam.png'],
        ];

        Product::insert($data);
    }
}
