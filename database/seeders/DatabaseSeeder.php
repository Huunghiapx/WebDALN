<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // Gọi các seeder khác (nếu có)
        $this->call(SachSeeder::class);

        // Thêm dữ liệu vào bảng users
        DB::table('users')->insert([
            'name' => 'HuuNghia',
            'email' => 'nghiahn.px@gmail.com',
            'password' => Hash::make('password'),
        ]);
    }
}
