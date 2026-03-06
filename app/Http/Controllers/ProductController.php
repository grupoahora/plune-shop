<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class ProductController extends Controller
{
    public function home(): Response
    {
        $allProducts = Product::query()->where('status', true)->get();
        $products = Product::query()
            ->with('images')
            ->where('status', true)
            ->orderBy('name')
            ->get()
            ->map(fn(Product $product): array => $this->catalogProductData($product))
            ->all();
        return Inertia::render('Welcome', [
            'canRegister' => Features::enabled(Features::registration()),
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'products' => $products,
            'allProducts' => $allProducts,
        ]);
    }

    public function index(Request $request): Response
    {
        
        $selectedCategoryId = $this->resolveSelectedCategoryId($request);
        $searchTerm = trim((string) $request->query('search', ''));

        if ($selectedCategoryId !== null) {
            $searchTerm = '';
        }

        $products = Product::query()
            ->with('images')
            ->where('status', true)
            ->when($searchTerm !== '', function ($query) use ($searchTerm): void {
                $query->where(function ($subQuery) use ($searchTerm): void {
                    $subQuery
                        ->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('product_code', 'like', "%{$searchTerm}%");
                });
            })
            ->when($selectedCategoryId !== null, function ($query) use ($selectedCategoryId): void {
                $query->where('category_id', $selectedCategoryId);
            })
            ->orderBy('name')
            ->get()
            ->map(fn(Product $product): array => $this->catalogProductData($product))
            ->all();
        
        return Inertia::render('Catalogo', [
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'categories' => fn () => Category::query()->orderBy('sort_order')->get(['id', 'name', 'icon']),
            'products' => $products,
            'allProducts' => fn () => Product::query()->where('status', true)->get(),
            'search' => $searchTerm,
            'selectedCategoryId' => $selectedCategoryId,
        ]);
    }

    public function search(ProductSearchRequest $request): RedirectResponse
    {
        $searchTerm = trim($request->string('search')->toString());

        $hasMatchingProducts = Product::query()
            ->where('status', true)
            ->where(function ($query) use ($searchTerm): void {
                $query
                    ->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('product_code', 'like', "%{$searchTerm}%");
            })
            ->exists();

        if ($hasMatchingProducts) {
            return to_route('catalogo', ['search' => $searchTerm]);
        }

        return to_route('catalogo', ['search' => $searchTerm])->with('toast', [
            'type' => 'warning',
            'title' => 'Sin resultados',
            'description' => 'No encontramos un producto con ese criterio de búsqueda.',
        ]);
    }

    public function show(Product $product): Response
    {
        
        $allProducts = Product::query()->where('status', true)->get();
        return Inertia::render('ProductoDetalle', [
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'product' => $this->catalogProductData($product),
            'allproducts' => $allProducts,
        ]);
    }

    /**
     * @return array<string, int|string>
     */
    private function catalogProductData(Product $product): array
    {
        $product->load('images', 'category', 'tags');
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'tag' => 'Natural & Orgánico',
            'category' => $product->category->name ?? 'Sin categoría',
            'rating' => 5,
            'reviews' => 0,
            'price' => '$'.number_format((float) $product->price_sale, 2),
            'productCode' => $product->product_code,
            'image' => $product->images->first() ? '/storage/' . $product->images->first()->url : 'https://images.unsplash.com/photo-1556228578-dd8c4c6d3f23?auto=format&fit=crop&w=1200&q=80',
        ];
    }


    

    private function resolveSelectedCategoryId(Request $request): ?int
    {
        $requestedCategoryId = $request->query('category');

        if ($requestedCategoryId === null || $requestedCategoryId === '') {
            return null;
        }

        $categoryId = filter_var($requestedCategoryId, FILTER_VALIDATE_INT);

        if ($categoryId === false) {
            return null;
        }

        return Category::query()->whereKey($categoryId)->exists() ? $categoryId : null;
    }
}
