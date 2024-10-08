<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Sach;

class SachSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Sach::create([
            'TenSach' => 'Laravel cho người mới bắt đầu',
            'namXuatBan' => 2020,
        ]);

        Sach::create([
            'TenSach' => 'Học PHP từ cơ bản đến nâng cao',
            'namXuatBan' => 2021,
        ]);

        Sach::create([
            'TenSach' => 'Hướng dẫn MySQL toàn tập',
            'namXuatBan' => 2019,
        ]);
    }
}
