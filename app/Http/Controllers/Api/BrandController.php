<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        return Brand::orderBy('created_at', 'desc')
            ->get()
            ->map(function ($brand) {
                return [
                    'id' => $brand->id,
                    'name' => $brand->name,
                    'image' => $brand->image_url,
                ];
            });    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255|unique:brands,name',
            'slug'  => 'nullable|string|max:255|unique:brands,slug',
            'image' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand = Brand::create($data);

        return response()->json($brand, 201);
    }

    public function show(Brand $brand)
    {
        return response()->json($brand);
    }

    public function update(Request $request, Brand $brand)
    {
        $data = $request->validate([
            'name'  => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'slug'  => 'nullable|string|max:255|unique:brands,slug,' . $brand->id,
            'image' => 'nullable|image|max:2048',
        ]);

        $data['slug'] = $data['slug'] ?? Str::slug($data['name']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('brands', 'public');
        }

        $brand->update($data);

        return response()->json($brand);
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return response()->json(['message' => 'Brand deleted successfully']);
    }
}
