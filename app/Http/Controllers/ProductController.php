<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductController extends Controller
{
    public function index()
    {
        $query = Product::query()->select('id', 'slug', 'title', 'price', 'original_price', 'quantity', 'brand_id')
            ->with([
                'sizes:id,name',
                'images:id,product_id,url',
            ]);

        // Stock filters
        $inStock = request()->has('in_stock') && request('in_stock') === '1';
        $outOfStock = request()->has('out_of_stock') && request('out_of_stock') === '1';

        if ($inStock && !$outOfStock) {
            $query->where('quantity', '>', 0);
        } elseif (!$inStock && $outOfStock) {
            $query->where('quantity', 0);
        }

        // ✅ Price Filtering
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

        if ($minPrice !== null && $maxPrice !== null) {
            $query->where(function($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice])
                    ->orWhereHas('sizes', function($q2) use ($minPrice, $maxPrice) {
                        $q2->whereBetween('product_size.price', [$minPrice, $maxPrice]);
                    });
            });
        } elseif ($minPrice !== null) {
            $query->where(function($q) use ($minPrice) {
                $q->where('price', '>=', $minPrice)
                    ->orWhereHas('sizes', function($q2) use ($minPrice) {
                        $q2->where('product_size.price', '>=', $minPrice);
                    });
            });
        } elseif ($maxPrice !== null) {
            $query->where(function($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice)
                    ->orWhereHas('sizes', function($q2) use ($maxPrice) {
                        $q2->where('product_size.price', '<=', $maxPrice);
                    });
            });
        }
        $sizes = request('sizes');
        if ($sizes) {
            $sizeIds = explode(',', $sizes);
            $query->whereHas('sizes', function($q) use ($sizeIds) {
                $q->whereIn('sizes.id', $sizeIds);
            });
        }
        $brandIds = request('brands');
        if ($brandIds) {
            $brandIds = explode(',', $brandIds);
            $query->whereIn('brand_id', $brandIds);
        }
        $brands = \App\Models\Brand::orderBy('name')->get(); // ✅ Add this
        $newArrivals = Product::where('published', 1)
            ->where('created_at', '>=', Carbon::now()->subDays(15))
            ->latest()
            ->take(8)
            ->get();
        $discountedProducts = Product::where('published', 1)
            ->whereColumn('original_price', '>', 'price') // Only discounted
            ->orderByDesc('updated_at')
            ->take(8)
            ->get();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'All Products', 'url' => null], // current page, no link
        ];
        return $this->renderProducts(
            $query,
            null,
            Category::where('active', true)
                ->whereNull('parent_id') // 👈 Only main categories
                ->get(),
            $brands,
            $newArrivals,       // 👈 Correct order here
            $discountedProducts,
            $breadcrumbs,
        )
            ;
    }

    public function byCategory(Category $category)
    {
        $categories = Category::getAllChildrenByParent($category);

        $query = Product::query()
            ->select('products.*')
            ->join('product_categories AS pc', 'pc.product_id', 'products.id')
            ->whereIn('pc.category_id', array_map(fn($c) => $c->id, $categories));

        // Stock filters
        $inStock = request()->has('in_stock') && request('in_stock') === '1';
        $outOfStock = request()->has('out_of_stock') && request('out_of_stock') === '1';

        if ($inStock && !$outOfStock) {
            $query->where('quantity', '>', 0);
        } elseif (!$inStock && $outOfStock) {
            $query->where('quantity', 0);
        }

        // ✅ Price Filtering
        $minPrice = request('min_price');
        $maxPrice = request('max_price');

        if ($minPrice !== null && $maxPrice !== null) {
            $query->where(function($q) use ($minPrice, $maxPrice) {
                $q->whereBetween('price', [$minPrice, $maxPrice])
                    ->orWhereHas('sizes', function($q2) use ($minPrice, $maxPrice) {
                        $q2->whereBetween('product_size.price', [$minPrice, $maxPrice]);
                    });
            });
        } elseif ($minPrice !== null) {
            $query->where(function($q) use ($minPrice) {
                $q->where('price', '>=', $minPrice)
                    ->orWhereHas('sizes', function($q2) use ($minPrice) {
                        $q2->where('product_size.price', '>=', $minPrice);
                    });
            });
        } elseif ($maxPrice !== null) {
            $query->where(function($q) use ($maxPrice) {
                $q->where('price', '<=', $maxPrice)
                    ->orWhereHas('sizes', function($q2) use ($maxPrice) {
                        $q2->where('product_size.price', '<=', $maxPrice);
                    });
            });
        }
        $sizes = request('sizes');
        if ($sizes) {
            if (is_array($sizes)) {
                $sizeIds = $sizes; // already an array (coming from mobile)
            } else {
                $sizeIds = explode(',', $sizes); // coming from desktop
            }

            $query->whereHas('sizes', function($q) use ($sizeIds) {
                $q->whereIn('sizes.id', $sizeIds);
            });
        }
        $brandIds = request('brands');
        if ($brandIds) {
            $brandIds = explode(',', $brandIds);
            $query->whereIn('brand_id', $brandIds);
        }

        $brands = \App\Models\Brand::orderBy('name')->get();
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
            ['name' => 'Products', 'url' => route('products.index')],
        ];

