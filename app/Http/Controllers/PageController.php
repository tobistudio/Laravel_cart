<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\LanguagePageBlock;
use App\Models\Page;
use App\Models\ProductCategoryCategorie;
use App\Models\ProductData;
use App\Models\ProductLabel;
use App\Models\ProductLabelLabel;
use App\Models\ProductType;
use App\Models\ProductTypeType;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Spatie\ImageOptimizer\OptimizerChainFactory;

class PageController extends Controller
{
    /**
     * @param null $type
     * @return JsonResponse
     */
    public function pages($type = null): JsonResponse
    {
        $pages = [];
        $_pages = (new Page)->where('parent_id', null)
            ->where(function($q) use($type) {
                if($type){
                    $q->where('type', $type);
                } else {
                    $q->whereIn('type', [
                        'home',
                        'catalog',
                        'manufacturers',
                        'vehicles',
                        'blog',
                        'search',
                        'log_in',
                        'sign_up',
                        'forgot_password',
                        'user_profile',
                        'cart',
                        'checkout',
                        'page_not_found',
                        'maintenance_page',
                        'page'
                    ]);
                }
                $q->where('show_in_pages', 1);
            })
            ->with(['pages' => function ($q) {
                $q->with(['pages' => function ($q) {
                    $q->where('show_in_pages', 1);
                    $q->select('id', 'parent_id', 'type');
                }]);
                $q->where('show_in_pages', 1);
                $q->select('id', 'parent_id', 'type');
            }])
            ->get(['id', 'parent_id', 'type']);

        $languages = Language::with('country:id,flag')
            ->get(['id', 'country_id', 'name', 'locale', 'primary', 'active']);

        foreach($_pages as $page){
            $page_languages = [];
            $primary_language_page = null;
            foreach($languages as $language){
                $language_page = (new LanguagePage)->where('page_id', $page->id)->where('language_id', $language->id)->first(['id', 'name', 'type']);

                $page_languages[] = [
                    'id' => $language->id,
                    'flag' => $language->country->flag,
                    'primary' => $language->primary,
                    'page_id' => $language_page ? $language_page->id : null
                ];

                if($language->primary === 1){
                    $primary_language_page = $language_page;
                }
            }


            $sub = [];
            foreach ($page->pages as $sub_page) {
                $sub_page_languages = [];
                $primary_language_sub_page = null;
                foreach($languages as $language){
                    $language_sub_page = (new LanguagePage)->where('page_id', $sub_page->id)->where('language_id', $language->id)->first(['id', 'name', 'type']);

                    $sub_page_languages[] = [
                        'id' => $language->id,
                        'flag' => $language->country->flag,
                        'primary' => $language->primary,
                        'page_id' => $language_sub_page ? $language_sub_page->id : null
                    ];

                    if($language->primary === 1){
                        $primary_language_sub_page = $language_sub_page;
                    }
                }

                $sub_sub = [];
                foreach ($sub_page->pages as $sub_sub_page) {
                    $sub_sub_page_languages = [];
                    $primary_language_sub_sub_page = null;
                    foreach($languages as $language){
                        $language_sub_sub_page = (new LanguagePage)->where('page_id', $sub_sub_page->id)->where('language_id', $language->id)->first(['id', 'name', 'type']);

                        $sub_sub_page_languages[] = [
                            'id' => $language->id,
                            'flag' => $language->country->flag,
                            'primary' => $language->primary,
                            'page_id' => $language_sub_sub_page ? $language_sub_sub_page->id : null
                        ];

                        if($language->primary === 1){
                            $primary_language_sub_sub_page = $language_sub_sub_page;
                        }
                    }

                    $sub_sub[] = [
                        'data' => [
                            'id' => $sub_sub_page->id,
                            'name' => $primary_language_sub_sub_page ? $primary_language_sub_sub_page->name : 'NO PAGE IN PRIMARY LANGUAGE',
                            'type' => $sub_sub_page->type,
                            'languages' => $sub_sub_page_languages
                        ]
                    ];
                }

                $sub[] = [
                    'data' => [
                        'id' => $sub_page->id,
                        'name' => $primary_language_sub_page ? $primary_language_sub_page->name : 'NO PAGE IN PRIMARY LANGUAGE',
                        'type' => $sub_page->type,
                        'languages' => $sub_page_languages
                    ],
                    'children' => $sub_sub,
                ];
            }

            $pages[] = [
                'data' => [
                    'id' => $page->id,
                    'name' => $primary_language_page ? $primary_language_page->name : 'NO PAGE IN PRIMARY LANGUAGE',
                    'type' => $page->type,
                    'languages' => $page_languages
                ],
                'children' => $sub,
            ];
        }

        return response()->json([
            'pages' => $pages,
            'languages' => $languages,
        ]);
    }

