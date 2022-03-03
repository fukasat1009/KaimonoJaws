<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeliveryDestinationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = date("Y-m-d H:i:s");

        DB::table('delivery_destinations')->insert([
            [
                'user_id'           => 9,
                'prefecture'        => '東京都',
                'city'              => '品川区品川町',
                'block'             => '5-5-5',
                'postal_code'       => 1234567,
                'building'          => 'コーポ品川',
                'room_number'       => 300,
                'phone_number'      => 11122223333,
                'created_at'        => $today,
                'updated_at'        => $today,
            ],
        ]);
    }
}
