<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function index()
    {
        [$products, $cartItems] = Cart::getProductsAndCartItems();
        $total = 0;

        // $cartItems is typically a numeric list: [ ['product_id' => ..., 'size_id' => ..., 'quantity' => ... ], ... ]
        // OR it might be keyed. But below, we treat it as a list. Then we sum up the total.
        foreach ($cartItems as $item) {
            $productId = $item['product_id'];
            $sizeId    = $item['size_id'] ?? null;
            $quantity  = $item['quantity'];

            $product = $products->firstWhere('id', $productId);
            if (!$product) {
                continue;
            }
            $price = $product->getPriceBySize($sizeId);

            $total += $price * $quantity;
        }
        $cartProductIds = collect($cartItems)->pluck('product_id')->unique();

        // ✨ Get recommended products excluding those already in cart
        $recommendedProducts = \App\Models\Product::where('published', 1)
            ->whereNotIn('id', $cartProductIds)   // <-- Important line
            ->latest()
            ->take(8)
            ->get();

        return view('cart.index', compact('cartItems', 'products', 'total', 'recommendedProducts'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = (int) $request->post('quantity', 1);
        $sizeId = $request->post('size_id', null);
        $user = $request->user();

        // Validate stock
        if ($product->sizes()->exists()) {
            if (!$sizeId) {
                return response(['message' => 'Please select a size.'], 422);
            }
            $pivot = $product->sizes->where('id', $sizeId)->first();
            if (!$pivot || $pivot->pivot->stock < 1) {
                return response(['message' => 'This size is out of stock.'], 422);
            }
            if ($quantity > $pivot->pivot->stock) {
                return response(['message' => 'Only ' . $pivot->pivot->stock . ' items left for this size.'], 422);
            }
        } else {
            if ($product->quantity < 1) {
                return response(['message' => 'This product is out of stock.'], 422);
            }
            if ($quantity > $product->quantity) {
                return response(['message' => 'Only ' . $product->quantity . ' items left.'], 422);
            }
        }

        if ($user) {
            // Logged-in users (DB cart)
            $cartItem = CartItem::firstOrNew([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'size_id'    => $sizeId,
            ]);

            $cartItem->quantity += $quantity;
            $cartItem->save();

            return response(['count' => Cart::getCartItemsCount()]); // DB is realtime ✅
        } else {
            // Guest (cookie cart)
            $cartItems = Cart::getCookieCartItems();
            $key = $product->id . ':' . ($sizeId ?? '0');

            if (isset($cartItems[$key])) {
                $cartItems[$key]['quantity'] += $quantity;
            } else {
                $cartItems[$key] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'size_id' => $sizeId,
                    'quantity' => $quantity,
                ];
            }

            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);

            return response(['count' => Cart::getCountFromItems($cartItems)]); // 🛠️ use updated array
        }
    }

    public function remove(Request $request, Product $product)
    {
        $sizeId = $request->post('size_id', null);
        $user = $request->user();

        if ($user) {
            CartItem::where([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'size_id'    => $sizeId,
            ])->delete();
        } else {
            $cartItems = Cart::getCookieCartItems();
            $key = $product->id . ':' . ($sizeId ?? '0');
            unset($cartItems[$key]);
            Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
        }

        return response(['success' => true, 'count' => Cart::getCartItemsCount()]);
    }

    public function updateQuantity(Request $request, Product $product)
    {
        $quantity = (int) $request->post('quantity', 1);
        $sizeId = $request->post('size_id', null);
        $user = $request->user();

        // Validate stock
        if ($product->sizes()->exists() && $sizeId) {
            $pivot = $product->sizes->where('id', $sizeId)->first();
            if (!$pivot || $quantity > $pivot->pivot->stock) {
                return response(['message' => 'Only ' . $pivot->pivot->stock . ' items left.'], 422);
            }
        } else {
            if ($quantity > $product->quantity) {
                return response(['message' => 'Only ' . $product->quantity . ' items left.'], 422);
            }
        }

        if ($user) {
            CartItem::where([
                'user_id'    => $user->id,
                'product_id' => $product->id,
                'size_id'    => $sizeId,
            ])->update(['quantity' => $quantity]);
        } else {
            $cartItems = Cart::getCookieCartItems();
            $key = $product->id . ':' . ($sizeId ?? '0');
            if (isset($cartItems[$key])) {
                $cartItems[$key]['quantity'] = $quantity;
                Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
            }
        }

        return response()->json([
            'success' => true,
            'count' => \App\Helpers\Cart::getCartItemsCount(),
        ]);

    }

    public function mini()
    {
        return \App\Helpers\Cart::getMiniCart();
    }

}