    /**
     * @param null $type
     * @param null $page_id
     * @param null $language_id
     * @return JsonResponse
     */
    public function getPage($type = null, $page_id = null, $language_id = null): JsonResponse
    {
        //get active language
        $active_language = $this->getActiveLanguage($language_id);

        //get page
        $page = (new Page)->where('id', $page_id)->first();

        //get languages
        $languages = (new Language)->with('country:id,flag')
            ->get(['id', 'country_id', 'name', 'locale', 'primary', 'active']);

        $response = [
            'languages' => $languages,
            'active_language' => $active_language
        ];

        if($page) {
            //get active page
            $active_page = $this->getActivePage($page->id, $active_language->id);

            //get language pages
            $language_pages = $this->getLanguagePages($languages, $active_language, $page->id);
            $response['language_pages'] = $language_pages;

            //get seo data
            $seo = $this->getSeoData($active_page);
            $response['page']['seo'] = $seo;

            //get page blocks
            $blocks = $this->getBlocks($active_page);
            $response['page']['blocks'] = $blocks;

            //get vehicle brands
            $vehicle_brands = $this->getVehicleBrands($active_language);
            $response['page']['vehicle_brands'] = $vehicle_brands;

            //get product categories
            $product_categories = $this->getProductCategories($active_language);
            $response['page']['product_categories'] = $product_categories;
        } else {
            //get language pages
            $language_pages = $this->getLanguagePages($languages, $active_language);
            $response['language_pages'] = $language_pages;
        }

        if($type !== 'blog_post' && $type !== 'vehicle' && $type !== 'manufacturer' && $type !== 'product'){
            $parent_pages = $this->getParentpages($type, $active_language);
            $response['parent_pages'] = $parent_pages;
            $response['active_parent_page_id'] = $page ? $page->parent_id : null;
        }

        //get general page data
        $general_page_data = $this->getGeneralPageData($active_page ?? null);
        $response['page']['general'] = $general_page_data;

        if($type === 'product'){
            //get product data
            $product_data = $this->getProductData($active_page ?? null);
            $response['page']['product_data'] = $product_data;


            //get product manufacturers
            $product_manufacturers = $this->getProductManufacturers($active_language->id);
            $response['page']['product_manufacturers'] = $product_manufacturers;

            //get product types
            $product_types = $this->getProductTypes();
            $response['page']['product_types'] = $product_types;

            //get product labels
            $product_labels = $this->getProductLabels();
            $response['page']['product_labels'] = $product_labels;
        }

        return response()->json($response);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function savePage(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ], [
            'name.required' => 'name_required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if($request['page_id']){
            $page = (new Page)->where('id', $request['page_id'])->first();
            $page->parent_id = $request['parent_page'] ? $request['parent_page']['id'] : $request['parent_page'];
            $page->save();

            $main_language_page = (new LanguagePage)->where('page_id', $page->id)->where('language_id', $request['language']['id'])->first();
            if(!$main_language_page){
                $main_language_page = new LanguagePage();
                $main_language_page->page_id = $page->id;
                $main_language_page->language_id = $request['language']['id'];
                $main_language_page->type = $page->type;
                $main_language_page->slug = Str::slug($request['name'], "-");
            }
            $main_language_page->name = $request['name'];
            $main_language_page->description = $request['description'];
            $main_language_page->meta_title = $request['meta_title'];
            $main_language_page->meta_description = $request['meta_description'];
            $main_language_page->index = $request['index'];
            $main_language_page->fallow = $request['fallow'];
            $main_language_page->status = $request['status'];

            if (str_starts_with($request['meta_image'], 'data:image')) {
                $seo_image = Image::make($request['meta_image']);

                if($seo_image->width() >= 1200 && $seo_image->height() >= 630){
                    $storage_path = storage_path('app/public/uploads/pages/meta_images/');
                    if (!File::exists($storage_path)) {
                        File::makeDirectory($storage_path, 0755, true, true);
                    }

                    $optimizerChain = OptimizerChainFactory::create();

                    $extension = explode('data:image/', $request['meta_image']);
                    $extension = explode(';base64', $extension[1]);
                    $seo_image_name = str::Slug('page_' . Str::slug($request['name'], "-") . '_' . $page->id . '_' . $request['language']['id'], '-') . '_' . sha1(time());
                    $seo_image->save($storage_path . $seo_image_name . '.' . $extension[0]);

                    $optimized_image = Image::make($request['meta_image']);
                    $optimized_image->fit(1200, 630, function ($constraint) {
                        $constraint->upsize();
                    });
                    $optimized_image->save($storage_path . $seo_image_name . '_optimized.' . $extension[0]);
                    $optimizerChain->optimize($storage_path . $seo_image_name . '_optimized.' . $extension[0]);

                    $main_language_page->meta_image = '/storage/uploads/pages/meta_images/' . $seo_image_name . '_optimized.' . $extension[0];
                } else {
                    return response()->json(['errors' => ['meta_image' => ['image_must_be_minimum_size']]], 422);
                }
            }
        } else {
            $page = new Page();
            $page->parent_id = $request['parent_page'] ? $request['parent_page']['id'] : $request['parent_page'];
            $page->type = $request['type'];
            $page->show_in_pages = 1;
            $page->save();

            $main_language_page = new LanguagePage();
            $main_language_page->page_id = $page->id;
            $main_language_page->language_id = $request['language']['id'];
            $main_language_page->type = $page->type;
            $main_language_page->name = $request['name'];
            $main_language_page->slug = Str::slug($request['name'], "-");
            $main_language_page->status = $request['status'];
        }

        if (str_starts_with($request['featured_image'], 'data:image')) {
            $featured_image = Image::make($request['featured_image']);

            if($request['type'] === 'product' || $request['type'] === 'manufacturer' || ($request['type'] === 'blog_post' && $featured_image->width() >= 287 && $featured_image->height() >= 175)){
                $storage_path = storage_path('app/public/uploads/pages/featured_images/');
                if (!File::exists($storage_path)) {
                    File::makeDirectory($storage_path, 0755, true, true);
                }

                $width = 1200;
                $height = 630;
                if($request['type'] === 'manufacturer'){
                    $width = null;
                    $height = 32;
                } else if($request['type'] === 'blog_post') {
                    $width = 287;
                    $height = 175;
                } else if($request['type'] === 'product') {
                    $width = 253;
                    $height = 253;
                }

                $optimizerChain = OptimizerChainFactory::create();

                $extension = explode('data:image/', $request['featured_image']);
                $extension = explode(';base64', $extension[1]);
                $featured_image_name = str::Slug('page_' . Str::slug($request['name'], "-") . '_' . $page->id . '_' . $request['language']['id'], '-') . '_' . sha1(time());
                $featured_image->save($storage_path . $featured_image_name . '.' . $extension[0]);

                $optimized_image  = Image::make($request['featured_image']);
                $optimized_image->resize($width, $height, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                });
                $optimized_image->save($storage_path . $featured_image_name . '_optimized.' . $extension[0]);
                $optimizerChain->optimize($storage_path . $featured_image_name . '_optimized.' . $extension[0]);

                $main_language_page->featured_image = '/storage/uploads/pages/featured_images/' . $featured_image_name . '_optimized.' . $extension[0];
            } else {
                return response()->json(['errors' => ['featured_image' => ['image_must_be_minimum_size']]], 422);
            }
        }

