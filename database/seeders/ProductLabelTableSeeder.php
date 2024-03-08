<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use App\Models\ProductLabel;
use App\Models\ProductLabelLanguage;
use App\Models\ProductType;
use App\Models\ProductTypeLanguage;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductLabelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $product_labels = [
            [
                'name' => 'Premium',
                'key' => 'bg-red',
            ],
            [
                'name' => 'Average',
                'key' => 'bg-orange',
            ]
        ];

        $languages = Language::all();
        foreach($product_labels as $product_label_data){
            $product_label = new ProductLabel();
            $product_label->name = $product_label_data['name'];
            $product_label->key = $product_label_data['key'];
            $product_label->save();

            foreach($languages as $language){
                $product_label_language = new ProductLabelLanguage();

                $product_label_language->label_id = $product_label->id;
                $product_label_language->language_id = $language->id;
                $product_label_language->name = $product_label_data['name'];
                $product_label_language->save();
            }
        }
    }
}
