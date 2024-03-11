<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('menus')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('menus')->insert([
            ['id' => 1, 'name' => 'Augšējā navigācija', 'key' => 'top_menu', 'language_id' => 1, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'Верхнее меню', 'key' => 'top_menu', 'language_id' => 2, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'name' => 'Top menu', 'key' => 'top_menu', 'language_id' => 3, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'name' => 'Galvenā navigācija', 'key' => 'main_menu', 'language_id' => 1, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'name' => 'Главное меню', 'key' => 'main_menu', 'language_id' => 2, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'name' => 'Main menu', 'key' => 'main_menu', 'language_id' => 3, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'name' => 'Kājenes navigācija', 'key' => 'footer_menu', 'language_id' => 1, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'name' => 'Меню нижнего колонтитула', 'key' => 'footer_menu', 'language_id' => 2, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'name' => 'Footer menu', 'key' => 'footer_menu', 'language_id' => 3, 'status' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