        $main_language_page->save();

        //save product data
        if ($page->type === 'product') {
            $product_data = (new ProductData)->where('product_id', $main_language_page->id)->first();
            if (!$product_data) {
                $product_data = new ProductData();
                $product_data->product_id = $main_language_page->id;
            }
            $product_data->sku = $request['product_data']['sku'];
            $product_data->price = $request['product_data']['price'];
            $product_data->special_price = $request['product_data']['special_price'];
            $product_data->manufacturer_id = $request['product_data']['product_manufacturer_id'];
            $product_data->save();

            (new ProductCategoryCategorie)->where('product_data_id', $product_data->id)->delete();
            foreach($request['product_data']['product_categories'] as $product_cat){
                $product_category = new ProductCategoryCategorie();
                $product_category->product_data_id = $product_data->id;
                $product_category->product_category_id = $product_cat['value'];
                $product_category->save();
            }

            (new ProductTypeType)->where('product_data_id', $product_data->id)->delete();
            foreach($request['product_data']['product_types'] as $product_t){
                $product_type = new ProductTypeType();
                $product_type->product_data_id = $product_data->id;
                $product_type->product_type_id = $product_t['value'];
                $product_type->language_id = $main_language_page->language_id;
                $product_type->save();
            }

            (new ProductLabelLabel)->where('product_data_id', $product_data->id)->delete();
            foreach($request['product_data']['product_labels'] as $product_l){
                $product_label = new ProductLabelLabel();
                $product_label->product_data_id = $product_data->id;
                $product_label->product_label_id = $product_l['value'];
                $product_label->save();
            }
        }

