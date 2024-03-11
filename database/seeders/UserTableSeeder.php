<?php

namespace Database\Seeders;

use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('user_settings')->delete();
        DB::table('users')->delete();
        DB::table('roles')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('roles')->insert([
            ['id' => 1, 'super' => 1, 'name' => 'Super Admin'],
            ['id' => 2, 'super' => 0, 'name' => 'Administrator'],
            ['id' => 3, 'super' => 0, 'name' => 'Moderator'],
        ]);

//        for($i= 0; $i <= 1000000; $i++){
//            $role  = new Role();
//            $role->super = 0;
//            $role->name = 'test';
//            $role->save();
//        }

        DB::table('users')->insert([
            ['id' => 1, 'first_name' => 'Lauris', 'last_name' => 'Priede', 'email' => 'lauris@wdmarket.lv', 'email_verified_at' => Carbon::now(), 'password' => Hash::make('1N2asyLKx15B'), 'administrator' => 1, 'role_id' => 1, 'status' => 1, 'remember_token' => Str::random(20), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'first_name' => 'RB', 'last_name' => 'Motors', 'email' => 'info@rb24.lv', 'email_verified_at' => Carbon::now(), 'password' => Hash::make('SH4y436fAT1X'), 'administrator' => 1, 'role_id' => 1, 'status' => 1,  'remember_token' => Str::random(20), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'first_name' => 'Lauris', 'last_name' => 'Priede Moderator', 'email' => 'barcelona5@inbox.lv', 'email_verified_at' => Carbon::now(), 'password' => Hash::make('580t1gqvWKDQ'), 'administrator' => 1, 'role_id' => 2, 'status' => 0,  'remember_token' => Str::random(20), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'first_name' => 'Lauris', 'last_name' => 'Priede Customer', 'email' => 'lpriede111@gmail.com', 'email_verified_at' => Carbon::now(), 'password' => Hash::make('27w2ZUyP6cg3'), 'administrator' => 0, 'role_id' => null, 'status' => 1,  'remember_token' => Str::random(20), 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        ]);

        DB::table('user_settings')->insert([
            ['id' => 1, 'user_id' => 1, 'theme' => 'light', 'sidebar_collapsed' => 0],
            ['id' => 2, 'user_id' => 2, 'theme' => 'light', 'sidebar_collapsed' => 0],
            ['id' => 3, 'user_id' => 3, 'theme' => 'light', 'sidebar_collapsed' => 0],
        ]);
    }
}
