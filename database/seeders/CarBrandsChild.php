<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarBrandsChild extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('car_brands_child')->insert([
            [
                'name' => 'Xe Tải thông dụng',
                'car_brands_id'=>4,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Tải chuyên dùng',
                'car_brands_id'=>4,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Thùng Tải',
                'car_brands_id'=>4,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Bus thường',
                'car_brands_id'=>5,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Bus chuyên dùng',
                'car_brands_id'=>5,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe hai bánh',
                'car_brands_id'=>6,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Du Lịch',
                'car_brands_id'=>6,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Tải',
                'car_brands_id'=>6,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xe Bus',
                'car_brands_id'=>6,
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
