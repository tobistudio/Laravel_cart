<?php

namespace App\Http\Controllers;

use App\Jobs\SendContactFormMail;
use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Message;
use App\Models\Page;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use JetBrains\PhpStorm\ArrayShape;

class CatalogNavigationController extends Controller
{
    /**
     * @param $locale
     * @return JsonResponse
     */
    public function getProductCategories($locale): JsonResponse
    {
        $product_categories = [];
        $_product_categories = (new Page)->where('parent_id', null)->where(function ($q) {
            $q->where('type', 'product_category');
            $q->where('show_in_pages', 1);
        })->with(['pages' => function ($q) {
            $q->with(['pages' => function ($q) {
                $q->with(['pages' => function ($q) {
                    $q->where('show_in_pages', 1);
                    $q->select('id', 'parent_id', 'type');
                }]);

                $q->where('show_in_pages', 1);
                $q->select('id', 'parent_id', 'type');
            }]);

            $q->where('show_in_pages', 1);
            $q->select('id', 'parent_id', 'type');
        }])->get(['id', 'parent_id', 'type']);

        $active_language = (new Language)->where('locale', $locale)->first(['id', 'locale', 'primary']);

        foreach ($_product_categories as $_product_category) {
            $language_category = (new LanguagePage)->where('page_id', $_product_category->id)->where('language_id', $active_language->id)->first(['id', 'name']);

            if ($language_category) {
                $sub_categories = [];
                foreach ($_product_category->pages as $sub_category) {
                    $language_sub_category = (new LanguagePage)->where('page_id', $sub_category->id)->where('language_id', $active_language->id)->first(['id', 'name', 'slug', 'featured_image']);

                    $sub_sub_categories = [];
                    foreach ($sub_category->pages as $sub_sub_category) {
                        $language_sub_sub_category = (new LanguagePage)->where('page_id', $sub_sub_category->id)->where('language_id', $active_language->id)->first(['id', 'name', 'slug']);

                        $sub_sub_sub_categories = [];
                        foreach ($sub_sub_category->pages as $sub_sub_sub_category) {
                            $language_sub_sub_sub_category = (new LanguagePage)->where('page_id', $sub_sub_sub_category->id)->where('language_id', $active_language->id)->first(['id', 'name', 'slug']);

                            $sub_sub_sub_categories[] = [
                                'id' => $sub_sub_sub_category->id,
                                'name' => $language_sub_sub_sub_category->name,
                                'slug' => (!$active_language->primary ? '/' . $active_language->locale : '') . '/' . $language_sub_sub_sub_category->slug,
                            ];
                        }

                        $sub_sub_categories[] = [
                            'id' => $sub_sub_category->id,
                            'name' => $language_sub_sub_category->name,
                            'slug' => (!$active_language->primary ? '/' . $active_language->locale : '') . '/' . $language_sub_sub_category->slug,
                            'children' => $sub_sub_sub_categories
                        ];
                    }

                    $sub_categories[] = [
                        'id' => $sub_category->id,
                        'name' => $language_sub_category->name,
                        'image' => $language_sub_category->featured_image,
                        'slug' => (!$active_language->primary ? '/' . $active_language->locale : '') . '/' . $language_sub_category->slug,
                        'children' => $sub_sub_categories
                    ];
                }

                $product_categories[] = [
                    'id' => $_product_category->id,
                    'name' => $language_category->name,
                    'children' => $sub_categories
                ];
            }
        }

        return response()->json($product_categories);
    }
}
