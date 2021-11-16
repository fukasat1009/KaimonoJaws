<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = date("Y-m-d H:i:s");

        for ($i = 1; $i < 10; $i++){
            DB::table('products')->insert([
                [
                    'product_name'    => 'テスト商品' . $i,
                    'price'           => 10000,
                    'stock_quantity'  => 5,
                    'sale_status'     => 0,
                    'created_at'      => $today,
                    'updated_at'      => $today,
                ],
            ]);
        }
    }
}
