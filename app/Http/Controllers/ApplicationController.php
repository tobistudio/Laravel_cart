<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\LanguagePageBlock;
use App\Models\LanguagePageSidebarBlock;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\Page;
use App\Models\PasswordReset;
use App\Models\ProductCategoryCategorie;
use App\Models\ProductCategoryData;
use App\Models\ProductData;
use App\Models\ProductLabel;
use App\Models\ProductLabelLabel;
use App\Models\ProductLabelLanguage;
use App\Models\ProductType;
use App\Models\ProductTypeLanguage;
use App\Models\ProductTypeType;
use App\Models\StoreInformation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ApplicationController extends Controller
{
    /**
     * @param Request $request
     * @param $params
     * @return View|RedirectResponse
     */
    public function index(Request $request, $params = null): View|RedirectResponse
    {
        $route = explode('/', $params);
        if ($route[0] === 'system') {
            return view('backend');
        } else {
            $active_language = (new Language)->where('locale', $route[0])->with('country')->first();
            if (!$active_language) {
                $active_language = (new Language)->where('primary', Language::PRIMARY)->first();
                $locale = '';
                $url = $params;
            } else {
                $locale = '/' . $active_language->locale;
                $url = implode('/', array_slice($route, 1, count($route) - 1, true));
            }

            $page = (new LanguagePage)->where('language_id', $active_language->id)->where('slug', $url ?: '')->first();

            $auth = Auth::guard('api')->check();

            $meta_data = [
                'title' => (isset($page) && $page ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'description' => (isset($page) ? ($page->meta_description ?: ($page->description ?: $page->name) . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:type' => 'website',
                'og:title' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:description' => (isset($page) ? ($page->meta_description ?: ($page->description ?: $page->name) . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:url' => env('APP_URL') . '/' . $params,
                'og:image' => env('APP_URL') . (isset($page) && $page->meta_image ? $page->meta_image . '?' . time() : '/images/rb24-logo-share.jpg?' . time()),
                'og:image:alt' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:image:type' => 'image/png',
                'og:image:width' => '1200',
                'og:image:height' => '630',
                'twitter:card' => 'summary',
                'twitter:title' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'twitter:description' => (isset($page) ? ($page->meta_description ?: ($page->description ?: $page->name) . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'twitter:image' => env('APP_URL') . (isset($page) && $page->meta_image ? $page->meta_image . '?' . time() : '/images/rb24-logo-share.jpg?' . time())
            ];

            $extra = ['email_verified' => false, 'locale' => $active_language->locale];

            if($page && $page->type === 'checkout'){
                $store_information_primary_phone = (new StoreInformation)->where('type', 'store_info')->where('key', 'phone_primary')->first();
                $store_information['phone_primary'] = $store_information_primary_phone->value;

                $cart_page = (new LanguagePage)->where('type', 'cart')->where('language_id', $active_language->id)->first();
                $checkout_footer_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'checkout_footer_menu')->first();
                $checkout_footer_menu_item = MenuItem::where('menu_id', $checkout_footer_menu->id)->get();
                $checkout_footer_menu = $this->getMenuTree($checkout_footer_menu_item, $locale, null);
                $data = [
                    'header_navigation' => [
                        [
                            'title' => $cart_page->name,
                            'slug' => $locale . '/' . $cart_page->slug,
                            'active' => false,
                        ],
                        [
                            'title' => $page->name,
                            'slug' => $locale . '/' . $page->slug,
                            'active' => true,
                        ]
                    ],
                    'breadcrumbs' => $this->getBreadcrumbs($page, $active_language, $locale),
                    'title' => $page->name,
                    'checkout_footer_menu' => $checkout_footer_menu
                ];

                return view('frontend.checkout', compact(
                    'meta_data',
                    'locale',
                    'data',
                    'auth',
                    'store_information',
                    'extra',
                ));
            }

            $languages = ['active' => ['name' => $active_language->name, 'flag' => $active_language->country->flag,], 'data' => []];
            $_languages = (new Language)->where('active', Language::ACTIVE)->with('country:id,flag')->get(['id', 'name', 'locale', 'primary', 'country_id']);
            foreach ($_languages as $_language) {
                $slug = null;

                if ($active_language->id !== $_language->id) {
                    if($page) {
                        $language_page = (new LanguagePage)->where('language_id', $_language->id)->where('page_id', $page->page_id)->first();

                        if ($_language->primary) {
                            $slug = '/' . (isset($language_page) ? $language_page->slug : '');
                        } else {
                            $slug = '/' . $_language->locale . ($language_page->slug ? '/' . $language_page->slug : '');
                        }
                    } else {
                        if ($_language->primary) {
                            $slug = '/';
                        } else {
                            $slug = '/' . $_language->locale;
                        }
                    }
                }

                $languages['data'][] = ['name' => $_language->name, 'flag' => $_language->country->flag, 'active' => $active_language->id === $_language->id, 'slug' => $slug,];
            }

            $store_information = [];
            $_store_information = (new StoreInformation)->where('type', 'store_info')->get();
            foreach($_store_information as $_si){
                if($_si->key === 'address'){
                    $store_information['address'] = $_si->value;
                } else if($_si->key === 'address_url'){
                    $store_information['address_url'] = $_si->value;
                } else if($_si->key === 'phone_primary'){
                    $store_information['phone_primary'] = $_si->value;
                } else if($_si->key === 'phone_secondary'){
                    $store_information['phone_secondary'] = $_si->value;
                } else if($_si->key === 'email'){
                    $store_information['email'] = $_si->value;
                } else if($_si->key === 'facebook'){
                    $store_information['facebook'] = $_si->value;
                }
            }

            $store_information_working_hours = (new StoreInformation)->where('type', 'working_hours')->get(['id', 'type', 'key as name', 'value', 'order']);
            $store_information['working_hours'] = $store_information_working_hours;

            $store_information_credentials = (new StoreInformation)->where('type', 'credentials')->get(['id', 'type', 'key as name', 'value', 'order']);
            $store_information['credentials'] = $store_information_credentials;

            $profile_page_slug = $locale . '/' . (new LanguagePage)->where('type', 'user_profile')->where('language_id', $active_language->id)->first()->slug;

            $top_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'top_menu')->first();
            $top_menu_item = MenuItem::where('menu_id', $top_menu->id)->get();
            $top_menu = $this->getMenuTree($top_menu_item, $locale, null);

            $main_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'main_menu')->first();
            $main_menu_item = MenuItem::where('menu_id', $main_menu->id)->get();
            $main_menu = $this->getMenuTree($main_menu_item, $locale, null);

            $footer_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'footer_menu')->first();
            $footer_menu_item = MenuItem::where('menu_id', $footer_menu->id)->get();
            $footer_menu = $this->getMenuTree($footer_menu_item, $locale, null);

            $menus = ['top_menu' => $top_menu, 'main_menu' => $main_menu, 'footer_menu' => $footer_menu,];

            if ($request->has('emailVerificationToken')) {
                $user = (new User)->where('email_verification_token', $request['emailVerificationToken'])->whereNull('email_verified_at')->first();
                if ($user) {
                    $user->email_verified_at = Carbon::now();
                    $user->email_verification_token = null;
                    $user->save();

                    $extra['email_verified'] = true;
                }
            } else if ($request->has('passwordResetToken')) {
                $password_reset = (new PasswordReset)->where('token', $request['passwordResetToken'])->where('used', 0)->where('active', 1)->first();
                if ($password_reset) {
                    $extra['reset_password'] = true;
                    $extra['password_reset_token'] = $password_reset->token;
                }
            }

            $_vehicle_brands = (new LanguagePage)->where('type', 'vehicle')->where('language_id', $active_language->id)->where('status', 1)->get(['id', 'page_id', 'name'])->toArray();

            $vehicle_brands = [];
            foreach($_vehicle_brands as $_vehicle_brand){
                $vehicle_brands[] = [
                    'id' => $_vehicle_brand['id'],
                    'page_id' => $_vehicle_brand['page_id'],
                    'name' => $_vehicle_brand['name'],
                    'visible' => true,
                ];
            }

            if($route[0] === 'purchase-made'){
                $purchase_made_block = [
                    'key' => 'purchase-made'
                ];

                $sidebar_blocks = [];
                $blocks = [$purchase_made_block];

                return view('frontend.application', compact(
                    'meta_data',
                    'locale',
                    'auth',
                    'languages',
                    'store_information',
                    'profile_page_slug',
                    'menus',
                    'sidebar_blocks',
                    'blocks',
                    'url',
                    'extra',
                    'vehicle_brands'
                ));
            }

            if(!$page){
                $page = (new LanguagePage)->where('type', 'page_not_found')->where('language_id', $active_language->id)->first();
                $data = [
                    'title' => $page->name,
                    'description' => $page->description,
                ];

                return view('errors.404', compact(
                    'meta_data',
                    'locale',
                    'data',
                    'auth',
                    'languages',
                    'store_information',
                    'profile_page_slug',
                    'menus',
                    'url',
                    'extra',
                    'vehicle_brands'
                ));
            }

            $page_header = false;
            if($page->page_header) {
                $breadcrumbs = $this->getBreadcrumbs($page, $active_language, $locale);

                $page_header = [
                    'title' => $page->name,
                    'description' => $page->description,
                    'big' => $page->featured_image_big,
                    'breadcrumbs' => $breadcrumbs,
                ];
            }

            $sidebar_blocks = (new LanguagePageSidebarBlock)->where('language_page_id', $page->id)->orderBy('order')->get()->toArray();
            foreach ($sidebar_blocks as $sidebar_block_index => $sidebar_block) {
                if ($sidebar_block['key'] === 'block-navigation') {
                    foreach($sidebar_block['data']['items'] as $navigation_item_index => $navigation_item){
                        if(isset($navigation_item['page']['id'])) {
                            $navigation_item_page = (new LanguagePage)->where('page_id', $navigation_item['page']['id'])->where('language_id', $active_language->id)->first(['id', 'name', 'slug']);

                            if ($navigation_item_page) {
                                $sidebar_blocks[$sidebar_block_index]['data']['items'][$navigation_item_index]['page'] = $locale . '/' . $navigation_item_page->slug;

                                if (!$sidebar_blocks[$sidebar_block_index]['data']['items'][$navigation_item_index]['title']) {
                                    $sidebar_blocks[$sidebar_block_index]['data']['items'][$navigation_item_index]['title'] = $navigation_item_page->name;
                                }
                            }
                        }
                    }
                }
            }

            $blocks = (new LanguagePageBlock)->where('language_page_id', $page->id)->orderBy('order')->get()->toArray();
            foreach ($blocks as $block_index => $block) {
                if ($block['key'] === 'block-hero-search' && $block['data']['show_vehicle_brands']) {
                    foreach ($block['data']['vehicle_brands'] as $popular_vehicle_brand_index => $popular_vehicle_brand) {
                        $_popular_vehicle_brand = (new LanguagePage)->where('id', $popular_vehicle_brand['value'])->first(['id', 'name', 'slug']);
                        $blocks[$block_index]['data']['popular_vehicle_brands'][$popular_vehicle_brand_index]['name'] = $_popular_vehicle_brand->name;
                        $blocks[$block_index]['data']['popular_vehicle_brands'][$popular_vehicle_brand_index]['slug'] = $locale . '/' . $_popular_vehicle_brand->slug;
                    }
                }

                if ($block['key'] === 'block-popular-categories') {
                    foreach ($block['data']['items'] as $popular_category_index => $popular_product_category) {
                        $_product_category = (new LanguagePage)->where('page_id', $popular_product_category['product_category']['id'])->where('language_id', $active_language->id)->first(['id', 'name', 'slug']);
                        $blocks[$block_index]['data']['items'][$popular_category_index]['product_category']['slug'] = $locale . '/' . $_product_category->slug;
                    }
                }

                if ($block['key'] === 'block-two-banner') {
                    $blocks[$block_index]['data']['first_banner_link'] = $locale . '/' . $blocks[$block_index]['data']['first_banner_link'];
                    $blocks[$block_index]['data']['second_banner_link'] = $locale . '/' . $blocks[$block_index]['data']['second_banner_link'];
                }

                if ($block['key'] === 'block-popular-products') {
                    $products = [];

                    $product_data_ids = (new ProductTypeType)->where('product_type_id', ProductTypeType::POPULAR)->where('language_id', $active_language->id)->pluck('product_data_id')->toArray();
                    $product_data = (new ProductData)->whereIn('id', $product_data_ids)->get(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);
                    foreach ($product_data as $pd) {
                        $product = (new LanguagePage)->where('id', $pd->product_id)->first(['id', 'name', 'featured_image', 'slug']);
                        $manufacturer = (new LanguagePage)->where('page_id', $pd->manufacturer_id)->first(['id', 'name', 'featured_image']);

                        $labels = [];
                        $label_ids = (new ProductLabelLabel)->where('product_data_id', $pd->id)->pluck('product_label_id')->toArray();
                        $_labels = (new ProductLabel)->whereIn('id', $label_ids)->get(['id', 'key']);
                        foreach ($_labels as $_label) {
                            $label_language = (new ProductLabelLanguage)->where('label_id', $_label->id)->where('language_id', $active_language->id)->first(['name']);

                            $labels[] = ['name' => $label_language->name, 'key' => $_label->key,];
                        }

                        $products[] = ['id' => $product->id, 'name' => $product->name, 'image' => $product->featured_image, 'slug' => $locale . '/' . $product->slug, 'manufacturer' => $manufacturer ? ['name' => $manufacturer->name, 'image' => $manufacturer->featured_image] : null, 'sku' => $pd->sku, 'price' => number_format($pd->price, 2), 'special_price' => $pd->special_price && $pd->special_price < $pd->price ? number_format($pd->special_price, 2) : null, 'discount_percentage' => $pd->special_price && $pd->special_price < $pd->price ? $this->getDiscountPercentage($pd->price, $pd->special_price) : null, 'labels' => $labels];
                    }

                    $blocks[$block_index]['data']['items'] = $products;
                }

                if ($block['key'] === 'block-recent-posts') {
                    $_blog_page = (new LanguagePage)->where('type', 'blog')->where('language_id', $active_language->id)->first(['id', 'slug']);

                    $blocks[$block_index]['data']['view_all_posts_link'] = $locale . '/' . $_blog_page['slug'];

                    $recent_posts = [];
                    $_recent_posts = (new LanguagePage)->where('type', 'blog_post')->where('language_id', $active_language->id)->latest()->take(3)->get(['id', 'name', 'slug', 'featured_image', 'created_at']);
                    foreach ($_recent_posts as $recent_post) {
                        $recent_posts[] = ['name' => $recent_post['name'], 'image' => $recent_post['featured_image'], 'link' => $locale . '/' . $recent_post['slug'], 'created_at' => Carbon::parse($recent_post['created_at'])->format('d.m.Y'),];
                    }
                    $blocks[$block_index]['data']['recent_posts'] = $recent_posts;
                }

                if ($block['key'] === 'block-page-header') {
                    $breadcrumbs = [];
                    if($block['data']['show_breadcrumbs']){
                        $breadcrumbs_page = (new Page)->where('id', $page->page_id)->first();
                        if($breadcrumbs_page && $breadcrumbs_page->parent_id){
                            $breadcrumbs_parent_page = (new Page)->where('id', $breadcrumbs_page->parent_id)->first();
                            if($breadcrumbs_parent_page){
                                $breadcrumbs_parent_language_page = (new LanguagePage)->where('page_id', $breadcrumbs_parent_page->id)->where('language_id', $active_language->id)->first();
                                if($breadcrumbs_parent_language_page){

                                    $breadcrumbs_parent_parent_page = (new Page)->where('id', $breadcrumbs_parent_page->parent_id)->first();
                                    if($breadcrumbs_parent_parent_page){
                                        $breadcrumbs_parent_parent_language_page = (new LanguagePage)->where('page_id', $breadcrumbs_parent_parent_page->id)->where('language_id', $active_language->id)->first();
                                        if($breadcrumbs_parent_parent_language_page){
                                            $breadcrumbs[] = [
                                                'name' => $breadcrumbs_parent_parent_language_page->name,
                                                'slug' => $locale . '/' . $breadcrumbs_parent_parent_language_page->slug,
                                            ];
                                        }
                                    }


                                    $breadcrumbs[] = [
                                        'name' => $breadcrumbs_parent_language_page->name,
                                        'slug' => $locale . '/' . $breadcrumbs_parent_language_page->slug,
                                    ];

                                    $breadcrumbs[] = [
                                        'name' => $page->name,
                                        'page' => $page->slug,
                                    ];
                                }
                            }
                        }
                    }
                    $blocks[$block_index]['data']['breadcrumbs'] = $breadcrumbs;
                }
            }

            $newsletter = $page->newsletter;

            if($page->type === 'vehicle'){
                $vehicle_block = [
                    'key' => 'vehicle',
                    'data' => [

                    ]
                ];
                array_unshift($blocks, $vehicle_block);
            }

            if($page->type === 'choose_vehicle' || $page->type === 'vehicle'){
                $all_vehicles = (new LanguagePage)->where('type', 'vehicle')->where('language_id', $active_language->id)->where('status', 1)->get(['id', 'name', 'slug', 'featured_image', 'popular', 'status'])->toArray();
                $popular_vehicles = [];
                foreach($all_vehicles as $vehicle){
                    if($vehicle['popular']) {
                        $popular_vehicles[] = $vehicle;
                    }
                }

                $brand = null;
                if($page->type === 'vehicle'){
                    $brand = [
                        'id' => $page->id,
                        'name' => $page->name,
                        'image' => $page->featured_image,
                    ];
                }

                $vehicle_block = [
                    'key' => 'block-choose-vehicle',
                    'data' => [
                        'popular_vehicles' => $popular_vehicles,
                        'all_vehicles' => $all_vehicles,
                        'brand' => $brand,
                        'year' => null,
                        'model' => null,
                        'engine' => null,
                    ]
                ];
                array_unshift($blocks, $vehicle_block);
            }

            if($page->type === 'product_category') {
                $product_category_data = ProductCategoryData::where('product_category_id', $page->id)->first();
                $products = (new ProductController())->getCategoryProducts($active_language->id, $page->page_id, explode(',', $request->filters));
                $categories = (new ProductController())->getProductCategories($active_language->id);
                $filters = Attribute::with([
                    'values.translation' => function ($query) use ($active_language) {
                        $query->where('language_id', $active_language->id);
                    },
                    'translation' => function ($query) use ($active_language) {
                        $query->where('language_id', $active_language->id);
                    },
                ])->where('filterable', true)->get();

                $product_category_block = [
                    'key' => 'block-product-category',
                    'data' => [
                        'breadcrumbs' => $this->getBreadcrumbs($page, $active_language, $locale),
                        'category' => [
                            'id' => $page->id,
                            'page_id' => $page->page_id,
                            'name' => $page->name,
                            'display_mode' => $product_category_data ? $product_category_data->display_mode : 'products',
                            'blocks' => $blocks,
                        ],
                        'products' => $products,
                        'categories' => $categories,
                        'filters' => $filters,
                    ]
                ];

                $blocks = [$product_category_block];
            }

            if($page->type === 'product') {
                $popular_products = [];

                $popular_product_data_ids = (new ProductTypeType)->where('product_type_id', ProductTypeType::POPULAR)->where('language_id', $active_language->id)->pluck('product_data_id')->toArray();
                $popular_product_data = (new ProductData)->whereIn('id', $popular_product_data_ids)->get(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);

                foreach ($popular_product_data as $ppd) {
                    $product = (new LanguagePage)->where('id', $ppd->product_id)->first(['id', 'name', 'featured_image', 'slug']);
                    $manufacturer = (new LanguagePage)->where('page_id', $ppd->manufacturer_id)->first(['id', 'name', 'featured_image']);

                    $labels = [];
                    $label_ids = (new ProductLabelLabel)->where('product_data_id', $ppd->id)->pluck('product_label_id')->toArray();
                    $_labels = (new ProductLabel)->whereIn('id', $label_ids)->get(['id', 'key']);
                    foreach ($_labels as $_label) {
                        $label_language = (new ProductLabelLanguage)->where('label_id', $_label->id)->where('language_id', $active_language->id)->first(['name']);

                        $labels[] = ['name' => $label_language->name, 'key' => $_label->key,];
                    }

                    $popular_products[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'image' => $product->featured_image,
                        'slug' => $locale . '/' . $product->slug,
                        'manufacturer' => $manufacturer ? [
                            'name' => $manufacturer->name,
                            'image' => $manufacturer->featured_image
                        ] : null,
                        'sku' => $ppd->sku,
                        'price' => number_format($ppd->price, 2),
                        'special_price' => $ppd->special_price && $ppd->special_price < $ppd->price ? number_format($ppd->special_price, 2) : null,
                        'discount_percentage' => $ppd->special_price && $ppd->special_price < $ppd->price ? $this->getDiscountPercentage($ppd->price, $ppd->special_price) : null,
                        'labels' => $labels
                    ];
                }

                $product_labels = [];
                $product_types = [];
                $product_data = (new ProductData)->where('product_id', $page->id)->first(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);

                $label_ids = (new ProductLabelLabel)->where('product_data_id', $product_data->id)->pluck('product_label_id')->toArray();
                $_labels = (new ProductLabel)->whereIn('id', $label_ids)->get(['id', 'key']);

                $types_ids = (new ProductTypeType())->where('product_data_id', $product_data->id)->pluck('product_type_id')->toArray();
                $_types = (new ProductType())->whereIn('id', $types_ids)->get(['id', 'key']);

                foreach ($_labels as $_label) {
                    $label_language = (new ProductLabelLanguage)->where('label_id', $_label->id)->where('language_id', $active_language->id)->first(['name']);

                    if ($label_language) {
                        $product_labels[] = ['name' => $label_language->name, 'key' => $_label->key];
                    }
                }

                foreach ($_types as $_type) {
                    $type_language = (new ProductTypeLanguage())->where('type_id', $_type->id)->where('language_id', $active_language->id)->first(['name']);

                    if ($type_language) {
                        $product_types[] = ['name' => $type_language->name, 'key' => $_type->key];
                    }
                }

                $product_manufacturer = (new LanguagePage)->where('page_id', $product_data->manufacturer_id)->first(['id', 'name', 'featured_image']);

                $ProductController = new ProductController();

                $product_category_block = [
                    'key' => 'block-product',
                    'data' => [
                        'breadcrumbs' => $this->getBreadcrumbs($page, $active_language, $locale),
                        'product' => [
                            'id' => $page->page_id,
                            'name' => $page->name,
                            'gallery' => $ProductController->getGalleryImages($page->page_id),
                            'featured_image' => $page->featured_image,
                            'data' => $product_data,
                            'labels' => $product_labels,
                            'types' => $product_types,
                            'manufacturer' => $product_manufacturer,
                            'parameters' => $ProductController->getParameters($page->id, $active_language->id),
                            'substitutes' => $ProductController->getSubstituteProducts($page->page_id, $active_language->id),
                            'warehouse_count' => $ProductController->getWarehouseCount($page->page_id, $active_language->id),
                            'warehouse_delivers' => $ProductController->getWarehouseDelivers(),
                            'downloads' => $ProductController->getDownloadFiles($active_language->id, $page->page_id)
                        ],
                        'language_id' => $active_language->id,
                        'popular_products' => $popular_products
                    ]
                ];
                array_unshift($blocks, $product_category_block);
            }

            if($page->type === 'product_compare') {
                $product_compare_block = [
                    'key' => 'block-product-compare',
                    'data' => [
                        'title' => $page->name,
                        'breadcrumbs' => $this->getBreadcrumbs($page, $active_language, $locale),
                        'products' => [],
                    ]
                ];

                $blocks = [$product_compare_block];
            }

            if($page->type === 'blog') {
                $blog_block = [
                    'key' => 'block-blog',
                    'data' => [
                        'posts' => []
                    ]
                ];

                $blocks = [$blog_block];
            }

            if($page->type === 'blog_post') {
                $blog_post_block = [
                    'key' => 'block-blog-post',
                    'data' => [
                        'breadcrumbs' => $this->getBreadcrumbs($page, $active_language, $locale),
                        'post' => [
                            'title' => 'blog post title here',
                            'date' => Carbon::now(),
                            'description' => 'Blog post description here',
                        ],
                        'related_posts' => []
                    ]
                ];

                $blocks = [$blog_post_block];
            }

            if($page->type === 'cart') {
                $checkout_page = (new LanguagePage)->where('type', 'checkout')->where('language_id', $active_language->id)->first();

                $cart_block = [
                    'key' => 'block-cart',
                    'data' => [
                        'header_navigation' => [
                            [
                                'title' => $page->name,
                                'slug' => $locale . '/' . $page->slug,
                                'active' => true,
                            ],
                            [
                                'title' => $checkout_page->name,
                                'slug' => $locale . '/' . $checkout_page->slug,
                                'active' => false,
                            ]
                        ],
                        'breadcrumbs' => $this->getBreadcrumbs($page, $active_language, $locale),
                        'title' => $page->name,
                    ]
                ];

                $blocks = [$cart_block];
            }

            if($page->type === 'user_profile') {
                $profile_block = [
                    'key' => 'block-profile'
                ];

                $blocks = [$profile_block];
            }

            return view('frontend.application', compact(
                'meta_data',
                'locale',
                'auth',
                'languages',
                'store_information',
                'profile_page_slug',
                'menus',
                'page_header',
                'sidebar_blocks',
                'blocks',
                'newsletter',
                'url',
                'extra',
                'vehicle_brands'
            ));
        }
    }

    /**
     * @param $page
     * @param $active_language
     * @param $locale
     * @return array
     */
    public function getBreadcrumbs($page, $active_language, $locale): array
    {
        $breadcrumbs = [];

        if($page->type === 'product_category'){
            $home = (new LanguagePage)->where('type', 'home')->where('language_id', $active_language->id)->first();

            $breadcrumbs[] = [
                'name' => $home->name,
                'slug' => $locale ?: '/',
            ];
        }

        if($page->breadcrumbs || $page->type === 'product_category' || $page->type === 'product_compare' || $page->type === 'cart' || $page->type === 'checkout' || $page->type === 'product') {
            $breadcrumbs_page = (new Page)->where('id', $page->page_id)->first();
            if($page->type === 'product'){
                if($breadcrumbs_page){
                    $breadcrumbs_language_page = (new LanguagePage)->where('page_id', $breadcrumbs_page->id)->where('language_id', $active_language->id)->first(['id', 'name', 'slug']);
                    if($breadcrumbs_language_page){
                        $product_data = (new ProductData)->where('product_id', $breadcrumbs_language_page->id)->first('id');
                        if($product_data){
                            $product_category = (new ProductCategoryCategorie)->where('product_data_id', $product_data->id)->first(['id', 'product_category_id']);
                            if($product_category) {
                                $category_page = (new LanguagePage)->where('language_id', $active_language->id)->where('page_id', $product_category->product_category_id)->first();

                                $breadcrumbs = $this->getBreadcrumbs($category_page, $active_language, $locale);
                                $breadcrumbs[] = [
                                    'name' => $breadcrumbs_language_page->name,
                                    'slug' => $locale . '/' . $breadcrumbs_language_page->slug
                                ];
                            }
                        }
                    }
                }
            } else {
                if ($breadcrumbs_page && $breadcrumbs_page->parent_id) {
                    $breadcrumbs_parent_page = (new Page)->where('id', $breadcrumbs_page->parent_id)->first();
                    if ($breadcrumbs_parent_page) {
                        $breadcrumbs_parent_language_page = (new LanguagePage)->where('page_id', $breadcrumbs_parent_page->id)->where('language_id', $active_language->id)->first();
                        if ($breadcrumbs_parent_language_page) {

                            $breadcrumbs_parent_parent_page = (new Page)->where('id', $breadcrumbs_parent_page->parent_id)->first();
                            if ($breadcrumbs_parent_parent_page) {
                                $breadcrumbs_parent_parent_language_page = (new LanguagePage)->where('page_id', $breadcrumbs_parent_parent_page->id)->where('language_id', $active_language->id)->first();
                                if ($breadcrumbs_parent_parent_language_page) {
                                    $breadcrumbs[] = [
                                        'name' => $breadcrumbs_parent_parent_language_page->name,
                                        'slug' => $locale . '/' . $breadcrumbs_parent_parent_language_page->slug,
                                    ];
                                }
                            }

                            $breadcrumbs[] = [
                                'name' => $breadcrumbs_parent_language_page->name,
                                'slug' => $locale . '/' . $breadcrumbs_parent_language_page->slug,
                            ];

                            $breadcrumbs[] = [
                                'name' => $page->name,
                                'slug' => $page->slug,
                            ];
                        }
                    }
                } else {
                    if($page->type === 'product_category'){
                        $breadcrumbs_parent_language_page = (new LanguagePage)->where('page_id', $breadcrumbs_page->id)->where('language_id', $active_language->id)->first();
                        $breadcrumbs[] = [
                            'name' => $breadcrumbs_parent_language_page->name,
                            'slug' => $locale . '/' . $breadcrumbs_parent_language_page->slug,
                        ];
                    }
                }
            }
        }

        return $breadcrumbs;
    }

    /**
     * @param $price
     * @param $special_price
     * @return int
     */
    protected function getDiscountPercentage($price, $special_price): int
    {
        return floor((($price - $special_price) / $price) * 100);
    }

    /**
     * @param $menu_items
     * @param $locale
     * @param null $parent_id
     * @return array
     */
    protected function getMenuTree($menu_items, $locale, $parent_id = null): array
    {
        $menu_tree = [];
        foreach ($menu_items as $item) {
            if ($item['item_id']) {
                $language_page = (new LanguagePage)->where('id', $item['item_id'])->first();
                $slug = $language_page ? $language_page->slug : '';
                $url = $locale . '/' . $slug;
            } else {
                $url = $item['url'];
            }

            if ($item['parent_id'] == $parent_id) {
                $children = $this->getMenuTree($menu_items, $locale, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }

                if ($item['children']) {
                    $menu_tree[] = ['id' => $item['id'], 'item_id' => $item['item_id'], 'text' => $item['text'], 'url' => $url, 'open_in_new_tab' => $item['open_in_new_tab'], 'children' => $item['children']];
                } else {
                    $menu_tree[] = ['id' => $item['id'], 'item_id' => $item['item_id'], 'text' => $item['text'], 'url' => $url, 'open_in_new_tab' => $item['open_in_new_tab'],];
                }
            }
        }

        return $menu_tree;
    }
}
