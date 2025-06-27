<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\CategoryTreeResource;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sortField = request('sort_field', 'updated_at');
        $sortDirection = request('sort_direction', 'desc');

        $categories = Category::query()
            ->orderBy($sortField, $sortDirection)
            ->latest()
            ->get();

        return CategoryResource::collection($categories);
    }

    public function getAsTree()
    {
        return Category::getActiveAsTree(CategoryTreeResource::class);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        // Handle image uploads
        if ($request->hasFile('banner_image')) {
            $data['banner_image'] = $request->file('banner_image')->store('categories/banners', 'public');
        }

        if ($request->hasFile('selection_image')) {
            $data['selection_image'] = $request->file('selection_image')->store('categories/selections', 'public');
        }

        $category = Category::create($data);

        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $data = $request->validated();
        $data['updated_by'] = $request->user()->id;

        if ($request->hasFile('banner_image')) {
            // Optionally delete old one: Storage::delete('public/' . $category->banner_image);
            $data['banner_image'] = $request->file('banner_image')->store('categories/banners', 'public');
        }

        if ($request->hasFile('selection_image')) {
            $data['selection_image'] = $request->file('selection_image')->store('categories/selections', 'public');
        }

        $category->update($data);

        return new CategoryResource($category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->noContent();
    }
}
