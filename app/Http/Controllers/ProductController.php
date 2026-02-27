<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Laravel\Fortify\Features;

class ProductController extends Controller
{
    public function home(): Response
    {
        return Inertia::render('Welcome', [
            'canRegister' => Features::enabled(Features::registration()),
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'products' => Product::query()->where('status', true)->get(),
        ]);
    }

    public function index(Request $request): Response
    {
        $searchTerm = trim((string) $request->query('search', ''));

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
            ->orderBy('name')
            ->get()
            ->map(fn (Product $product): array => $this->catalogProductData($product))
            ->all();

        return Inertia::render('Catalogo', [
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'categories' => Category::query()->orderBy('sort_order')->get(['id', 'name', 'icon']),
            'products' => $products,
            'search' => $searchTerm,
        ]);
    }

    public function search(ProductSearchRequest $request): RedirectResponse
    {
        $searchTerm = trim($request->string('search')->toString());

        $product = Product::query()
            ->where('status', true)
            ->where(function ($query) use ($searchTerm): void {
                $query
                    ->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('product_code', 'like', "%{$searchTerm}%");
            })
            ->orderBy('name')
            ->first();

        if ($product instanceof Product) {
            return to_route('products.show', $product);
        }

        return to_route('catalogo', ['search' => $searchTerm])->with('toast', [
            'type' => 'warning',
            'title' => 'Sin resultados',
            'description' => 'No encontramos un producto con ese criterio de búsqueda.',
        ]);
    }

    public function show(Product $product): Response
    {
        $product->load('images');

        return Inertia::render('ProductoDetalle', [
            'canResetPassword' => Features::enabled(Features::resetPasswords()),
            'product' => $this->catalogProductData($product),
        ]);
    }

    /**
     * @return array<string, int|string>
     */
    private function catalogProductData(Product $product): array
    {
        return [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'tag' => 'Natural & Orgánico',
            'category' => 'Cuidado Capilar',
            'rating' => 5,
            'reviews' => 0,
            'price' => '$'.number_format((float) $product->price_sale, 2),
            'productCode' => $product->product_code,
            'image' => $product->images->first()->url ?? 'https://images.unsplash.com/photo-1556228578-dd8c4c6d3f23?auto=format&fit=crop&w=1200&q=80',
        ];
    }
}
