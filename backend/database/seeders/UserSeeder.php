<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $today = date("Y-m-d H:i:s");

        for ($i = 2; $i < 10; $i++){
            DB::table('users')->insert([
                [
                    'name'          => 'テストユーザー' . $i,
                    'email'         => 'test@test' . $i,
                    'password'      => Hash::make('password' . $i),
                    'created_at'    => $today,
                    'updated_at'    => $today,
                ],
            ]);
        }

        DB::table('users')->insert([
            [
                'name'          => 'Tester',
                'email'         => 'aaa@aaa',
                'password'      => Hash::make('00000000'),
                'created_at'    => $today,
                'updated_at'    => $today,
            ],
        ]);
    }
}
