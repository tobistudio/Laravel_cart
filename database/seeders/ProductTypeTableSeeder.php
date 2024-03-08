<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use App\Models\ProductType;
use App\Models\ProductTypeLanguage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $product_types = [
            [
                'name' => 'Popular',
                'key' => 'popular'
            ]
        ];

        $languages = Language::all();
        foreach($product_types as $product_type_data){
            $product_type = new ProductType();
            $product_type->name = $product_type_data['name'];
            $product_type->key = $product_type_data['key'];
            $product_type->save();

            foreach($languages as $language){
                $product_type_language = new ProductTypeLanguage();

                $product_type_language->type_id = $product_type->id;
                $product_type_language->language_id = $language->id;
                $product_type_language->name = $product_type_data['name'];
                $product_type_language->save();
            }
        }
    }
}
