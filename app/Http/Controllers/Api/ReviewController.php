<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews()->with('user')->latest()->get());
    }

    public function store(Request $request, Product $product)
    {
        $data = $request->validate([
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:2000',
        ]);

        $review = Review::updateOrCreate(
            ['user_id' => $request->user()->id, 'product_id' => $product->id],
            $data
        );

        return new ReviewResource($review);
    }
}
