<?php

namespace App\Http\Controllers;

use App\Models\CarouselImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    public function index()
    {
        $carouselImages = CarouselImage::all();
        $products       = Product::all();
        $newArrivals = Product::where('published', 1)
            ->where('created_at', '>=', Carbon::now()->subDays(15))
            ->latest()
            ->take(8)
            ->get();
        return view('welcome', [
            'carouselImages' => $carouselImages,
            'products'       => $products,
            'newArrivals' => $newArrivals,
        ]);    }
}
