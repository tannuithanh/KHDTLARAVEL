<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TrademarkDatabase extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trademark')->insert([
            [
                'name' => 'Khối Thiết Kế',
            ],
            [
                'name' => 'Xưởng mẫu',
            ],
        ]);
    }
}