// Dynamically climb up the parents
        $parents = [];
        $current = $category->parent;
        while ($current) {
            $parents[] = [
                'name' => $current->name,
                'url' => route('products.byCategory', $current->slug),
            ];
            $current = $current->parent;
        }

// Reverse because we collected bottom-up
        $parents = array_reverse($parents);

// Merge parents into breadcrumbs
        $breadcrumbs = array_merge($breadcrumbs, $parents);

// Finally, add the current category (no URL)
        $breadcrumbs[] = [
            'name' => $category->name,
            'url' => null,
        ];
        return $this->renderProducts(
            $query,
            $category,
            $categories,
            $brands,
            [], // newArrivals
            [], // discountedProducts
            $breadcrumbs,
        );
    }

    public function view(Product $product)
    {
        // Get related products...
        $relatedProducts = Product::where('id', '!=', $product->id)
            ->where('published', true)
            ->whereHas('categories', function ($query) use ($product) {
                $query->whereIn('categories.id', $product->categories->pluck('id'));
            })
            ->with(['sizes', 'images'])
            ->latest()
            ->take(8)
            ->get();

        $newArrivals = Product::where('published', 1)
            ->where('created_at', '>=', Carbon::now()->subDays(15))
            ->latest()
            ->take(8)
            ->get();

        $discountedProducts = Product::where('published', 1)
            ->whereColumn('original_price', '>', 'price')
            ->orderByDesc('updated_at')
            ->take(8)
            ->get();

        // 🧠 Dynamic breadcrumbs
        $breadcrumbs = [
            ['name' => 'Home', 'url' => route('home')],
        ];

        $category = $product->categories->first();
        if ($category) {
            $ancestors = collect([]);
            $current = $category;
            while ($current) {
                $ancestors->prepend([
                    'name' => $current->name,
                    'url' => route('products.byCategory', $current->slug),
                ]);
                $current = $current->parent;
            }
            $breadcrumbs = array_merge($breadcrumbs, $ancestors->all());
        }

        $breadcrumbs[] = ['name' => $product->title, 'url' => null];

        return view('product.view', [
            'product' => $product,
            'sizes' => $product->sizes()->get(['sizes.id', 'sizes.name', 'product_size.price', 'product_size.stock']),
            'relatedProducts' => $relatedProducts,
            'newArrivals' => $newArrivals,
            'discountedProducts' => $discountedProducts,
            'breadcrumbs' => $breadcrumbs,
        ]);
    }



    private function renderProducts(Builder $query, ?Category $category = null, $categories = [], $brands = [], $newArrivals = [], $discountedProducts = [], $breadcrumbs = [])
    {
        $search = request()->get('search');
        $sort = request()->get('sort', '-updated_at');

        if ($sort) {
            $sortDirection = 'asc';
            if ($sort[0] === '-') {
                $sortDirection = 'desc';
            }
            $sortField = preg_replace('/^-?/', '', $sort);
            $query->orderBy($sortField, $sortDirection);
        }

        // 1. Products with filters
        $products = $query
            ->where('published', '=', 1)
            ->where(function ($query) use ($search) {
                $query->where('products.title', 'like', "%$search%")
                    ->orWhere('products.description', 'like', "%$search%");
            })
            ->with('sizes')
            ->paginate(5);

        // 2. Sidebar filters (NEW)
        $sidebarQuery = Product::query()->where('published', 1);

        if ($category) {
            $childCategories = \App\Models\Category::getAllChildrenByParent($category);
            $childCategoryIds = array_map(fn($c) => $c->id, $childCategories);

            $sidebarQuery->whereHas('categories', function($q) use ($childCategoryIds) {
                $q->whereIn('categories.id', $childCategoryIds);
            });
        }

        $allProducts = $sidebarQuery
            ->select('id', 'price', 'brand_id')
            ->with(['sizes:id,name', 'brand:id,name']) // <-- Add 'brand'
            ->get();

// Build a collection of all possible prices
        $prices = collect();
        foreach ($allProducts as $product) {
            if ($product->sizes && $product->sizes->count() > 0) {
                // Product has sizes: use size pivot prices
                foreach ($product->sizes as $size) {
                    if (isset($size->pivot->price)) {
                        $prices->push($size->pivot->price);
                    }
                }
            } else {
                // No sizes: use product default price
                if (isset($product->price)) {
                    $prices->push($product->price);
                }
            }
        }

        $priceRange = [
            'min' => $prices->min() ?? 0,
            'max' => $prices->max() ?? 1000,
        ];

        $sizeIds = $allProducts->pluck('sizes')->flatten()->pluck('id')->unique();
        $availableSizes = \App\Models\Size::whereIn('id', $sizeIds)
            ->withCount(['products as products_count' => function ($query) use ($category) {
                $query->where('published', 1);

                if ($category) {
                    $query->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    });
                }

                // 👇 IMPORTANT: Vérifie qu'ils sont en stock
                if (request()->has('in_stock') && request('in_stock') === '1') {
                    $query->where('quantity', '>', 0);
                }

                if (request()->has('out_of_stock') && request('out_of_stock') === '1') {
                    $query->where('quantity', '=', 0);
                }

                // 👇 IMPORTANT: Applique aussi les filtres de prix si présents
                $minPrice = request('min_price');
                $maxPrice = request('max_price');
                if ($minPrice !== null) {
                    $query->where('products.price', '>=', $minPrice);
                }
                if ($maxPrice !== null) {
                    $query->where('products.price', '<=', $maxPrice);
                }

                // 👇 IMPORTANT: Applique aussi les marques
                $brandIds = request('brands');
                if ($brandIds) {
                    $brandIds = explode(',', $brandIds);
                    $query->whereIn('brand_id', $brandIds);
                }
            }])
            ->get();
        $brandIds = $allProducts->pluck('brand_id')->unique()->filter();
        $availableBrands = \App\Models\Brand::whereIn('id', $brandIds)
            ->withCount(['products' => function ($query) use ($category) {
                $query->where('published', 1);
                if ($category) {
                    $query->whereHas('categories', function ($q) use ($category) {
                        $q->where('categories.id', $category->id);
                    });
                }
            }])
            ->get();
        return view('product.index', [
            'products' => $products,
            'category' => $category,
            'categories' => $categories,
            'brands' => $brands,
            'newArrivals' => $newArrivals,
            'discountedProducts' => $discountedProducts,
            'availableSizes' => $availableSizes,
            'availablePriceRange' => $priceRange,
            'availableBrands' => $availableBrands,
            'breadcrumbs' => $breadcrumbs,

        ]);
    }

}
