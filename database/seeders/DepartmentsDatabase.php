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
                'name' => 'Phòng thiết kế xe Tải cơ sở & xe Tải CD',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Kiểu dáng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Khung gầm',
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
                'name' => 'Phòng thiết kế Điện - Điện tử',
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
                'name' => 'Phòng Kế hoạch',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Bus & Bus CD',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Nội, Ngoại thất',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Thử nghiệm',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng phân tích Mô phỏng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Quản trị dữ liệu',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Xưởng mẫu',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Quản lý chất lượng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Kỹ thuật sản xuất mẫu',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Tài chính - Kế toán',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế xe Du lịch',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Kho vật tư',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng hành chính',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế thùng Tải',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Động lực học',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Kiểm thử phần mềm',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'BLĐ phó giám đốc thiết kế xe Bus',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'BLĐ phó giám đốc thiết kế xe Tải chuyên dụng',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng kế hoạch dự án sản phẩm',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm xe du lịch & xe Kia',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm xe Peugoet',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm Royal',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm xe Tải',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm xe Bus & Mini Bus',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng thiết kế Hệ thống thủy lực',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm xe Mazda',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng Nội địa hóa',
                'description'=> 'abc',
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name' => 'Phòng sản phẩm BMW',
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