        $block_ids = [];
        foreach($request['blocks'] as $index => $local_block){
            if(isset($local_block['tmp_id']) && $local_block['tmp_id']){
                $block = new LanguagePageBlock();
                $block->language_page_id = $main_language_page->id;
                $block->key = $local_block['key'];
                $block->name = $local_block['name'];
            } else {
                $block = LanguagePageBlock::where('id', $local_block['id'])->first();
            }

            if($block->key === 'block-hero-search') {
                if (isset($local_block['data']['background_image']) && str_starts_with($local_block['data']['background_image'], 'data:image')) {
                    $background_image = Image::make($local_block['data']['background_image']);

                    if ($background_image->width() >= 1920) {
                        $storage_path = storage_path('app/public/uploads/pages/block_images/' . $local_block['key'] . '/');
                        if (!File::exists($storage_path)) {
                            File::makeDirectory($storage_path, 0755, true, true);
                        }

                        $optimizerChain = OptimizerChainFactory::create();

                        $extension = explode('data:image/', $local_block['data']['background_image']);
                        $extension = explode(';base64', $extension[1]);
                        $background_image_name = str::Slug(Str::slug($local_block['data']['title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());
                        $background_image->save($storage_path . $background_image_name . '.' . $extension[0]);

                        $optimized_image = Image::make($local_block['data']['background_image']);
                        $optimized_image->resize(1920, null, function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        });
                        $optimized_image->save($storage_path . $background_image_name . '_optimized.' . $extension[0]);
                        $optimizerChain->optimize($storage_path . $background_image_name . '_optimized.' . $extension[0]);

                        $local_block['data']['background_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $background_image_name . '_optimized.' . $extension[0];
                    } else {
                        return response()->json(['errors' => ['background_image' => ['image_must_be_minimum_size']]], 422);
                    }
                }
            }

            if($block->key === 'block-icon-text') {
                foreach ($local_block['data']['items'] as $item_index => $item) {
                        if (str_starts_with($item['icon_image'], 'data:image')) {
                            $storage_path = storage_path('app/public/uploads/pages/block_images/' . $local_block['key'] . '/');
                            if (!File::exists($storage_path)) {
                                File::makeDirectory($storage_path, 0755, true, true);
                            }

                            $extension = explode('data:image/', $item['icon_image']);
                            $extension = explode(';base64', $extension[1]);
                            $icon_image_name = str::Slug(Str::slug($item['title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());

                            if($extension[0] === 'svg+xml'){
                                $image_data = substr($item['icon_image'], strpos($item['icon_image'], ',') + 1);
                                $image_data = base64_decode($image_data);
                                Storage::put('/public/uploads/pages/block_images/' . $local_block['key'] . '/' . $icon_image_name . '_optimized.svg', $image_data);

                                $local_block['data']['items'][$item_index]['icon_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $icon_image_name . '_optimized.svg';
                            } else {
                                $icon_image = Image::make($item['icon_image']);

                                if ($icon_image->width() >= 30 && $icon_image->height() >= 30) {

                                    $optimizerChain = OptimizerChainFactory::create();

                                    $extension = explode('data:image/', $item['icon_image']);
                                    $extension = explode(';base64', $extension[1]);
                                    $icon_image_name = str::Slug(Str::slug($item['title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());
                                    $icon_image->save($storage_path . $icon_image_name . '.' . $extension[0]);

                                    $optimized_image = Image::make($item['icon_image']);
                                    $optimized_image->fit(30, 30, function ($constraint) {
                                        $constraint->upsize();
                                    });
                                    $optimized_image->save($storage_path . $icon_image_name . '_optimized.' . $extension[0]);
                                    $optimizerChain->optimize($storage_path . $icon_image_name . '_optimized.' . $extension[0]);

                                    $local_block['data']['items'][$item_index]['icon_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $icon_image_name . '_optimized.' . $extension[0];
                                } else {
                                    return response()->json(['errors' => ['icon_image' => ['image_must_be_minimum_size']]], 422);
                                }
                            }
                        }
                    }
            }

            if($block->key === 'block-popular-categories') {
                foreach ($local_block['data']['items'] as $item_index => $item) {
                    if (str_starts_with($item['product_category_image'], 'data:image')) {
                        $storage_path = storage_path('app/public/uploads/pages/block_images/' . $local_block['key'] . '/');
                        if (!File::exists($storage_path)) {
                            File::makeDirectory($storage_path, 0755, true, true);
                        }

                        $extension = explode('data:image/', $item['product_category_image']);
                        $extension = explode(';base64', $extension[1]);
                        $product_category_image_name = str::Slug(Str::slug($item['title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());

                        if($extension[0] === 'svg+xml'){
                            $image_data = substr($item['product_category_image'], strpos($item['product_category_image'], ',') + 1);
                            $image_data = base64_decode($image_data);
                            Storage::put('/public/uploads/pages/block_images/' . $local_block['key'] . '/' . $product_category_image_name . '_optimized.svg', $image_data);

                            $local_block['data']['items'][$item_index]['product_category_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $product_category_image_name . '_optimized.svg';
                        } else {
                            $product_category_image = Image::make($item['product_category_image']);

                            if ($product_category_image->width() >= 30 && $product_category_image->height() >= 30) {

                                $optimizerChain = OptimizerChainFactory::create();

                                $extension = explode('data:image/', $item['product_category_image']);
                                $extension = explode(';base64', $extension[1]);
                                $product_category_image_name = str::Slug(Str::slug($item['title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());
                                $product_category_image->save($storage_path . $product_category_image_name . '.' . $extension[0]);

                                $optimized_image = Image::make($item['product_category_image']);
                                $optimized_image->fit(185, 138, function ($constraint) {
                                    $constraint->upsize();
                                });
                                $optimized_image->save($storage_path . $product_category_image_name . '_optimized.' . $extension[0]);
                                $optimizerChain->optimize($storage_path . $product_category_image_name . '_optimized.' . $extension[0]);

                                $local_block['data']['items'][$item_index]['product_category_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $product_category_image_name . '_optimized.' . $extension[0];
                            } else {
                                return response()->json(['errors' => ['product_category_image' => ['image_must_be_minimum_size']]], 422);
                            }
                        }
                    }
                }
            }

            if($block->key === 'block-two-banner') {
                if (isset($local_block['data']['first_banner_image']) && str_starts_with($local_block['data']['first_banner_image'], 'data:image')) {
                    $first_banner_image = Image::make($local_block['data']['first_banner_image']);

                    if ($first_banner_image->width() >= 598) {
                        $storage_path = storage_path('app/public/uploads/pages/block_images/' . $local_block['key'] . '/');
                        if (!File::exists($storage_path)) {
                            File::makeDirectory($storage_path, 0755, true, true);
                        }

                        $optimizerChain = OptimizerChainFactory::create();

                        $extension = explode('data:image/', $local_block['data']['first_banner_image']);
                        $extension = explode(';base64', $extension[1]);
                        $first_banner_name = str::Slug(Str::slug($local_block['data']['first_banner_title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());
                        $first_banner_image->save($storage_path . $first_banner_name . '.' . $extension[0]);

                        $optimized_image = Image::make($local_block['data']['first_banner_image']);
                        $optimized_image->resize(1920, null, function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        });
                        $optimized_image->save($storage_path . $first_banner_name . '_optimized.' . $extension[0]);
                        $optimizerChain->optimize($storage_path . $first_banner_name . '_optimized.' . $extension[0]);

                        $local_block['data']['first_banner_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $first_banner_name . '_optimized.' . $extension[0];
                    } else {
                        return response()->json(['errors' => ['first_banner_image' => ['image_must_be_minimum_size']]], 422);
                    }
                }

                if (isset($local_block['data']['second_banner_image']) && str_starts_with($local_block['data']['second_banner_image'], 'data:image')) {
                    $second_banner_image = Image::make($local_block['data']['second_banner_image']);

                    if ($second_banner_image->width() >= 598) {
                        $storage_path = storage_path('app/public/uploads/pages/block_images/' . $local_block['key'] . '/');
                        if (!File::exists($storage_path)) {
                            File::makeDirectory($storage_path, 0755, true, true);
                        }

                        $optimizerChain = OptimizerChainFactory::create();

                        $extension = explode('data:image/', $local_block['data']['second_banner_image']);
                        $extension = explode(';base64', $extension[1]);
                        $second_banner_name = str::Slug(Str::slug($local_block['data']['second_banner_title'], "-") . '_' . $page->id . '_' . $main_language_page->id, '-') . '_' . sha1(time());
                        $second_banner_image->save($storage_path . $second_banner_name . '.' . $extension[0]);

                        $optimized_image = Image::make($local_block['data']['second_banner_image']);
                        $optimized_image->resize(1920, null, function ($constraint) {
                            $constraint->upsize();
                            $constraint->aspectRatio();
                        });
                        $optimized_image->save($storage_path . $second_banner_name . '_optimized.' . $extension[0]);
                        $optimizerChain->optimize($storage_path . $second_banner_name . '_optimized.' . $extension[0]);

                        $local_block['data']['second_banner_image'] = '/storage/uploads/pages/block_images/' . $local_block['key'] . '/' . $second_banner_name . '_optimized.' . $extension[0];
                    } else {
                        return response()->json(['errors' => ['second_banner_image' => ['image_must_be_minimum_size']]], 422);
                    }
                }
            }

            $block->data = $local_block['data'] ?: null;
            $block->order = $index + 1;
            $block->save();
            $block_ids[] = $block->id;
        }

        $blocks = [];
        $_blocks = (new LanguagePageBlock)->where('language_page_id', $main_language_page->id)->orderBy('order')->get(['id', 'key', 'name', 'data']);
        foreach($_blocks as $block){
            if(!in_array($block->id, $block_ids)){
                $block->delete();
            } else {
                $blocks[] = $block;
            }
        }

        foreach($request['language_pages'] as $request_language_page){
            if($request_language_page['page_name']) {
                $find_language_page = (new LanguagePage)->where('page_id', $page->id)->where('language_id', $request_language_page['language_id'])->first();
                if($find_language_page){
                    if($find_language_page->name !== $request_language_page['page_name']){
                        $find_language_page->name = $request_language_page['page_name'];
                    }

                    $find_language_page->status = $request['status'];
                    $find_language_page->save();

                    //save product data
                    if ($page->type === 'product') {
                        $product_data = (new ProductData)->where('product_id', $find_language_page->id)->first();
                        if (!$product_data) {
                            $product_data = new ProductData();
                            $product_data->product_id = $find_language_page->id;
                        }
                        $product_data->sku = $request['product_data']['sku'];
                        $product_data->price = $request['product_data']['price'];
                        $product_data->special_price = $request['product_data']['special_price'];
                        $product_data->manufacturer_id = $request['product_data']['product_manufacturer_id'];
                        $product_data->save();

                        (new ProductCategoryCategorie)->where('product_data_id', $product_data->id)->delete();
                        foreach($request['product_data']['product_categories'] as $product_cat){
                            $product_category = new ProductCategoryCategorie();
                            $product_category->product_data_id = $product_data->id;
                            $product_category->product_category_id = $product_cat['value'];
                            $product_category->save();
                        }

                        (new ProductTypeType)->where('product_data_id', $product_data->id)->delete();
                        foreach($request['product_data']['product_types'] as $product_t){
                            $product_type = new ProductTypeType();
                            $product_type->product_data_id = $product_data->id;
                            $product_type->product_type_id = $product_t['value'];
                            $product_type->language_id = $find_language_page->language_id;
                            $product_type->save();
                        }

                        (new ProductLabelLabel)->where('product_data_id', $product_data->id)->delete();
                        foreach($request['product_data']['product_labels'] as $product_l){
                            $product_label = new ProductLabelLabel();
                            $product_label->product_data_id = $product_data->id;
                            $product_label->product_label_id = $product_l['value'];
                            $product_label->save();
                        }
                    }
                } else {
                    $language_page = new LanguagePage();
                    $language_page->page_id = $page->id;
                    $language_page->language_id = $request_language_page['language_id'];
                    $language_page->type = $page->type;
                    $language_page->name = $request_language_page['page_name'];
                    $language_page->slug = Str::slug($request_language_page['page_name'], "-");
                    $language_page->status = $request['status'];
                    $language_page->save();

                    //save product data
                    if ($page->type === 'product') {
                        $product_data = (new ProductData)->where('product_id', $language_page->id)->first();
                        if (!$product_data) {
                            $product_data = new ProductData();
                            $product_data->product_id = $language_page->id;
                        }
                        $product_data->sku = $request['product_data']['sku'];
                        $product_data->price = $request['product_data']['price'];
                        $product_data->special_price = $request['product_data']['special_price'];
                        $product_data->manufacturer_id = $request['product_data']['product_manufacturer_id'];
                        $product_data->save();

                        (new ProductCategoryCategorie)->where('product_data_id', $product_data->id)->delete();
                        foreach($request['product_data']['product_categories'] as $product_cat){
                            $product_category = new ProductCategoryCategorie();
                            $product_category->product_data_id = $product_data->id;
                            $product_category->product_category_id = $product_cat['value'];
                            $product_category->save();
                        }

                        (new ProductTypeType)->where('product_data_id', $product_data->id)->delete();
                        foreach($request['product_data']['product_types'] as $product_t){
                            $product_type = new ProductTypeType();
                            $product_type->product_data_id = $product_data->id;
                            $product_type->product_type_id = $product_t['value'];
                            $product_type->language_id = $language_page->language_id;
                            $product_type->save();
                        }

                        (new ProductLabelLabel)->where('product_data_id', $product_data->id)->delete();
                        foreach($request['product_data']['product_labels'] as $product_l){
                            $product_label = new ProductLabelLabel();
                            $product_label->product_data_id = $product_data->id;
                            $product_label->product_label_id = $product_l['value'];
                            $product_label->save();
                        }
                    }
                }
            }
        }

        if($page->type === 'blog_category'){
            $redirect_url = 'system/blog/categories/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        } else if ($page->type === 'blog_post') {
            $redirect_url = 'system/blog/posts/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        } else if ($page->type === 'product_category') {
            $redirect_url = 'system/shop/categories/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        } else if ($page->type === 'vehicle') {
            $redirect_url = 'system/shop/vehicles/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        } else if ($page->type === 'manufacturer') {
            $redirect_url = 'system/shop/manufacturers/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        } else if ($page->type === 'product') {
            $redirect_url = 'system/shop/products/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        } else {
            $redirect_url = 'system/pages/'. $page->type .'/' . $page->id . '/' . $main_language_page->language_id;
        }

        return response()->json([
            'message' => !$request['page_id'] ? 'page_created' : 'page_saved',
            'type' => 'system',
            'page' => [
                'general' => [
                    'featured_image' => $main_language_page->featured_image,
                ],
                'seo' => [
                    'image' => $main_language_page->meta_image,
                ],
                'blocks' => $blocks
            ],
            'redirect' => !$request['page_id'] ? $redirect_url : null
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deletePage($id): JsonResponse
    {
        $language_page = (new LanguagePage())->where('id', $id)->first(['id', 'page_id', 'type']);

        if($language_page->type !== 'page'){
            return response()->json([
                'message' => 'cannot_delete_this_page',
                'type' => 'system',
            ], 403);
        }

        $page = (new Page)->where('id', $language_page->page_id)->first();
        $language_pages = (new LanguagePage())->where('page_id', $page->id)->get(['id']);
        $child_page = (new Page)->where('parent_id', $page->id)->first();
        if($language_pages->count() === 1 && $child_page){
            return response()->json([
                'message' => 'cannot_delete_page_with_sub_pages',
                'type' => 'system',
            ], 403);
        }

        $language_page->delete();

        $language_page = (new LanguagePage())->where('page_id', $page->id)->first(['id']);
        if(!$language_page){
            $page->delete();
        }

        return response()->json([
            'message' => 'page_deleted',
            'type' => 'system',
            'redirect' => '/system/pages',
        ]);
    }

    /**
     * @param $page_id
     * @param $active_language_id
     * @return mixed
     */
    protected function getActivePage($page_id, $active_language_id): mixed
    {
        return (new LanguagePage)->where('page_id', $page_id)->where('language_id', $active_language_id)->first([
            'id',
            'name',
            'description',
            'featured_image',
            'meta_title',
            'meta_description',
            'meta_image',
            'index',
            'fallow',
            'status'
        ]);
    }

    /**
     * @param $language_id
     * @return mixed
     */
    protected function getActiveLanguage($language_id): mixed
    {
        if($language_id){
            $active_language = (new Language)->where('id', $language_id)->with('country:id,flag')->first(['id', 'country_id', 'name', 'locale', 'primary', 'active']);
        } else {
            $active_language = (new Language)->where('primary', 1)->with('country:id,flag')->first(['id', 'country_id', 'name', 'locale', 'primary', 'active']);
        }

        return $active_language;
    }

    /**
     * @param $type
     * @param $active_language
     * @return array
     */
    protected function getParentPages($type, $active_language): array
    {
        $parent_pages = [];
        $_parent_pages = (new Page)->where('parent_id', null)
            ->where(function($q) use($type) {
                if($type !== 'page'){
                    $q->where('type', $type);
                } else {
                    $q->whereIn('type', [
                        'home',
                        'catalog',
                        'manufacturers',
                        'vehicles',
                        'blog',
                        'search',
                        'log_in',
                        'sign_up',
                        'forgot_password',
                        'user_profile',
                        'cart',
                        'checkout',
                        'page_not_found',
                        'maintenance_page',
                        'page'
                    ]);
                }
                $q->where('show_in_pages', 1);
            })
            ->with(['pages' => function ($q) {
                $q->where('show_in_pages', 1);
                $q->select('id', 'parent_id', 'type');
            }])
            ->get(['id', 'parent_id', 'type']);

        foreach($_parent_pages as $_parent_page){
            $language_page = (new LanguagePage)->where('page_id', $_parent_page->id)->where('language_id', $active_language->id)->first(['id', 'name', 'type']);

            $language_sub_pages = [];
            foreach ($_parent_page->pages as $sub_page) {
                $language_sub_page = (new LanguagePage)->where('page_id', $sub_page->id)->where('language_id', $active_language->id)->first(['id', 'name', 'type']);

                $language_sub_pages[] = [
                    'id' => $sub_page->id,
                    'name' => $language_sub_page ? $language_sub_page->name : 'NO PAGE IN SELECTED LANGUAGE',
                ];
            }

            $parent_pages[] = [
                'id' => $_parent_page->id,
                'name' => $language_page ? $language_page->name : 'NO PAGE IN SELECTED LANGUAGE',
                'sub' => $language_sub_pages
            ];
        }

        return $parent_pages;
    }

    /**
     * @param $languages
     * @param $active_language
     * @param null $page_id
     * @return array
     */
    protected function getLanguagePages($languages, $active_language, $page_id = null): array
    {
        $language_pages = [];

        foreach($languages as $language){
            if($page_id){
                $language_page = (new LanguagePage)->where('page_id', $page_id)->where('language_id', $language->id)->first(['id', 'name']);

                $language_pages[] = [
                    'id' => $language_page->id,
                    'page_name' => $language_page ? $language_page->name : '',
                    'language_id' => $language->id,
                    'flag' => $language->country->flag,
                    'show' => !($language->id === $active_language->id)
                ];
            } else {
                $language_pages[] = [
                    'id' => null,
                    'page_name' => '',
                    'language_id' => $language->id,
                    'flag' => $language->country->flag,
                    'show' => !($language->id === $active_language->id)
                ];
            }
        }

        return $language_pages;
    }

    /**
     * @param $active_language
     * @return array
     */
    protected function getProductCategories($active_language): array
    {
        $product_categories = [];

        $_product_categories = (new Page)->where('parent_id', null)->where('type', 'product_category')
            ->where('show_in_pages', 1)
            ->with(['pages' => function ($q) {
                $q->where('show_in_pages', 1);
                $q->select('id', 'parent_id', 'type');
                $q->with(['pages' => function ($q) {
                    $q->where('show_in_pages', 1);
                    $q->select('id', 'parent_id', 'type');
                }]);
            }])
            ->get(['id', 'parent_id', 'type']);
        foreach($_product_categories as $product_category){
            $language_page = (new LanguagePage)->where('page_id', $product_category->id)->where('language_id', $active_language->id)->first(['id', 'name', 'type']);

            $language_sub_pages = [];
            foreach ($product_category->pages as $sub_page) {
                $language_sub_page = (new LanguagePage)->where('page_id', $sub_page->id)->where('language_id', $active_language->id)->first(['id', 'name', 'type']);

                $language_sub_sub_pages = [];
                foreach ($sub_page->pages as $sub_sub_page) {
                    $language_sub_sub_page = (new LanguagePage)->where('page_id', $sub_sub_page->id)->where('language_id', $active_language->id)->first(['id', 'name', 'type']);

                    $language_sub_sub_pages[] = [
                        'value' => $sub_sub_page->id,
                        'name' => $language_sub_sub_page ? $language_sub_sub_page->name : 'NO RECORD IN SELECTED LANGUAGE',
                    ];
                }

                $language_sub_pages[] = [
                    'value' => $sub_page->id,
                    'name' => $language_sub_page ? $language_sub_page->name : 'NO RECORD IN SELECTED LANGUAGE',
                    'sub' => $language_sub_sub_pages
                ];
            }

            $product_categories[] = [
                'value' => $product_category->id,
                'name' => $language_page ? $language_page->name : 'NO RECORD IN SELECTED LANGUAGE',
                'sub' => $language_sub_pages
            ];
        }

        return $product_categories;
    }

    /**
     * @param $active_page
     * @return array
     */
    protected function getGeneralPageData($active_page): array
    {
        return [
            'id' => $active_page ? $active_page->id : null,
            'name' => $active_page ? $active_page->name : '',
            'description' => $active_page ? $active_page->description : '',
            'featured_image' => $active_page ? $active_page->featured_image : '',
            'status' => $active_page ? $active_page->status : 0
        ];
    }

    /**
     * @param $active_page
     * @return array
     */
    protected function getSeoData($active_page): array
    {
        return [
            'title' => $active_page->meta_title,
            'description' => $active_page->meta_description,
            'image' => $active_page->meta_image,
            'index' => $active_page->index,
            'fallow' => $active_page->fallow,
        ];
    }

    /**
     * @param $active_page
     * @return mixed
     */
    protected function getBlocks($active_page): mixed
    {
        return (new LanguagePageBlock)->where('language_page_id', $active_page->id)->orderBy('order')->get(['id', 'key', 'name', 'data']);
    }

    /**
     * @param $active_language
     * @return mixed
     */
    protected function getVehicleBrands($active_language): mixed
    {
        return (new LanguagePage)->where('language_id', $active_language->id)->where('type', 'vehicle')->orderBy('name')->get(['id as value', 'name']);
    }

    /**
     * @param $active_page
     * @return array
     */
    protected function getProductData($active_page): array
    {
        $product_data = (new ProductData)->where('product_id',$active_page ? $active_page->id : null)
            ->first([
                'id',
                'sku',
                'price',
                'special_price',
                'manufacturer_id'
            ]);

        $product_categories = [];
        if($product_data) {
            $_product_categories = (new ProductCategoryCategorie)->where('product_data_id', $product_data->id)->get(['product_category_id']);
            foreach ($_product_categories as $_product_category) {
                $product_categories[] = (new LanguagePage)->where('page_id', $_product_category->product_category_id)->first(['page_id as value', 'name']);
            }
        }

        $product_types = [];
        if($product_data) {
            $_product_types = (new ProductTypeType)->where('product_data_id', $product_data->id)->get(['product_type_id']);
            foreach ($_product_types as $_product_type) {
                $product_types[] = (new ProductType)->where('id', $_product_type->product_type_id)->first(['id as value', 'name']);
            }
        }

        $product_labels = [];
        if($product_data) {
            $_product_labels = (new ProductLabelLabel)->where('product_data_id', $product_data->id)->get(['product_label_id']);
            foreach ($_product_labels as $_product_label) {
                $product_labels[] = (new ProductLabel)->where('id', $_product_label->product_label_id)->first(['id as value', 'name', 'key']);
            }
        }

        return [
            'id' => $product_data ? $product_data->id : null,
            'sku' => $product_data ? $product_data->sku : null,
            'price' => $product_data ? $product_data->price : null,
            'special_price' => $product_data ? $product_data->special_price : null,
            'product_categories' => $product_categories,
            'product_manufacturer_id' => $product_data ? $product_data->manufacturer_id : null,
            'product_types' => $product_types,
            'product_labels' => $product_labels
        ];
    }

    /**
     * @param $active_language_id
     * @return mixed
     */
    protected function getProductManufacturers($active_language_id): mixed
    {
        return (new LanguagePage)->where('language_id', $active_language_id)->where('type', 'manufacturer')->orderBy('name')->get(['page_id as value', 'name']);
    }

    /**
     * @return Collection
     */
    protected function getProductTypes(): Collection
    {
        return (new ProductType)->all(['id as value', 'name']);
    }

    /**
     * @return Collection
     */
    protected function getProductLabels(): Collection
    {
        return (new ProductLabel)->all(['id as value', 'name', 'key']);
    }
}
