<?php

namespace App\Http\Controllers;

use App\Models\ActiveCart;
use App\Models\ActiveCartProduct;
use App\Models\LanguagePage;
use App\Models\ProductData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $identifier = Auth::check() ? null : Session::getId();

        $cart = ActiveCart::firstOrCreate(
            ['session_id' => $identifier, 'user_id' => Auth::id()],
            ['user_id' => Auth::id()]
        );

        $cartProduct = ActiveCartProduct::updateOrCreate(
            ['cart_id' => $cart->id, 'product_id' => $request->product_id],
            ['qty' => DB::raw('qty + ' . $request->qty)]
        );

        return response()->json(['message' => 'Product added to cart']);
    }

    public function increaseQuantity(Request $request)
    {
        $identifier = Auth::check() ? null : Session::getId();
        $cart = ActiveCart::where('session_id', $identifier)->where('user_id', Auth::id())->firstOrFail();

        $cartProduct = ActiveCartProduct::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();
        $cartProduct->increment('qty', $request->qty ?? 1);

        return response()->json(['message' => 'Quantity increased']);
    }

    public function decreaseQuantity(Request $request)
    {
        $identifier = Auth::check() ? null : Session::getId();
        $cart = ActiveCart::where('session_id', $identifier)->where('user_id', Auth::id())->firstOrFail();

        $cartProduct = ActiveCartProduct::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();
        $newQty = $cartProduct->qty - ($request->qty ?? 1);

        if ($newQty > 0) {
            $cartProduct->update(['qty' => $newQty]);
            return response()->json(['message' => 'Quantity decreased']);
        } elseif ($newQty == 0) {
            $cartProduct->delete();
            return response()->json(['message' => 'Product removed from cart']);
        } else {
            return response()->json(['message' => 'Invalid quantity'], 400);
        }
    }

    public function getCartItems(Request $request)
    {
        $identifier = Auth::check() ? null : Session::getId();
        $cart = ActiveCart::where('session_id', $identifier)->where('user_id', Auth::id())->first();

        $cartDetails = [];

        if ($cart) {
            $cartItems = ActiveCartProduct::where('cart_id', $cart->id)->get();

            foreach ($cartItems as $item) {
                $product = LanguagePage::where('page_id', $item->product_id)->first(['id', 'name', 'featured_image', 'slug']);
                if ($product) {
                    $productData = ProductData::where('product_id', $product->id)->first(['id', 'product_id', 'sku', 'price', 'special_price', 'manufacturer_id']);
                    $manufacturer = LanguagePage::where('page_id', $productData->manufacturer_id)->first(['id', 'name', 'featured_image']);

                    $cartDetails[] = [
                        'product_id' => $item->product_id,
                        'name' => $product->name,
                        'image' => $product->featured_image,
                        'slug' => $product->slug,
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
        }
        return response()->json(['cart_items' => $cartDetails]);
    }

    public function removeFromCart(Request $request)
    {
        $identifier = Auth::check() ? null : Session::getId();
        $cart = ActiveCart::where('session_id', $identifier)->where('user_id', Auth::id())->firstOrFail();

        $cartProduct = ActiveCartProduct::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();

        $cartProduct->delete();

        return response()->json(['message' => 'Product removed from cart']);
    }

    public function updateQuantity(Request $request)
    {
        $identifier = Auth::check() ? null : Session::getId();
        $cart = ActiveCart::where('session_id', $identifier)->where('user_id', Auth::id())->firstOrFail();

        $cartProduct = ActiveCartProduct::where('cart_id', $cart->id)
            ->where('product_id', $request->product_id)
            ->firstOrFail();
        $newQuantity = $request->qty;

        if ($newQuantity > 0) {
            $cartProduct->qty = $newQuantity;
            $cartProduct->save();
            return response()->json(['message' => 'Quantity updated']);
        }

        return response()->json(['message' => 'Invalid quantity'], 400);
    }
}
