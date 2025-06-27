<?php

namespace App\Helpers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;

class Cart
{
    public static function getCartItemsCount(): int
    {
        $user = request()->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            return self::getCountFromItems(self::getCookieCartItems());
        }
    }

    public static function getCartItems()
    {
        $user = request()->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->get()
                ->map(fn($item) => [
                    'product_id' => $item->product_id,
                    'size_id' => $item->size_id,
                    'quantity' => $item->quantity,
                ])->toArray();
        } else {
            return array_values(self::getCookieCartItems()); // Flatten for guests
        }
    }

    public static function getCookieCartItems(): array
    {
        $json = request()->cookie('cart_items', '{}');
        $cartItems = json_decode($json, true) ?? [];
        return is_array($cartItems) ? $cartItems : [];
    }

    public static function getCountFromItems(array $items): int
    {
        return array_reduce($items, fn($carry, $item) => $carry + ($item['quantity'] ?? 0), 0);
    }

    public static function moveCartItemsIntoDb()
    {
        $user = request()->user();
        $cartItems = self::getCookieCartItems();
        if (!$user || empty($cartItems)) {
            return;
        }

        foreach ($cartItems as $item) {
            CartItem::updateOrCreate(
                [
                    'user_id'    => $user->id,
                    'product_id' => $item['product_id'],
                    'size_id'    => $item['size_id'],
                ],
                ['quantity' => $item['quantity']]
            );
        }

        // Clear guest cart cookie
        Cookie::queue(Cookie::forget('cart_items'));
    }

    public static function getProductsAndCartItems(): array
    {
        $cartItems = self::getCartItems();
        $productIds = Arr::pluck($cartItems, 'product_id');
        $products = Product::whereIn('id', $productIds)
            ->with(['sizes', 'images'])
            ->get();
        return [$products, $cartItems];
    }


    public static function getMiniCart(): array
    {
        // Get products and raw cart items using your existing helper.
        [$products, $cartItems] = self::getProductsAndCartItems();

        // Map each cart line to a simplified mini-cart item.
        $items = collect($cartItems)->map(function ($line) use ($products) {
            $pId = $line['product_id'];
            $sId = $line['size_id'] ?? null;
            $qty = $line['quantity'] ?? 1;
            $product = $products->firstWhere('id', $pId);
            if (!$product) {
                return null;
            }
            $unitPrice = $product->getPriceBySize($sId);
            return [
                'id'        => $pId . '_' . ($sId ?? 'no'),
                'product_id'=> $pId,
                'size_id'   => $sId,
                'quantity'  => $qty,
                'title'     => $product->title,
                'image'     => $product->image ?: '/img/noimage.png',
                'price'     => $unitPrice,
                'size_name' => $sId ? optional($product->sizes->firstWhere('id', $sId))->name : null,
            ];
        })->filter()->values()->all();

        // Calculate total amount.
        $total = 0;
        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return [
            'items' => $items,
            'total' => number_format($total, 2, '.', '')
        ];
    }
}
