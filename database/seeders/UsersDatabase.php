<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    { 
        $data = [
        ['name' => 'admin', 'email' => 'admin@thaco.com.vn','msnv' => '9999', 'password' => Hash::make('123456'),'department_id' => '36','position_id' => '10',],
        ['name' => 'Phan Quỳnh Trung', 'email' => 'phanquynhtrung@thaco.com.vn','msnv' => '0707069', 'password' => Hash::make('123456'),'department_id' => '1','position_id' => '1',],
        ['name' => 'Nguyễn Ngân', 'email' => 'nguyenngan@thaco.com.vn','msnv' => '0904029', 'password' => Hash::make('123456'),'department_id' => '1','position_id' => '2',],
        ['name' => 'Tô Tấn Sơn', 'email' => 'totanson@thaco.com.vn','msnv' => '1004345', 'password' => Hash::make('123456'),'department_id' => '1','position_id' => '3',],
        ['name' => 'Lê Văn Doanh', 'email' => 'levandoanh@thaco.com.vn','msnv' => '0909025', 'password' => Hash::make('123456'),'department_id' => '1','position_id' => '4',],
        ['name' => 'Nguyễn Thanh Quốc', 'email' => 'nguyenthanhquoc@thaco.com.vn','msnv' => '1104167', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '5',],
        ['name' => 'Lê Tuấn Vương', 'email' => 'letuanvuong@thaco.com.vn','msnv' => '1506437', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '6',],
        ['name' => 'Nguyễn Minh Tân', 'email' => 'nguyenminhtan@thaco.com.vn','msnv' => '2206945', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Nguyễn Văn Tiến', 'email' => 'nguyenvantien@thaco.com.vn','msnv' => '2206063', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Hoàng Ngọc Thành', 'email' => 'hoangngocthanh@thaco.com.vn','msnv' => '2212040', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Huỳnh Quang Tạo', 'email' => 'huynhquangtao@thaco.com.vn','msnv' => '1705134', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Đỗ Thị Tuyết', 'email' => 'dothituyet@thaco.com.vn','msnv' => '22031351', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Phanh Thanh Hoài', 'email' => 'phanthanhhoai@thaco.com.vn','msnv' => '2212102', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Nguyễn Viết Long', 'email' => 'nguyenvietlong@thaco.com.vn','msnv' => '1606195', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '8',],
        ['name' => 'Huỳnh Kiều Nga', 'email' => 'huynhkieunga@thaco.com.vn','msnv' => '1606196', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '7',],
        ['name' => 'Lê Thiên Bảo', 'email' => 'lethienbao@thaco.com.vn','msnv' => '22032236', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Nguyễn Minh Phúc', 'email' => 'nguyenminhphuc@thaco.com.vn','msnv' => '22031911', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Huỳnh Ngọc Tuấn', 'email' => 'huynhngoctuan@thaco.com.vn','msnv' => '1903097', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Ngô Công Tùng', 'email' => 'ngocongtung@thaco.com.vn','msnv' => '22091241', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Trần Bá Công', 'email' => 'tranbacong@thaco.com.vn','msnv' => '1009031', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Nguyễn Mạnh Hùng', 'email' => 'nguyenmanhhung@thaco.com.vn','msnv' => '2212041', 'password' => Hash::make('123456'),'department_id' => '13','position_id' => '9',],
        ['name' => 'Trương Dũng', 'email' => 'truongdung@thaco.com.vn','msnv' => '1108154', 'password' => Hash::make('123456'),'department_id' => '5','position_id' => '5',],
        ['name' => 'Hoàng Văn Thoại', 'email' => 'hoangvanthoai@thaco.com.vn','msnv' => '1408021', 'password' => Hash::make('123456'),'department_id' => '21','position_id' => '5',],
        ['name' => 'Phạm Công văn', 'email' => 'phamcongvan@thaco.com.vn','msnv' => '0909126', 'password' => Hash::make('123456'),'department_id' => '2','position_id' => '5',],
        ['name' => 'Nguyễn Văn Trung', 'email' => 'nguyenvantrung@thaco.com.vn','msnv' => '1408061', 'password' => Hash::make('123456'),'department_id' => '9','position_id' => '5',],
        ['name' => 'Nguyễn Văn Tiệp', 'email' => 'nguyenvantiep@thaco.com.vn','msnv' => '1310004', 'password' => Hash::make('123456'),'department_id' => '5','position_id' => '5',],
        ['name' => 'Nguyễn Quốc Việt', 'email' => 'nguyenquocviet@thaco.com.vn','msnv' => '1412181', 'password' => Hash::make('123456'),'department_id' => '6','position_id' => '5',],
        ['name' => 'Doãn Minh Luận', 'email' => 'doanminhluan@thaco.com.vn','msnv' => '1508329', 'password' => Hash::make('123456'),'department_id' => '4','position_id' => '5',],
        ['name' => 'Trần Đình Vũ Lộc', 'email' => 'trandinhvuloc@thaco.com.vn','msnv' => '1707095', 'password' => Hash::make('123456'),'department_id' => '22','position_id' => '5',],
        

        //...
    ];
    
        DB::table('users')->insert($data);
    }
}
