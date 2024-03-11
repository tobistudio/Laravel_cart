<?php

namespace App\Http\Controllers;

use App\Http\Enums\ParameterType;
use App\Http\Enums\ProductRelationType;
use App\Models\ActiveCart;
use App\Models\ActiveCartsProduct;
use App\Models\ActiveProductComparison;
use App\Models\ActiveProductComparisonsProduct;
use App\Models\Language;
use App\Models\LanguagePage;
use App\Models\Page;
use App\Models\ProductAttribute;
use App\Models\ProductData;
use App\Models\ProductDownload;
use App\Models\ProductGallery;
use App\Models\ProductLabel;
use App\Models\ProductLabelLabel;
use App\Models\ProductLabelLanguage;
use App\Models\ProductParameter;
use App\Models\ProductParameterGroup;
use App\Models\ProductRelation;
use App\Models\ProductSubstitute;
use App\Models\ProductWarehouse;
use App\Models\Translation;
use App\Models\Warehouse;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    /**
     * @param int $page_id
     * @return Collection|array
     */
    public function getGalleryImages(int $page_id): Collection|array
    {
        return ProductGallery::where('product_id', $page_id)
            ->orderBy('img_order')
            ->get();
    }

    /**
     * @param int $page_id
     * @return JsonResponse
     */
    public function getGalleryImagesAPI(int $page_id): JsonResponse
    {
        $images = $this->getGalleryImages($page_id);

        return response()->json($images);
    }

    /**
     * @param int $page_id
     * @param Request $request
     * @return JsonResponse
     */
    public function createGalleryImage(int $page_id, Request $request): JsonResponse
    {
        $storage_path = '/public/uploads/pages/products/images' . $page_id . '/';

        if (!Storage::fileExists($storage_path)) {
            Storage::makeDirectory($storage_path);
        }

        $sha = sha1(time());
        $extension = explode(';base64', explode('data:image/', $request->input('img'))[1]);
        $full_storage_path = 'app/public/uploads/pages/products/images' . $page_id . '/' . $request->input('img_order') . '_'.$sha . '.'. $extension[0];
        $ext = $extension[0] === 'svg+xml' ? 'svg' : $extension[0];

        if ($ext === 'svg') {
            $image_data = base64_decode(substr($request->input('img'), strpos($request->input('img'), ',') + 1));

            Storage::disk('public')
                ->put('uploads/pages/products/images' . $page_id . '/' . $request->input('img_order') . '_'.$sha . '.'.$ext, $image_data);
        } else {
            Image::make($request->input('img'))->save(storage_path($full_storage_path));
        }

        $image = ProductGallery::create([
            'product_id' => $page_id,
            'img_order' => $request->input('img_order'),
            'img_path' => '/storage/uploads/pages/products/images' . $page_id . '/' . $request->input('img_order') . '_'.$sha . '.'. $ext
        ]);

        return response()->json([
            'image' => $image,
            'success' => true
        ]);
    }

    /**
     * @param $page_id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateGalleryImages($page_id, Request $request): JsonResponse
    {
        $images = $request->input('images');

        foreach ($images as $image) {
            $gallery_image = ProductGallery::where('id', $image['id'])->first();

            $gallery_image->img_order = $image['img_order'];
            $gallery_image->save();
        }

        $images = ProductGallery::where('product_id', $page_id)
            ->orderBy('img_order')
            ->get();

        return response()->json($images);
    }

    /**
     * @param int $page_id
     * @param int $id
     * @return JsonResponse
     */
    public function deleteGalleryImage(int $page_id, int $id): JsonResponse
    {
        $storage_path = '/public/uploads/pages/products/images' . $page_id . '/';

        ProductGallery::where('id', $id)->delete();

        $images = ProductGallery::where('product_id', $page_id)->get();

        if ($images->count() === 0) {
            Storage::deleteDirectory($storage_path, true);
        }

        return response()->json([
            'success' => true
        ]);
    }


    /**
     * @param int $product_id
     * @return array|Collection
     */
    public function getAttributes(int $product_id): array|Collection
    {
        return ProductAttribute::with(['attributeValue.attribute', 'attributeValue.translations'])
            ->where('product_id', $product_id)
            ->get();
    }

    /**
     * @param int $product_id
     * @param array $attributes
     * @return true
     */
    public function addAttributes(int $product_id, array $attributes): bool
    {
        ProductAttribute::where('product_id', $product_id)->delete();

        foreach ($attributes as $attribute) {
            ProductAttribute::create([
                'attribute_value_id' => $attribute['id'],
                'product_id' => $product_id,
            ]);
        }

        return true;
    }

    /**
     * @param int $product_id
     * @param int $language_id
     * @return array|Collection
     */
    public function getSubstituteProducts(int $product_id, int $language_id): array|Collection
    {
        $products = [];
        $product_substitutes = ProductSubstitute::where('product_id', $product_id)
            ->get();

        foreach ($product_substitutes as $product_substitute) {
            $products_substitute = ProductSubstitute::with([
                'product.data' => function ($query) use ($language_id) {
                    $query->where('language_id', $language_id);
                },
                'product.languagePage' => function ($query) use ($language_id) {
                    $query->where('language_id', $language_id);
                },
                'product.warehouses.warehouse.translation' => function ($query) use ($language_id) {
                    $query->where('language_id', $language_id);
                },
            ])
                ->where('attribute_value_id', $product_substitute->attribute_value_id)
                ->whereNot('product_id', $product_id)
                ->get()
                ->toArray();

            foreach ($products_substitute as $ps) {
                $products[] = $ps;
            }
        }

        return $products;
    }

    /**
     * @param int $product_id
     * @return array|Collection
     */
    public function getSubstitutes(int $product_id): array|Collection
    {
        return ProductSubstitute::with([
            'attributeValue.attribute',
            'attributeValue.translations'
        ])
            ->where('product_id', $product_id)
            ->get();
    }

    /**
     * @param int $product_id
     * @param array $attributes
     * @return bool
     */
    public function addSubstitutes(int $product_id, array $attributes): bool
    {
        ProductSubstitute::where('product_id', $product_id)->delete();

        foreach ($attributes as $attribute) {
            ProductSubstitute::create([
                'attribute_value_id' => $attribute['id'],
                'product_id' => $product_id,
            ]);
        }

        return true;
    }

    /**
     * @param int $product_id
     * @param int $language_id
     * @param array $parameters
     * @return bool
     */
    public function addParameters(int $product_id, int $language_id, array $parameters): bool
    {
        $product_params = ProductParameter::with(['group', 'group.translation' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            }])
            ->where('product_id', $product_id)
            ->get();

        foreach ($product_params as $param) {
            if ($param->group) {
                $param->group->translation()->delete();
                $param->group()->delete();
            }

            $param->delete();
        }

        foreach ($parameters as $key => $group) {
            $product_group = null;

            if (!is_null($group['title'])) {
                Translation::create([
                    'key' => 'parameter_group_' . $product_id . '_' . $key,
                    'language_id' => $language_id,
                    'value' => $group['title'],
                ]);

                $product_group = ProductParameterGroup::create([
                    'title_key' => 'parameter_group_' . $product_id . '_' . $key
                ]);
            }

            foreach ($group['items'] as $parameter) {
                ProductParameter::create([
                    'title' => $parameter['title'],
                    'value' => $parameter['value'],
                    'is_primary' => $parameter['is_primary'],
                    'type' => ParameterType::from($parameter['type']['name'])->toInt(),
                    'product_id' => $product_id,
                    'product_group_id' => $product_group?->id,
                    'param_order' => $parameter['param_order'],
                ]);
            }
        }

        return true;
    }

    /**
     * @param int $product_id - language_page id
     * @param int $language_id
     * @return array|Collection
     */
    public function getParameters(int $product_id, int $language_id): array|Collection
    {
        $result = [];
        $parameterGroups = ProductParameterGroup::with([
            'translation' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'params' => function ($query) use ($product_id) {
                $query->where('product_id', $product_id)
                    ->orderBy('param_order');
            }])
            ->get();

        $parameters = ProductParameter::where('product_id', $product_id)
            ->where('product_group_id', null)
            ->orderBy('param_order')
            ->get();

        foreach ($parameters as $parameter) {
            $parameter->type = [
                'value' => $parameter->type,
                'name' => ParameterType::fromInt($parameter->type)
            ];
            $parameter->is_primary = boolval($parameter->is_primary);
        }

        $result[] = [
            'title' => null,
            'items' => $parameters,
        ];

        foreach ($parameterGroups as $group) {
            $params = [];

            foreach ($group->params as $parameter) {
                $parameter->type = [
                    'value' => $parameter->type,
                    'name' => ParameterType::fromInt($parameter->type)
                ];
                $parameter->is_primary = boolval($parameter->is_primary);

                $params[] = $parameter;
            }

            $result[] = [
                'title' => $group->translation ? $group->translation->value : '',
                'items' => $params,
            ];
        }

        return $result;
    }

    /**
     * @param int $product_id
     * @param array $warehouses
     * @return bool
     */
    public function addWarehouseCount(int $product_id, array $warehouses): bool
    {
        foreach ($warehouses['count'] as $warehouse) {
            $price = null;
            $count = null;

            if (array_key_exists('price', $warehouse)) {
                $price = $warehouse['price'];
            }

            if (array_key_exists('value', $warehouse)) {
                $count = $warehouse['value'];
            }

            ProductWarehouse::where('product_id', $product_id)
                ->where('warehouse_id', $warehouse['warehouseId'])
                ->delete();

            ProductWarehouse::create([
                'product_id' => $product_id,
                'warehouse_id' => $warehouse['warehouseId'],
                'product_count' => $count,
                'product_price' => $price,
            ]);
        }

        return true;
    }

    /**
     * @param int $product_id
     * @param array $data
     * @return bool
     */
    public function addWarehousePacked(int $product_id, array $data): bool
    {
        $productData = ProductData::where('product_id', $product_id)->first();

        if ($productData) {
            $productData->deliverable_weight_kg = $data['packed_weight'];
            $productData->deliverable_width_cm = $data['packed_width'];
            $productData->deliverable_height_cm = $data['packed_height'];
            $productData->deliverable_volume_cm = $data['packed_volume'];

            $productData->save();
        }

        return true;
    }

    /**
     * @param int $product_id
     * @return array
     */
    public function getWarehousePacked(int $product_id): array
    {
        $productData = ProductData::where('product_id', $product_id)->first();

        return [
            'packedWeight' => $productData ? $productData->deliverable_weight_kg : null,
            'packedWidth' => $productData ? $productData->deliverable_width_cm : null,
            'packedHeight' => $productData ? $productData->deliverable_height_cm : null,
            'packedVolume' => $productData ? $productData->deliverable_volume_cm : null,
        ];
    }

    /**
     * @param int $product_id
     * @param int $language_id
     * @return array|Collection
     */
    public function getWarehouseCount(int $product_id, int $language_id): array|Collection
    {
        return ProductWarehouse::with([
            'warehouse.translation' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'warehouse.times',
            'warehouse.group.translation' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'product'
        ])
            ->where('product_id', $product_id)
            ->get();
    }

    /**
     * @return array|Collection
     */
    public function getWarehouseDelivers(): array|Collection
    {
        return Warehouse::with([
            'translations',
            'times',
            'group.translations',
        ])
            ->where('type', 3)
            ->get();
    }

    /**
     * @param $locale
     * @param $id
     * @return JsonResponse
     */
    public function getCompareList($locale, $id): JsonResponse
    {
        $comparison_products = $this->compareProducts($locale, $id);

        return response()->json([
            'comparing' => [
                'id' => $id,
                'products' => $comparison_products['products'],
                'urls' => $comparison_products['urls']
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCompare(Request $request): JsonResponse
    {
        if($request['id']){
            $product_comparison = (new ActiveProductComparison)->where('id', $request['id'])->first();
            if(!$product_comparison){
                $product_comparison = new ActiveProductComparison();
                $product_comparison->save();
            }
        } else {
            $product_comparison = new ActiveProductComparison();
            $product_comparison->save();
        }

        $product_comparison_product = (new ActiveProductComparisonsProduct())->where('comparison_id', $product_comparison->id)->where('product_id', $request['product_id'])->first();
        if(!$product_comparison_product){
            $product_comparison_product = new ActiveProductComparisonsProduct();
            $product_comparison_product->comparison_id = $product_comparison->id;
            $product_comparison_product->product_id = $request['product_id'];
            $product_comparison_product->save();
        }

        if(isset($product_comparison) && $product_comparison) {
            $comparison_products = $this->compareProducts($request['locale'], $product_comparison->id);
        }


        return response()->json([
            'comparing' => [
                'id' => isset($product_comparison) && $product_comparison ? $product_comparison->id : null,
                'products' => isset($comparison_products) ? $comparison_products['products'] : [],
                'urls' => isset($comparison_products) ? $comparison_products['urls'] : null
            ],
            'message' => 'product_compare_list_updated'
        ]);
    }

    /**
     * @param $locale
     * @param $id
     * @param $product_id
     * @return JsonResponse
     */
    public function removeProductFromProductCompare($locale, $id, $product_id): JsonResponse
    {
        if($locale && $id && $product_id){
            $product_comparison = (new ActiveProductComparison)->where('id', $id)->first();
            if($product_comparison){
                $product_comparison_product = (new ActiveProductComparisonsProduct())->where('comparison_id', $product_comparison->id)->where('product_id', $product_id)->first();
                if($product_comparison_product){
                    $product_comparison_product->delete();

                    $product_comparison_first_product = (new ActiveProductComparisonsProduct())->where('comparison_id', $product_comparison->id)->first();
                    if(!$product_comparison_first_product){
                        $product_comparison->delete();
                        $product_comparison = null;
                    }
                }
            }
        }

        if(isset($product_comparison) && $product_comparison) {
            $comparison_products = $this->compareProducts($locale, $product_comparison->id);
        }


        return response()->json([
            'comparing' => [
                'id' => isset($product_comparison) && $product_comparison ? $product_comparison->id : null,
                'products' => isset($comparison_products) ? $comparison_products['products'] : [],
                'urls' => isset($comparison_products) ? $comparison_products['urls'] : null
            ],
            'message' => 'product_compare_list_updated'
        ]);
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function deleteProductCompare($id): JsonResponse
    {
        if($id){
            $product_comparison = (new ActiveProductComparison)->where('id', $id)->first();
            if($product_comparison){
                (new ActiveProductComparisonsProduct())->where('comparison_id', $product_comparison->id)->delete();

                $product_comparison->delete();
            }
        }

        return response()->json([
            'comparing' => [
                'id' => null,
                'products' => [],
                'urls' => null
            ],
            'message' => 'product_compare_list_removed'
        ]);
    }

    /**
     * @param $locale
     * @param $id
     * @return array
     */
    protected function compareProducts($locale, $id): array
    {
        $language = (new Language)->where('locale', $locale)->first();

        $products = [];
        $comparison_products = (new ActiveProductComparisonsProduct())->where('comparison_id', $id)->get(['product_id']);
        if($comparison_products->count() > 0){
            foreach($comparison_products as $comparison_product){
                $language_product = (new LanguagePage())->where('page_id', $comparison_product->product_id)->where('language_id', $language->id)->first(['id', 'page_id', 'name', 'slug', 'featured_image']);

                $product = [
                    'id' => $language_product->page_id,
                    'name' => $language_product->name,
                    'slug' => ($language->primary ? '/' : '/' . $language->locale . '/') . $language_product->slug,
                    'image' => $language_product->featured_image,
                ];
                $products[] = $product;
            }
        }

        $language_comparison_page = (new LanguagePage())->where('type', 'product_compare')->where('language_id', $language->id)->first(['slug']);

        $urls = [
            'comparison_url' => ($language->primary ? '/' : '/' . $language->locale . '/') . $language_comparison_page->slug,
        ];

        return [
            'products' => $products,
            'urls' => $urls
        ];
    }

    /**
     * @param $locale
     * @param $id
     * @return JsonResponse
     */
    public function getCart($locale, $id): JsonResponse
    {
        $cart_products = $this->cartProducts($locale, $id, true);

        return response()->json([
            'cart' => [
                'id' => $id,
                'total' => number_format($cart_products['total'],2),
                'currency' => '€',
                'products' => $cart_products['products'],
                'urls' => $cart_products['urls']
            ],
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function addToCart(Request $request): JsonResponse
    {
        if($request['id']) {
            $cart = (new ActiveCart)->where('id', $request['id'])->first();

            if(!$cart) {
                $cart = new ActiveCart();
                $cart->save();
            }
        } else {
            $cart = new ActiveCart();
            $cart->save();
        }

        $cart_product = (new ActiveCartsProduct())->where('cart_id', $cart->id)->where('product_id', $request['product_id'])->first();
        if(!$cart_product){
            $cart_product = new ActiveCartsProduct();
            $cart_product->cart_id = $cart->id;
            $cart_product->product_id = $request['product_id'];
            $cart_product->qty = $request['qty'];
        } else {
            $cart_product->qty = $cart_product->qty + $request['qty'];
        }
        $cart_product->save();

        if(isset($cart) && $cart){
            $cart_products = $this->cartProducts($request['locale'], $cart->id, true);
        }

        return response()->json([
            'cart' => [
                'id' => isset($cart) && $cart ? $cart->id : null,
                'total' => isset($cart_products) ? number_format($cart_products['total'],2) : null,
                'currency' => '€',
                'products' => isset($cart_products) ? $cart_products['products'] : [],
                'urls' => isset($cart_products) ? $cart_products['urls'] : null
            ],
            'message' => 'cart_updated'
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function updateProductQuantity(Request $request): JsonResponse
    {
        if($request['locale'] && $request['id'] && $request['product_id'] && $request['qty']){
            $cart = (new ActiveCart)->where('id', $request['id'])->first();
            if($cart) {
                $cart_product = (new ActiveCartsProduct())->where('cart_id', $cart->id)->where('product_id', $request['product_id'])->first();
                if($cart_product){
                    $cart_product->qty = $request['qty'];
                    $cart_product->save();
                }
            }
        }

        if(isset($cart) && $cart){
            $cart_products = $this->cartProducts($request['locale'], $cart->id, false);
        }

        return response()->json([
            'cart' => [
                'id' => isset($cart) && $cart ? $cart->id : null,
                'total' => isset($cart_products) ? number_format($cart_products['total'],2) : null,
                'currency' => '€',
                'products' => isset($cart_products) ? $cart_products['products'] : []
            ],
            'message' => 'cart_updated'
        ]);
    }

    /**
     * @param $locale
     * @param $id
     * @param $product_id
     * @return JsonResponse
     */
    public function removeFromCart($locale, $id, $product_id): JsonResponse
    {
        if ($locale && $id && $product_id) {
            $cart = (new ActiveCart)->where('id', $id)->first();
            if($cart) {
                $cart_product = (new ActiveCartsProduct())->where('cart_id', $cart->id)->where('product_id', $product_id)->first();
                if ($cart_product) {
                    $cart_product->delete();

                    $cart_first_product = (new ActiveCartsProduct())->where('cart_id', $cart->id)->first();
                    if(!$cart_first_product){
                        $cart->delete();
                    }
                }
            }
        }

        if(isset($cart) && $cart){
            $cart_products = $this->cartProducts($locale, $cart->id, false);
        }

        return response()->json([
            'cart' => [
                'id' => isset($cart) && $cart ? $cart->id : null,
                'total' => isset($cart_products) ? number_format($cart_products['total'],2) : null,
                'currency' => '€',
                'products' => isset($cart_products) ? $cart_products['products'] : [],
            ],
            'message' => 'cart_updated'
        ]);
    }

    /**
     * @param $locale
     * @param $id
     * @param $get_urls
     * @return array
     */
    protected function cartProducts($locale, $id, $get_urls): array
    {
        $language = (new Language)->where('locale', $locale)->first();

        $products = [];
        $total = 0;
        $cart_products = (new ActiveCartsProduct())->where('cart_id', $id)->get(['product_id', 'qty']);
        if($cart_products->count() > 0){
            foreach($cart_products as $cart_product){
                $language_product = (new LanguagePage())->where('page_id', $cart_product->product_id)->where('language_id', $language->id)->first(['id', 'page_id', 'name', 'slug', 'featured_image']);
                $product_data = (new ProductData())->where('product_id', $language_product->id)->first(['price', 'special_price']);

                $product = [
                    'id' => $language_product->page_id,
                    'name' => $language_product->name,
                    'slug' => ($language->primary ? '/' : '/' . $language->locale . '/') . $language_product->slug,
                    'image' => $language_product->featured_image,
                    'qty' => $cart_product->qty,
                    'price' => $product_data->special_price ? $product_data->special_price : $product_data->price,
                    'old_price' => $product_data->special_price ? $product_data->price : null,
                    'discount' => $product_data->special_price ? ceil(($product_data->price - $product_data->special_price)/$product_data->price *100) : null
                ];
                $products[] = $product;

                $total += $product['price'] * $product['qty'];
            }
        }

        $urls = null;
        if($get_urls) {
            $language_cart_page = (new LanguagePage())->where('type', 'cart')->where('language_id', $language->id)->first(['slug']);
            $language_checkout_page = (new LanguagePage())->where('type', 'checkout')->where('language_id', $language->id)->first(['slug']);

            $urls = [
                'cart_url' => ($language->primary ? '/' : '/' . $language->locale . '/') . $language_cart_page->slug,
                'checkout_url' => ($language->primary ? '/' : '/' . $language->locale . '/') . $language_checkout_page->slug
            ];
        }

        return [
            'products' => $products,
            'total' => $total,
            'urls' => $urls
        ];
    }

    /**
     * @param string $locale
     * @param int $page_id
     * @param Request $request
     * @return JsonResponse
     */
    public function getCategoryProductsAPI(string $locale, int $page_id, Request $request): JsonResponse
    {
        $language = Language::where('locale', $locale)->first();
        $products = $this->getCategoryProducts($language->id, $page_id, explode(',', $request->filters));
        $page = LanguagePage::where('page_id', $page_id)
            ->where('language_id', $language->id)
            ->first();
        $breadcrumbs = (new ApplicationController())->getBreadcrumbs($page, $language, $language->locale);

        return response()->json([
            'products' => $products,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }

    /**
     * @param int $language_id
     * @param int $page_id
     * @param array $filterIDs
     * @return Collection|array
     */
    public function getCategoryProducts(int $language_id, int $page_id, array $filterIDs = []): Collection|array
    {
        $products = Page::with([
            'languagePage' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'attributes',
            'languagePage.data',
            'languagePage.data.category',
            'warehouses.warehouse.times',
            'warehouses.warehouse.translation' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
            'warehouses.warehouse.group.translation' => function ($query) use ($language_id) {
                $query->where('language_id', $language_id);
            },
        ])
            ->whereHas('languagePage.data.category', function ($query) use ($page_id) {
                $parentIds = Page::where('parent_id', $page_id)
                    ->select('id')
                    ->get()
                    ->toArray();

                if ($parentIds) {
                    $parentIds = array_map(function ($scope) {
                        return $scope['id'];
                    }, $parentIds);

                    foreach ($parentIds as $parentId) {
                        $tmp_parentIds = Page::where('parent_id', $parentId)
                            ->select('id')
                            ->get()
                            ->toArray();

                        if ($tmp_parentIds) {
                            $tmp_parentIds = array_map(function ($scope) {
                                return $scope['id'];
                            }, $tmp_parentIds);

                            $parentIds = array_merge($parentIds, $tmp_parentIds);
                        }
                    }
                }

                $parentIds[] = $page_id;

                $query->whereIn('product_category_id', $parentIds);
            })
            ->where('type', 'product');

        if (sizeof($filterIDs) > 0 && $filterIDs[0] !== '') {
            $products->whereHas('attributes', function ($query) use ($filterIDs) {
                $query->whereIn('attribute_value_id', $filterIDs);
            });
        }

        $products = $products->get();

        foreach ($products as $product) {
            $labels = [];
            $label_ids = (new ProductLabelLabel)->where('product_data_id', $product->languagePage->data->id)->pluck('product_label_id')->toArray();
            $_labels = (new ProductLabel)->whereIn('id', $label_ids)->get(['id', 'key']);
            foreach ($_labels as $_label) {
                $label_language = (new ProductLabelLanguage)->where('label_id', $_label->id)->where('language_id', $language_id)->first(['name']);

                $labels[] = ['name' => $label_language->name, 'key' => $_label->key,];
            }

            $product->labels = $labels;
            $product->manufacturer = (new LanguagePage)->where('page_id', $product->languagePage->data->manufacturer_id)
                ->first(['id', 'name', 'featured_image', 'slug']);
        }

        return $products;
    }

    /**
     * @param int $language_id
     * @return array
     */
    public function getProductCategories(int $language_id): array
    {
        $product_categories = [];

        $_product_categories = (new Page)->where('parent_id', null)
            ->where('type', 'product_category')
            ->where('show_in_pages', 1)
            ->with(['pages' => function ($q) {
                $q->where('show_in_pages', 1);
                $q->select('id', 'parent_id', 'type');
                    $q->with(['pages' => function ($q) {
                        $q->where('show_in_pages', 1);
                        $q->select('id', 'parent_id', 'type');
                    }]);
        }])->get(['id', 'parent_id', 'type']);
        foreach ($_product_categories as $product_category) {
            $language_page = (new LanguagePage)
                ->where('page_id', $product_category->id)
                ->where('language_id', $language_id)
                ->first([
                    'id',
                    'name',
                    'type',
                    'slug',
                ]);

            $language_sub_pages = [];
            foreach ($product_category->pages as $sub_page) {
                $language_sub_page = (new LanguagePage)
                    ->where('page_id', $sub_page->id)
                    ->where('language_id', $language_id)
                    ->first([
                        'id',
                        'name',
                        'type',
                        'slug',
                    ]);

                $language_sub_sub_pages = [];
                foreach ($sub_page->pages as $sub_sub_page) {
                    $language_sub_sub_page = (new LanguagePage)
                        ->where('page_id', $sub_sub_page->id)
                        ->where('language_id', $language_id)
                        ->first([
                            'id',
                            'name',
                            'type',
                            'slug',
                        ]);

                    $language_sub_sub_pages[] = [
                        'value' => $sub_sub_page->id,
                        'name' => $language_sub_sub_page ? $language_sub_sub_page->name : 'NO RECORD IN SELECTED LANGUAGE',
                        'slug' => $language_sub_sub_page ? $language_sub_sub_page->slug : 'NO RECORD IN SELECTED LANGUAGE',
                    ];
                }

                $language_sub_pages[] = [
                    'value' => $sub_page->id,
                    'name' => $language_sub_page ? $language_sub_page->name : 'NO RECORD IN SELECTED LANGUAGE',
                    'sub' => $language_sub_sub_pages,
                    'slug' => $language_sub_page ? $language_sub_page->slug : 'NO RECORD IN SELECTED LANGUAGE',
                ];
            }

            $product_categories[] = [
                'value' => $product_category->id,
                'name' => $language_page ? $language_page->name : 'NO RECORD IN SELECTED LANGUAGE',
                'sub' => $language_sub_pages,
                'slug' => $language_page ? $language_page->slug : 'NO RECORD IN SELECTED LANGUAGE',
            ];
        }

        return $product_categories;
    }

    /**
     * @param int $page_id
     * @param int $language_id
     * @return Collection|array
     */
    public function getDownloadFiles(int $language_id, int $page_id): Collection|array
    {
        return ProductDownload::with(['translation' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        },])
            ->where('product_id', $page_id)
            ->get();
    }

    /**
     * @param int $language_id
     * @param int $page_id
     * @return JsonResponse
     */
    public function getDownloadFilesAPI(int $language_id, int $page_id): JsonResponse
    {
        $files = $this->getDownloadFiles($language_id, $page_id);

        return response()->json($files);
    }

    /**
     * @param int $page_id
     * @param Request $request
     * @return JsonResponse
     */
    public function createDownloadFile(int $page_id, Request $request): JsonResponse
    {
        $storage_path = '/public/uploads/pages/products/files' . $page_id . '/';

        if (!Storage::fileExists($storage_path)) {
            Storage::makeDirectory($storage_path);
        }

        if (!str_contains($request->input('file'), 'data:text') && !str_contains($request->input('file'), 'data:application')) {
            return response()->json([
                'success' => false,
                'file' => null,
            ], 400);
        }

        $image_data = base64_decode(substr($request->input('file'), strpos($request->input('file'), ',') + 1));
        $translation_key = 'download_file_'.$request->input('file_order');

        Storage::disk('public')
            ->put('uploads/pages/products/files' . $page_id . '/' . $request->input('file_name'), $image_data);

        $file = ProductDownload::create([
            'product_id' => $page_id,
            'file_order' => $request->input('file_order'),
            'translation_key' => $translation_key,
            'file_path' => '/storage/uploads/pages/products/files' . $page_id . '/' . $request->input('file_name')
        ]);

        return response()->json([
            'success' => true,
            'file' => $file,
        ]);
    }

    /**
     * @param int $language_id
     * @param int $page_id
     * @param Request $request
     * @return JsonResponse
     */
    public function updateDownloadFiles(int $language_id, int $page_id, Request $request): JsonResponse
    {
        $files = $request->input('files');

        foreach ($files as $file) {
            $gallery_image = ProductDownload::where('id', $file['id'])->first();

            $gallery_image->file_order = $file['file_order'];
            $gallery_image->save();

            $translation = Translation::where('language_id', $language_id)
                ->where('key', 'download_file_'.$file['file_order'])
                ->first();

            if ($translation) {
                $translation->value = is_null($file['value']) ? '' : $file['value'];
                $translation->save();
            } else {
                Translation::create([
                    'language_id' => $language_id,
                    'key' => 'download_file_'.$file['file_order'],
                    'value' => is_null($file['value']) ? '' : $file['value']
                ]);
            }
        }

        $files = ProductDownload::with(['translation' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        },])
            ->where('product_id', $page_id)
            ->get();

        return response()->json($files);
    }

    /**
     * @param int $page_id
     * @param int $id
     * @return JsonResponse
     */
    public function deleteDownloadFile(int $page_id, int $id): JsonResponse
    {
        $storage_path = '/public/uploads/pages/products/files' . $page_id . '/';

        $download = ProductDownload::where('id', $id)->first();
        Translation::where('key', 'download_file_'.$download->file_order)->delete();

        ProductDownload::where('id', $id)->delete();

        $files = ProductDownload::where('product_id', $page_id)->get();

        if ($files->count() === 0) {
            Storage::deleteDirectory($storage_path, true);
        }

        return response()->json([
            'success' => true
        ]);
    }

    /**
     * @param int $language_id
     * @param int $page_id
     * @return JsonResponse
     */
    public function getProducts(int $language_id, int $page_id): JsonResponse
    {
        $products = Page::with(['languagePage' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        }])
            ->whereNot('id', $page_id)
            ->where('type', 'product')
            ->get();

        return response()->json($products);
    }

    /**
     * @param int $product_id
     * @param int $language_id
     * @param string $type
     * @return JsonResponse
     */
    public function getProductRelations(int $product_id, int $language_id, string $type): JsonResponse
    {
        $relation_type = ProductRelationType::from($type)->toInt();
        $relations = ProductRelation::with(['relatedProduct.languagePage' => function ($query) use ($language_id) {
            $query->where('language_id', $language_id);
        }])
            ->where('product_id', $product_id)
            ->where('type', $relation_type)
            ->get();

        return response()->json([
            'relations' => $relations,
            'success' => true,
        ]);
    }

    /**
     * @param int $product_id
     * @param Request $request
     * @return JsonResponse
     */
    public function createProductRelation(int $product_id, Request $request): JsonResponse
    {
        $relation = ProductRelation::create([
            'type' => ProductRelationType::from($request->input('type'))->toInt(),
            'product_id' => $product_id,
            'related_product_id' => $request->input('related_product_id'),
        ]);

        return response()->json([
            'success' => true,
            'relation' => $relation,
        ]);
    }

    /**
     * @param int $page_id
     * @param int $related_product_id
     * @return JsonResponse
     */
    public function deleteProductRelation(int $page_id, int $related_product_id): JsonResponse
    {
        ProductRelation::where('product_id', $page_id)
            ->where('related_product_id', $related_product_id)
            ->delete();

        return response()->json([
            'success' => true,
        ]);
    }
}
