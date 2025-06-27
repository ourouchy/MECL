<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductListResource;
use App\Http\Resources\ProductResource;
use App\Models\Api\Product;
use App\Models\ProductCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perPage = request('per_page', 10);
        $search = request('search', '');
        $sortField = request('sort_field', 'created_at');
        $sortDirection = request('sort_direction', 'desc');

        // Convert stock filters
        $inStock = request()->has('in_stock') && request('in_stock') === '1';
        $outOfStock = request()->has('out_of_stock') && request('out_of_stock') === '1';

        $query = Product::query()->where('title', 'like', "%{$search}%");

        if ($inStock && !$outOfStock) {
            $query->where('quantity', '>', 0);
        } elseif (!$inStock && $outOfStock) {
            $query->where('quantity', '=', 0);
        }

        // ✅ Price Filtering
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

        if ($minPrice !== null && $maxPrice !== null) {
            $query->whereBetween('price', [$minPrice, $maxPrice]);
        } elseif ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        } elseif ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }
        $sizes = request('sizes');
        if ($sizes) {
            $sizeIds = explode(',', $sizes);
            $query->whereHas('sizes', function($q) use ($sizeIds) {
                $q->whereIn('sizes.id', $sizeIds);
            });
        }
        // Sorting
        $query->orderBy($sortField, $sortDirection);

        return ProductListResource::collection($query->paginate($perPage));
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->validated();
        $data['created_by'] = $request->user()->id;
        $data['updated_by'] = $request->user()->id;

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $categories = $data['categories'] ?? [];

        $product = Product::create($data);

        $this->saveCategories($categories, $product);
        $this->saveImages($images, $imagePositions, $product);
        if (isset($data['sizes']) && is_array($data['sizes'])) {
            $sizeData = [];

            foreach ($data['sizes'] as $size) {
                if ($size['id'] === null) {
                    $newSize = \App\Models\Size::create(['name' => $size['name']]);
                    $size['id'] = $newSize->id;
                }

                $sizeData[$size['id']] = [
                    'price' => $size['price'],
                    'stock' => $size['stock'],
                    'original_price' => $size['original_price'] ?? null,
                ];
            }

            $product->sizes()->sync($sizeData);
        }
        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return response()->json([
            'product' => new ProductResource($product->load('brand')),
            'sizes' => $product->sizes()->get([
                'sizes.id',
                'sizes.name',
                'product_size.price',
                'product_size.stock',
                'product_size.original_price'
            ]),
            'images' => $product->images()->get(['id', 'url', 'position']) // ✅ Keep images in response
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product      $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $data = $request->validated();
        if ($request->user()) {
            $data['updated_by'] = $request->user()->id;
        }
        // If sizes exist and product price is empty, compute a fallback.
        if ((empty($data['price']) || $data['price'] == 0) && isset($data['sizes']) && is_array($data['sizes']) && count($data['sizes']) > 0) {
            // Option 1: Use the lowest size price as the default product price
            $prices = array_map(function($size) {
                return (float) $size['price'];
            }, $data['sizes']);
            $data['price'] = min($prices);

            // Option 2: Alternatively, use the first size price:
            // $data['price'] = (float) $data['sizes'][0]['price'];
        }

        /** @var \Illuminate\Http\UploadedFile[] $images */
        $images = $data['images'] ?? [];
        $deletedImages = $data['deleted_images'] ?? [];
        $imagePositions = $data['image_positions'] ?? [];
        $categories = $data['categories'] ?? [];

        $this->saveCategories($categories, $product);
        $this->saveImages($images, $imagePositions, $product);
        if (count($deletedImages) > 0) {
            $this->deleteImages($deletedImages, $product);
        }

        $product->update($data);

        // Update sizes (also create new sizes if needed)
        if (isset($data['sizes']) && is_array($data['sizes'])) {
            $sizeData = [];
            foreach ($data['sizes'] as $size) {
                if ($size['id'] === null) {
                    // Create new size if necessary
                    $newSize = \App\Models\Size::create(['name' => $size['name']]);
                    $size['id'] = $newSize->id;
                }
                $sizeData[$size['id']] = [
                    'price' => $size['price'],
                    'stock' => $size['stock'],
                    'original_price' => $size['original_price'] ?? null,
                ];
            }
            $product->sizes()->sync($sizeData);
        }

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->noContent();
    }

    private function saveCategories($categoryIds, Product $product)
    {
        ProductCategory::where('product_id', $product->id)->delete();
        $data = array_map(fn($id) => (['category_id' => $id, 'product_id' => $product->id]), $categoryIds);

        ProductCategory::insert($data);
    }

    /**
     *
     *
     * @param UploadedFile[] $images
     * @return string
     * @throws \Exception
     */
    private function saveImages($images, $positions, Product $product)
    {
        foreach ($positions as $id => $position) {
            ProductImage::query()
                ->where('id', $id)
                ->update(['position' => $position]);
        }

        foreach ($images as $id => $image) {
            $path = 'images/' . Str::random();
            if (!Storage::exists($path)) {
                Storage::makeDirectory($path, 0755, true);
            }
            $name = Str::random().'.'.$image->getClientOriginalExtension();
            if (!Storage::putFileAS('public/' . $path, $image, $name)) {
                throw new \Exception("Unable to save file \"{$image->getClientOriginalName()}\"");
            }
            $relativePath = $path . '/' . $name;

            ProductImage::create([
                'product_id' => $product->id,
                'path' => $relativePath,
                'url' => URL::to(Storage::url($relativePath)),
                'mime' => $image->getClientMimeType(),
                'size' => $image->getSize(),
                'position' => $positions[$id] ?? $id + 1
            ]);
        }
    }

    private function deleteImages($imageIds, Product $product)
    {
        $images = ProductImage::query()
            ->where('product_id', $product->id)
            ->whereIn('id', $imageIds)
            ->get();

        foreach ($images as $image) {
            // If there is an old image, delete it
            if ($image->path) {
                Storage::deleteDirectory('/public/' . dirname($image->path));
            }
            $image->delete();
        }
    }


}
