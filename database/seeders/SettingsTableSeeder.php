<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            ['maintenance' => 1],
        ]);

        Artisan::call( 'down', [
            '--secret' => env('VITE_MAINTENANCE_TOKEN'),
        ]);
    }
}
