<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PositionsDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('positions')->insert([
            [
                'name' => 'Giám đốc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phó giám đốc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phó giám đốc khối thiết kế',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phó giám đốc xưởng sản xuất mẫu',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Trưởng Phòng',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phó phòng',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Trưởng bộ phận',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Trưởng nhóm',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Chuyên viên',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Chuyên viên (Hành chính đơn vị)',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'ADMIN',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}
