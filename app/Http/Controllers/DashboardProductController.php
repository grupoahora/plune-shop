<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDashboardProductRequest;
use App\Http\Requests\UpdateDashboardProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class DashboardProductController extends Controller
{
    private const INDEX_CACHE_KEY = 'dashboard.products.index';

    public function index(): Response
    {
        $products = Cache::remember(self::INDEX_CACHE_KEY, now()->addMinutes(10), function (): array {
            return Product::query()
                ->with(['category:id,name', 'images:id,url,imageable_id,imageable_type'])
                ->orderBy('name')
                ->get(['id', 'name', 'description', 'product_code', 'image', 'price_sale', 'status', 'category_id'])
                ->map(function (Product $product): array {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'product_code' => $product->product_code,
                        'image' => $product->images->first() ? '/storage/'.$product->images->first()->url : null,
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
        $validatedData = $request->validated();

        $uploadedImage = $request->file('image');
        unset($validatedData['image'], $validatedData['remove_image']);

        $product = Product::query()->create($validatedData);
        $this->syncProductImage($product, $uploadedImage, false);
        $this->forgetProductsIndexCache();

        return back()->with('toast', [
            'type' => 'success',
            'title' => 'Producto creado',
            'description' => 'El producto se creó correctamente.',
        ]);
    }

    public function update(UpdateDashboardProductRequest $request, Product $product): RedirectResponse
    {
        $validatedData = $request->validated();

        $uploadedImage = $request->file('image');
        $removeImage = (bool) ($validatedData['remove_image'] ?? false);

        unset($validatedData['image'], $validatedData['remove_image']);

        $product->update($validatedData);
        $this->syncProductImage($product, $uploadedImage, $removeImage);
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

    private function syncProductImage(Product $product, ?UploadedFile $uploadedImage, bool $removeImage): void
    {
        $existingImage = $product->images()->first();

        if ($uploadedImage === null && ! $removeImage) {
            return;
        }

        if ($existingImage !== null) {
            $this->deleteStoredImageIfManagedPath($existingImage->url);
            $existingImage->delete();
        }

        if ($uploadedImage === null || $removeImage) {
            return;
        }

        $storedPath = $uploadedImage->store('products', 'public');

        $product->images()->create([
            'url' => $storedPath,
        ]);
    }

    private function deleteStoredImageIfManagedPath(string $storedValue): void
    {
        if (str_starts_with($storedValue, 'http://') || str_starts_with($storedValue, 'https://')) {
            return;
        }

        Storage::disk('public')->delete($storedValue);
    }

    
}
