<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DepartmentsDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            [
                'name' => 'Ban lãnh đạo giám đốc',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Kế Hoạch',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Kế Toán',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng phân tích Mô Phỏng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Thử Nghiệm',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng quản lý dự án CKD',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Du Lịch',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Royal',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Bus',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Bus CD',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Tải Thông dụng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Tải chuyên dùng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Kiểu Dáng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Nội Ngoại Thất',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Động Lực Học',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Khung Gầm',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Hệ Thống Thủy Lực',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Điện & HTTM',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Phân Tích Cấu Hình',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Nội Địa Hóa',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Quản Trị Dữ Liệu',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Hồ Sơ Sở Hữu',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Quản Lý Chất Lượng (SXM)',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Kho Vật Tư',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Kỹ Thuật Sản Xuất (SXM)',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Sản Xuất Mẫu (SXM)',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'ADMIN',
                'description'=> 'ADMIN',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],


    ]);

    }
}
