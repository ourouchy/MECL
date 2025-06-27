<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::orderBy('name')->get();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Brands', 'url' => null],
        ];
        return view('brands.index', compact('brands', 'breadcrumbs'));
    }

    public function show(Brand $brand)
    {
        $products = $brand->products()
            ->where('published', true)
            ->with(['sizes', 'images'])
            ->latest()
            ->paginate(12); // or whatever you like
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Brands', 'url' => route('brands.index')],
            ['name' => $brand->name, 'url' => null],
        ];
        return view('brands.show', compact('brand', 'products', 'breadcrumbs'));
    }
}
