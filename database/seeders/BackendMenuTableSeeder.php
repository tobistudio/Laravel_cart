<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class BackendMenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('backend_role_permissions')->delete();
        DB::table('backend_menu_item_permissions')->delete();
        DB::table('backend_menu_items')->delete();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('backend_menu_items')->insert([
            ['id' => 1, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'home', 'name' => 'dashboard', 'link' => '/system/dashboard', 'order' => 1, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'settings', 'name' => 'organization', 'link' => '/system/organization', 'order' => 2, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'type' => 'sidebar', 'parent_id' => 2, 'icon' => 'dot', 'name' => 'organization_users', 'link' => '/system/organization/users', 'order' => 1, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'type' => 'sidebar', 'parent_id' => 2, 'icon' => 'dot', 'name' => 'organization_roles', 'link' => '/system/organization/roles', 'order' => 2, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'content', 'name' => 'pages', 'link' => '/system/pages', 'order' => 3, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'menu', 'name' => 'menu', 'link' => '/system/menu', 'order' => 4, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'book', 'name' => 'blog', 'link' => '/system/blog', 'order' => 5, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'type' => 'sidebar', 'parent_id' => 7, 'icon' => 'dot', 'name' => 'blog_categories', 'link' => '/system/blog/categories', 'order' => 1, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'type' => 'sidebar', 'parent_id' => 7, 'icon' => 'dot', 'name' => 'blog_posts', 'link' => '/system/blog/posts', 'order' => 2, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'store', 'name' => 'shop', 'link' => '/system/shop', 'order' => 6, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_customers', 'link' => '/system/shop/customers', 'order' => 1, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_categories', 'link' => '/system/shop/categories', 'order' => 2, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_vehicles', 'link' => '/system/shop/vehicles', 'order' => 3, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_manufacturers', 'link' => '/system/shop/manufacturers', 'order' => 4, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_products', 'link' => '/system/shop/products', 'order' => 5, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_shipping', 'link' => '/system/shop/shipping', 'order' => 6, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_discount_codes', 'link' => '/system/shop/discount-codes', 'order' => 7, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_orders', 'link' => '/system/shop/orders', 'order' => 8, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'type' => 'sidebar', 'parent_id' => 10, 'icon' => 'dot', 'name' => 'shop_newsletter', 'link' => '/system/shop/newsletter', 'order' => 9, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'type' => 'sidebar', 'parent_id' => null, 'icon' => 'cog', 'name' => 'settings', 'link' => '/system/settings', 'order' => 7, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'type' => 'sidebar', 'parent_id' => 20, 'icon' => 'dot', 'name' => 'settings_general', 'link' => '/system/settings', 'order' => 1, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'type' => 'sidebar', 'parent_id' => 21, 'icon' => 'dot', 'name' => 'settings_languages', 'link' => '/system/settings/languages', 'order' => 2, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'type' => 'sidebar', 'parent_id' => 22, 'icon' => 'dot', 'name' => 'settings_translations', 'link' => '/system/settings/translations', 'order' => 3, 'disabled' => false, 'allow_permission' => true, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);


        DB::table('backend_menu_item_permissions')->insert([
            ['id' => 1, 'menu_item_id' => 1, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'menu_item_id' => 1, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 3, 'menu_item_id' => 1, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 4, 'menu_item_id' => 1, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 5, 'menu_item_id' => 2, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 6, 'menu_item_id' => 2, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 7, 'menu_item_id' => 2, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 8, 'menu_item_id' => 2, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 9, 'menu_item_id' => 3, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 10, 'menu_item_id' => 3, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 11, 'menu_item_id' => 3, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 12, 'menu_item_id' => 3, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 13, 'menu_item_id' => 4, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 14, 'menu_item_id' => 4, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 15, 'menu_item_id' => 4, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 16, 'menu_item_id' => 4, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 17, 'menu_item_id' => 5, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 18, 'menu_item_id' => 5, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 19, 'menu_item_id' => 5, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 20, 'menu_item_id' => 5, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 21, 'menu_item_id' => 6, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 22, 'menu_item_id' => 6, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 23, 'menu_item_id' => 6, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 24, 'menu_item_id' => 6, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 25, 'menu_item_id' => 7, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 26, 'menu_item_id' => 7, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 27, 'menu_item_id' => 7, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 28, 'menu_item_id' => 7, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 29, 'menu_item_id' => 8, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 30, 'menu_item_id' => 8, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 31, 'menu_item_id' => 8, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 32, 'menu_item_id' => 8, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 33, 'menu_item_id' => 9, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 34, 'menu_item_id' => 9, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 35, 'menu_item_id' => 9, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 36, 'menu_item_id' => 9, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 37, 'menu_item_id' => 10, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 38, 'menu_item_id' => 10, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 39, 'menu_item_id' => 10, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 40, 'menu_item_id' => 10, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 41, 'menu_item_id' => 11, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 42, 'menu_item_id' => 11, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 43, 'menu_item_id' => 11, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 44, 'menu_item_id' => 11, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 45, 'menu_item_id' => 12, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 46, 'menu_item_id' => 12, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 47, 'menu_item_id' => 12, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 48, 'menu_item_id' => 12, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 49, 'menu_item_id' => 13, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 50, 'menu_item_id' => 13, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 51, 'menu_item_id' => 13, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 52, 'menu_item_id' => 13, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 53, 'menu_item_id' => 14, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 54, 'menu_item_id' => 14, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 55, 'menu_item_id' => 14, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 56, 'menu_item_id' => 14, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 57, 'menu_item_id' => 15, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 58, 'menu_item_id' => 15, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 59, 'menu_item_id' => 15, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 60, 'menu_item_id' => 15, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 61, 'menu_item_id' => 16, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 62, 'menu_item_id' => 16, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 63, 'menu_item_id' => 16, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 64, 'menu_item_id' => 16, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 65, 'menu_item_id' => 17, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 66, 'menu_item_id' => 17, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 67, 'menu_item_id' => 17, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 68, 'menu_item_id' => 17, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 69, 'menu_item_id' => 18, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 70, 'menu_item_id' => 18, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 71, 'menu_item_id' => 18, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 72, 'menu_item_id' => 18, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 73, 'menu_item_id' => 19, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 74, 'menu_item_id' => 19, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 75, 'menu_item_id' => 19, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 76, 'menu_item_id' => 19, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 77, 'menu_item_id' => 20, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 78, 'menu_item_id' => 20, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 79, 'menu_item_id' => 20, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 80, 'menu_item_id' => 20, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 81, 'menu_item_id' => 21, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 82, 'menu_item_id' => 21, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 83, 'menu_item_id' => 21, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 84, 'menu_item_id' => 21, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 85, 'menu_item_id' => 22, 'permission' => 'view', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 86, 'menu_item_id' => 22, 'permission' => 'create', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 87, 'menu_item_id' => 22, 'permission' => 'edit', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 88, 'menu_item_id' => 22, 'permission' => 'delete', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }
}
