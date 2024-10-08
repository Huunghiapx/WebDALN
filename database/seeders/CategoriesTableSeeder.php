<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Quần'],
            ['name' => 'Áo'],
            // Thêm nhiều loại sản phẩm khác nếu cần
        ]);
    }
}
