<?php

namespace Database\Seeders;

use App\Imports\UsersImport;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
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
        Excel::import(new UsersImport, storage_path('app/public/add_user_R&d.xlsx'));
    }
}
