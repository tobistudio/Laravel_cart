<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class LanguageAndPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('language_pages')->delete();
        DB::table('pages')->delete();
        DB::table('languages')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('languages')->insert([
            ['id' => 1, 'country_id' => 106, 'name' => 'Latvian', 'locale' => 'lv', 'primary' => 1, 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'country_id' => 162, 'name' => 'Русский', 'locale' => 'ru', 'primary' => 0, 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'country_id' => 206, 'name' => 'English', 'locale' => 'en', 'primary' => 0, 'active' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('pages')->insert([
            ['id' => 1, 'parent_id' => null, 'type' => 'home', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'parent_id' => 1, 'type' => 'catalog', 'show_in_pages' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'parent_id' => 1, 'type' => 'manufacturers', 'show_in_pages' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'parent_id' => 1, 'type' => 'vehicles', 'show_in_pages' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'parent_id' => 1, 'type' => 'blog', 'show_in_pages' => 0, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'parent_id' => 1, 'type' => 'search', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'parent_id' => 1, 'type' => 'log_in', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'parent_id' => 1, 'type' => 'sign_up', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'parent_id' => 1, 'type' => 'forgot_password', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'parent_id' => 1, 'type' => 'user_profile', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'parent_id' => 1, 'type' => 'cart', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'parent_id' => 1, 'type' => 'checkout', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'parent_id' => 1, 'type' => 'page_not_found', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'parent_id' => 1, 'type' => 'maintenance_page', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'parent_id' => 1, 'type' => 'page', 'show_in_pages' => 1, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);

        DB::table('language_pages')->insert([
            ['id' => 1, 'page_id' => 1, 'language_id' => 1, 'type' => 'home', 'name' => 'Sākums', 'slug' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'page_id' => 1, 'language_id' => 2, 'type' => 'home', 'name' => 'Главная', 'slug' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'page_id' => 1, 'language_id' => 3, 'type' => 'home', 'name' => 'Home', 'slug' => '', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'page_id' => 2, 'language_id' => 1, 'type' => 'catalog', 'name' => 'Katalogs', 'slug' => 'katalogs', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'page_id' => 2, 'language_id' => 2, 'type' => 'catalog', 'name' => 'Каталог', 'slug' => 'katalog', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'page_id' => 2, 'language_id' => 3, 'type' => 'catalog', 'name' => 'Catalog', 'slug' => 'catalog', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'page_id' => 3, 'language_id' => 1, 'type' => 'manufacturers', 'name' => 'Ražotāji', 'slug' => 'razotaji', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'page_id' => 3, 'language_id' => 2, 'type' => 'manufacturers', 'name' => 'Производители', 'slug' => 'proizvoditeli', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'page_id' => 3, 'language_id' => 3, 'type' => 'manufacturers', 'name' => 'Manufacturers', 'slug' => 'manufacturers', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'page_id' => 4, 'language_id' => 1, 'type' => 'vehicles', 'name' => 'Automašīnas', 'slug' => 'automasinas', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'page_id' => 4, 'language_id' => 2, 'type' => 'vehicles', 'name' => 'Транспорт', 'slug' => 'vehicles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'page_id' => 4, 'language_id' => 3, 'type' => 'vehicles', 'name' => 'Vehicles', 'slug' => 'vehicles', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'page_id' => 5, 'language_id' => 1, 'type' => 'blog', 'name' => 'Blogs', 'slug' => 'blogs', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'page_id' => 5, 'language_id' => 2, 'type' => 'blog', 'name' => 'Блог', 'slug' => 'blog', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'page_id' => 5, 'language_id' => 3, 'type' => 'blog', 'name' => 'Blog', 'slug' => 'blog', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'page_id' => 6, 'language_id' => 1, 'type' => 'search', 'name' => 'Meklēšana', 'slug' => 'meklesana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'page_id' => 6, 'language_id' => 2, 'type' => 'search', 'name' => 'Поиск', 'slug' => 'poisk', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'page_id' => 6, 'language_id' => 3, 'type' => 'search', 'name' => 'Search', 'slug' => 'search', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'page_id' => 7, 'language_id' => 1, 'type' => 'log_in', 'name' => 'Ienākt', 'slug' => 'ienakt', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'page_id' => 7, 'language_id' => 2, 'type' => 'log_in', 'name' => 'Авторизоваться', 'slug' => 'avtorizovatsya', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'page_id' => 7, 'language_id' => 3, 'type' => 'log_in', 'name' => 'Log in', 'slug' => 'log-in', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'page_id' => 8, 'language_id' => 1, 'type' => 'sign_up', 'name' => 'Reģistrēties', 'slug' => 'registreties', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'page_id' => 8, 'language_id' => 2, 'type' => 'sign_up', 'name' => 'Зарегистрироваться', 'slug' => 'zaregistrirovatsya', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'page_id' => 8, 'language_id' => 3, 'type' => 'sign_up', 'name' => 'Sign up', 'slug' => 'sign-up', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'page_id' => 9, 'language_id' => 1, 'type' => 'forgot_password', 'name' => 'Paroles atjaunošana', 'slug' => 'paroles-atjaunosana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'page_id' => 9, 'language_id' => 2, 'type' => 'forgot_password', 'name' => 'Восстановление пароля', 'slug' => 'vosstanovleniye-parolya', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'page_id' => 9, 'language_id' => 3, 'type' => 'forgot_password', 'name' => 'Password recovery', 'slug' => 'pasword-recovery', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'page_id' => 10, 'language_id' => 1, 'type' => 'user_profile', 'name' => 'Profils', 'slug' => 'profils', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'page_id' => 10, 'language_id' => 2, 'type' => 'user_profile', 'name' => 'Профиль', 'slug' => 'profil', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'page_id' => 10, 'language_id' => 3, 'type' => 'user_profile', 'name' => 'Profile', 'slug' => 'profile', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'page_id' => 11, 'language_id' => 1, 'type' => 'cart', 'name' => 'Grozs', 'slug' => 'grozs', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'page_id' => 11, 'language_id' => 2, 'type' => 'cart', 'name' => 'Корзина', 'slug' => 'korzina', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'page_id' => 11, 'language_id' => 3, 'type' => 'cart', 'name' => 'Cart', 'slug' => 'cart', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'page_id' => 12, 'language_id' => 1, 'type' => 'checkout', 'name' => 'Pasūtījuma noformēšana', 'slug' => 'pasutijuma-noformesana', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'page_id' => 12, 'language_id' => 2, 'type' => 'checkout', 'name' => 'Oформления заказа', 'slug' => 'oformleniya-zakaza', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 36, 'page_id' => 12, 'language_id' => 3, 'type' => 'checkout', 'name' => 'Checkout', 'slug' => 'checkout', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'page_id' => 13, 'language_id' => 1, 'type' => 'page_not_found', 'name' => 'Lapa netika atrasta', 'slug' => 'lapa-netika-atrasta', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'page_id' => 13, 'language_id' => 2, 'type' => 'page_not_found', 'name' => 'Страница не найдена', 'slug' => 'stranitsa-ne-naydena', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'page_id' => 13, 'language_id' => 3, 'type' => 'page_not_found', 'name' => 'Page not found', 'slug' => 'page-not-found', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'page_id' => 14, 'language_id' => 1, 'type' => 'maintenance_page', 'name' => 'E-veikalā notiek labojumi', 'slug' => 'eveikala-notiek-labojumi', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'page_id' => 14, 'language_id' => 2, 'type' => 'maintenance_page', 'name' => 'В разработке', 'slug' => 'v-razrabotke', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'page_id' => 14, 'language_id' => 3, 'type' => 'maintenance_page', 'name' => 'Under construction', 'slug' => 'under-construction', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'page_id' => 15, 'language_id' => 1, 'type' => 'contacts', 'name' => 'Kontakti', 'slug' => 'kontakti', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'page_id' => 15, 'language_id' => 2, 'type' => 'contacts', 'name' => 'Контакты', 'slug' => 'kontakty', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'page_id' => 15, 'language_id' => 3, 'type' => 'contacts', 'name' => 'Contacts', 'slug' => 'contacts', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
