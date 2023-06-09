<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // DB::table('departments')->truncate();
        // DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call([
            TrademarkDatabase::class,
            DepartmentsDatabase::class,
            PositionsDatabase::class,
            UsersDatabase::class,
            CarBrandsDatabase::class,
            CarBrandsChild::class,
        ]);
    }
}
