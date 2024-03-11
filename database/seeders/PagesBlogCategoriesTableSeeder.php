<?php

namespace Database\Seeders;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PagesBlogCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        $blog_categories = [
            'News'
        ];

        $languages = Language::all();
        foreach($blog_categories as $blog_category){
            $page = new Page();
            $page->parent_id = null;
            $page->type = 'blog_category';
            $page->show_in_pages = 1;
            $page->save();

            foreach($languages as $language){
                $language_page = new LanguagePage();

                $language_page->page_id = $page->id;
                $language_page->language_id = $language->id;
                $language_page->type = $page->type;
                $language_page->name = $blog_category;
                $language_page->slug = Str::slug($blog_category, "-");
                $language_page->save();
            }
        }
    }
}
