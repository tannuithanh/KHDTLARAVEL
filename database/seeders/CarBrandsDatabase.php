<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarBrandsDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_brands')->insert([
            [
                'name' => 'Xe Du Lịch (CKD)',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phụ kiện xe Du Lịch',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Royal',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Tải',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Bus',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe năng lượng xanh',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
