<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardProductRequest;
use App\Http\Requests\UpdateDashboardProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;
use Inertia\Response;

class DashboardProductController extends Controller
{
    private const INDEX_CACHE_KEY = 'dashboard.products.index';

    public function index(): Response
    {
        $products = Cache::remember(self::INDEX_CACHE_KEY, now()->addMinutes(10), function (): array {
            return Product::query()
                ->with('category:id,name')
                ->orderBy('name')
                ->get(['id', 'name', 'description', 'product_code', 'price_sale', 'status', 'category_id'])
                ->map(function (Product $product): array {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'product_code' => $product->product_code,
                        'price_sale' => (float) $product->price_sale,
                        'status' => (bool) $product->status,
                        'category_id' => $product->category_id,
                        'category_name' => $product->category?->name ?? 'Sin categoría',
                    ];
                })
                ->all();
        });

        return Inertia::render('products/Index', [
            'products' => $products,
            'categories' => Category::query()->orderBy('sort_order')->get(['id', 'name']),
        ]);
    }

    public function store(StoreDashboardProductRequest $request): RedirectResponse
    {
        Product::query()->create($request->validated());
        $this->forgetProductsIndexCache();

        return back()->with('toast', [
            'type' => 'success',
            'title' => 'Producto creado',
            'description' => 'El producto se creó correctamente.',
        ]);
    }

    public function update(UpdateDashboardProductRequest $request, Product $product): RedirectResponse
    {
        $product->update($request->validated());
        $this->forgetProductsIndexCache();

        return back()->with('toast', [
            'type' => 'success',
            'title' => 'Producto actualizado',
            'description' => 'El producto se actualizó correctamente.',
        ]);
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();
        $this->forgetProductsIndexCache();

        return back()->with('toast', [
            'type' => 'warning',
            'title' => 'Producto eliminado',
            'description' => 'El producto se eliminó correctamente.',
        ]);
    }

    private function forgetProductsIndexCache(): void
    {
        Cache::forget(self::INDEX_CACHE_KEY);
    }
}
