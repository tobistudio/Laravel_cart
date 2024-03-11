<?php

namespace App\Http\Controllers;

use App\Models\ActiveCart;
use App\Models\ActiveCartProduct;
use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\LanguagePageBlock;
use App\Models\Menu;
use App\Models\MenuItem;
use App\Models\ProductData;
use App\Models\ProductLabel;
use App\Models\ProductLabelLabel;
use App\Models\ProductLabelLanguage;
use App\Models\ProductTypeType;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\Foundation\Application as ContractApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ApplicationController extends Controller
{
    /**
     * @param $params
     * @return View|Application|Factory|ContractApplication
     */
    public function index($params = null): View|Application|Factory|ContractApplication
    {
        $route = explode('/', $params);
        if ($route[0] === 'system') {
            return view('backend');
        } else {
            $active_language = (new Language)->where('locale', $route[0])->with('country')->first();
            if(!$active_language){
                $active_language = (new Language)->where('primary', 1)->first();
                $locale = '';
                $url = $params;
            } else {
                $locale = '/' . $active_language->locale;
                $url = implode('/', array_slice($route, 1, count($route)-1, true));
            }

            $page = (new LanguagePage)->where('language_id', $active_language->id)->where('slug', $url ?: '')->first();

            $languages = [
                'active' => [
                    'name' => $active_language->name,
                    'flag' => $active_language->country->flag,
                ],
                'data' => []
            ];
            $_languages = (new Language)->where('active', Language::ACTIVE)->with('country:id,flag')->get(['id', 'name', 'locale', 'primary', 'country_id']);
            foreach($_languages as $_language){
                $slug = null;

                if($active_language->id !== $_language->id){
                    $language_page = (new LanguagePage)->where('language_id', $_language->id)->where('page_id', $page->page_id)->first();

                    if($_language->primary){
                        $slug = '/' . $language_page->slug;
                    } else {
                        $slug = '/' . $_language->locale . ($language_page->slug ? '/' . $language_page->slug : '');
                    }
                }

                $languages['data'][] = [
                    'name' => $_language->name,
                    'flag' => $_language->country->flag,
                    'active' => $active_language->id === $_language->id,
                    'slug' => $slug,
                ];
            }

            $auth = Auth::guard('api')->check();

            $meta_data = [
                'title' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'description' => (isset($page) ? ($page->meta_description ?: ($page->description ?: $page->name) . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:type' => 'website',
                'og:title' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:description' => (isset($page) ? ($page->meta_description ?: ($page->description ?: $page->name) . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:url' => env('APP_URL') . '/' . $params,
                'og:image' => env('APP_URL') . (isset($page) && $page->meta_image ? $page->meta_image.'?' . time() : '/images/rb24-logo-share.jpg?' . time()),
                'og:image:alt' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'og:image:type' => 'image/png',
                'og:image:width' => '1200',
                'og:image:height' => '630',
                'twitter:card' => 'summary',
                'twitter:title' => (isset($page) ? ($page->meta_title ?: $page->name . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'twitter:description' => (isset($page) ? ($page->meta_description ?: ($page->description ?: $page->name) . ' | ' . env('APP_NAME')) : env('APP_NAME')),
                'twitter:image' => env('APP_URL') . (isset($page) && $page->meta_image ? $page->meta_image.'?' . time() : '/images/rb24-logo-share.jpg?' . time()),
            ];

            $top_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'top_menu')->first();
            $top_menu_item = MenuItem::where('menu_id', $top_menu->id)->get();
            $top_menu = $this->getMenuTree($top_menu_item, $locale, null);

            $main_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'main_menu')->first();
            $main_menu_item = MenuItem::where('menu_id', $main_menu->id)->get();
            $main_menu = $this->getMenuTree($main_menu_item, $locale, null);

            $footer_menu = (new Menu)->where('language_id', $active_language->id)->where('key', 'footer_menu')->first();
            $footer_menu_item = MenuItem::where('menu_id', $footer_menu->id)->get();
            $footer_menu = $this->getMenuTree($footer_menu_item, $locale, null);

            $menus = [
                'top_menu' => $top_menu,
                'main_menu' => $main_menu,
                'footer_menu' => $footer_menu,
            ];

            $blocks = LanguagePageBlock::where('language_page_id', $page->id)->orderBy('order')->get()->toArray();

            foreach($blocks as $block_index => $block){
                if($block['key'] === 'block-hero-search' && $block['data']['show_vehicle_brands']){
                    foreach($block['data']['vehicle_brands'] as $vehicle_brand_index => $vehicle_brand){
                        $_vehicle_brand = (new LanguagePage)->where('id', $vehicle_brand['value'])->first(['id', 'name', 'slug']);
                        $blocks[$block_index]['data']['vehicle_brands'][$vehicle_brand_index]['name'] = $_vehicle_brand->name;
                        $blocks[$block_index]['data']['vehicle_brands'][$vehicle_brand_index]['slug'] = $locale . '/' . $_vehicle_brand->slug;
                    }
                }

                if($block['key'] === 'block-popular-categories'){
                    foreach($block['data']['items'] as $popular_category_index => $popular_product_category){
                        $_product_category = (new LanguagePage)->where('page_id', $popular_product_category['product_category']['id'])->where('language_id', $active_language->id)->first(['id', 'name', 'slug']);
                        $blocks[$block_index]['data']['items'][$popular_category_index]['product_category']['slug'] = $locale . '/' . $_product_category->slug;
                    }
                }

                if($block['key'] === 'block-two-banner'){
                    $blocks[$block_index]['data']['first_banner_link'] = $locale . '/' . $blocks[$block_index]['data']['first_banner_link'];
                    $blocks[$block_index]['data']['second_banner_link'] = $locale . '/' . $blocks[$block_index]['data']['second_banner_link'];
                }

                if($block['key'] === 'block-popular-products') {
                    $products = [];

                    $product_data_ids = (new ProductTypeType)->where('product_type_id', ProductTypeType::POPULAR)->where('language_id', $active_language->id)->pluck('product_data_id')->toArray();
                    $product_data = (new ProductData)->whereIn('id', $product_data_ids)->get(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);
                    foreach($product_data as $pd){
                        $product = (new LanguagePage)->where('id', $pd->product_id)->first(['id', 'name', 'featured_image', 'slug']);
                        $manufacturer = (new LanguagePage)->where('page_id', $pd->manufacturer_id)->first(['id', 'name', 'featured_image']);

                        $labels = [];
                        $label_ids = (new ProductLabelLabel)->where('product_data_id', $pd->id)->pluck('product_label_id')->toArray();
                        $_labels = (new ProductLabel)->whereIn('id', $label_ids)->get(['id', 'key']);
                        foreach($_labels as $_label){
                            $label_language = (new ProductLabelLanguage)->where('label_id', $_label->id)->where('language_id', $active_language->id)->first(['name']);

                            $labels[] = [
                                'name' => $label_language->name,
                                'key' => $_label->key,
                            ];
                        }

                        $products[] = [
                            'id' => $product->id,
                            'name' => $product->name,
                            'image' => $product->featured_image,
                            'slug' => $locale . '/' . $product->slug,
                            'product_data' => $pd,
                            'manufacturer' => $manufacturer ? [
                                'name' => $manufacturer->name,
                                'image' => $manufacturer->featured_image
                            ] : null,
                            'sku' => $pd->sku,
                            'price' => number_format($pd->price, 2),
                            'special_price' => $pd->special_price && $pd->special_price < $pd->price ? number_format($pd->special_price, 2) : null,
                            'discount_percentage' => $pd->special_price && $pd->special_price < $pd->price ? $this->getDiscountPercentage($pd->price, $pd->special_price) : null,
                            'labels' => $labels
                        ];
                    }

                    $blocks[$block_index]['data']['items'] = $products;
                }

                if($block['key'] === 'block-recent-posts'){
                    $_blog_page = (new LanguagePage)->where('type', 'blog')->where('language_id', $active_language->id)->first(['id', 'slug']);

                    $blocks[$block_index]['data']['view_all_posts_link'] = $locale . '/' . $_blog_page['slug'];

                    $recent_posts = [];
                    $_recent_posts = (new LanguagePage)->where('type', 'blog_post')->where('language_id', $active_language->id)->latest()->take(3)->get(['id', 'name', 'slug', 'featured_image', 'created_at']);
                    foreach($_recent_posts as $recent_post){
                        $recent_posts[] = [
                          'name' => $recent_post['name'],
                          'image' => $recent_post['featured_image'],
                          'link' => $locale . '/' . $recent_post['slug'],
                          'created_at' => Carbon::parse($recent_post['created_at'])->format('d.m.Y'),
                        ];
                    }
                    $blocks[$block_index]['data']['recent_posts'] = $recent_posts;
                }

                if($block['key'] === 'block-product-details')
                {
                    $productData = (new ProductData)->where('product_id', $page->id)->first(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);

                    if ($productData) {
                        $product = (new LanguagePage)->where('id', $productData->product_id)->first(['id', 'name', 'featured_image', 'slug','description']);
                        $manufacturer = (new LanguagePage)->where('page_id', $productData->manufacturer_id)->first(['id', 'name', 'featured_image']);

                        $labels = [];
                        $labelIds = (new ProductLabelLabel)->where('product_data_id', $productData->id)->pluck('product_label_id')->toArray();
                        $_labels = (new ProductLabel)->whereIn('id', $labelIds)->get(['id', 'key']);
                        foreach ($_labels as $_label) {
                            $labelLanguage = (new ProductLabelLanguage)->where('label_id', $_label->id)->where('language_id', $active_language->id)->first(['name']);

                            $labels[] = [
                                'name' => $labelLanguage->name,
                                'key' => $_label->key,
                            ];
                        }

                        $productDetails = [
                            'id' => $page->page_id,
                            'name' => $product->name,
                            'image' => $product->featured_image,
                            'slug' => $locale . '/' . $product->slug,
                            'product_data' => $productData,
                            'manufacturer' => $manufacturer ? [
                                'name' => $manufacturer->name,
                                'image' => $manufacturer->featured_image
                            ] : null,
                            'sku' => $productData->sku,
                            'description' => $product->description,
                            'price' => number_format($productData->price, 2),
                            'special_price' => $productData->special_price && $productData->special_price < $productData->price ? number_format($productData->special_price, 2) : null,
                            'discount_percentage' => $productData->special_price && $productData->special_price < $productData->price ? $this->getDiscountPercentage($productData->price, $productData->special_price) : null,
                            'labels' => $labels
                        ];

                        $blocks[$block_index]['data']['product_details'] = $productDetails;
                    }
                }


                if ($block['key'] === 'block-cart-items') {
                    $identifier = Auth::check() ? null : Session::getId();
                    $cart = ActiveCart::where('session_id', $identifier)->where('user_id', Auth::id())->first();

                    if ($cart) {
                        $cartItems = ActiveCartProduct::where('cart_id', $cart->id)->get();
                        $cartDetails = [];

                        foreach ($cartItems as $item) {
                            $productData = ProductData::where('id', $item->product_id)->first(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);
                            if ($productData) {
                                $product = LanguagePage::where('id', $productData->product_id)->first(['id', 'name', 'featured_image', 'slug']);
                                $manufacturer = LanguagePage::where('page_id', $productData->manufacturer_id)->first(['id', 'name', 'featured_image']);

                                $cartDetails[] = [
                                    'product_id' => $productData->product_id,
                                    'name' => $product->name,
                                    'image' => $product->featured_image,
                                    'slug' => $locale . '/' . $product->slug,
                                    'sku' => $productData->sku,
                                    'price' => number_format($productData->price, 2),
                                    'special_price' => $productData->special_price && $productData->special_price < $productData->price ? number_format($productData->special_price, 2) : null,
                                    'manufacturer' => $manufacturer ? [
                                        'name' => $manufacturer->name,
                                        'image' => $manufacturer->featured_image
                                    ] : null,
                                    'quantity' => $item->qty
                                ];
                            }
                        }

                        $blocks[$block_index]['data']['cart_items'] = $cartDetails;
                    }
                }

            }
            return view('frontend.application', compact('meta_data', 'locale', 'auth', 'languages', 'menus', 'blocks', 'url'));
        }
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
            if($item['item_id']){
                $language_page = (new LanguagePage)->where('id', $item['item_id'])->first();
                $url = $locale . '/'.$language_page->slug;
            } else {
                $url = $item['url'];
            }

            if ($item['parent_id'] == $parent_id) {
                $children = $this->getMenuTree($menu_items, $locale, $item['id']);
                if ($children) {
                    $item['children'] = $children;
                }

                if ($item['children']) {
                    $menu_tree[] = [
                        'id' => $item['id'],
                        'item_id' => $item['item_id'],
                        'text' => $item['text'],
                        'url' => $url,
                        'open_in_new_tab' => $item['open_in_new_tab'],
                        'children' => $item['children']
                    ];
                } else {
                    $menu_tree[] = [
                        'id' => $item['id'],
                        'item_id' => $item['item_id'],
                        'text' => $item['text'],
                        'url' => $url,
                        'open_in_new_tab' => $item['open_in_new_tab'],
                    ];
                }
            }
        }

        return $menu_tree;
    }
}
