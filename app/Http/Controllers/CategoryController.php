<?php

namespace App\Http\Controllers;

use App\Actions\Categories\CategoryUndoManager;
use App\Http\Requests\CategoryUndoDeletionRequest;
use App\Models\Category;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    private const INDEX_CACHE_KEY = 'categories.index';

    public function __construct(private CategoryUndoManager $categoryUndoManager) {}

    public function index(): Response
    {
        $allowedIcons = config('categories.allowed_icons', []);

        $categories = Cache::remember(self::INDEX_CACHE_KEY, now()->addMinutes(10), function (): array {
            return Category::query()
                ->orderBy('sort_order')
                ->get(['id', 'name', 'icon', 'sort_order'])
                ->map(function (Category $category): array {
                    return [
                        'id' => $category->id,
                        'name' => $category->name,
                        'icon' => $category->icon,
                        'sort_order' => $category->sort_order,
                    ];
                })
                ->all();
        });

        return Inertia::render('categories/Index', [
            'categories' => $categories,
            'iconOptions' => $allowedIcons,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'icon' => ['required', 'string', 'max:255', Rule::in(config('categories.allowed_icons', []))],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $category = Category::query()->create($validated);
        $this->forgetCategoriesIndexCache();

        $undoToken = $this->categoryUndoManager->storeCreatedCategory($request->session(), $category);

        return back()->with('toast', [
            'type' => 'success',
            'title' => 'Categoría creada',
            'description' => 'Puedes deshacer esta acción.',
            'undoToken' => $undoToken,
        ]);
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$category->id],
            'icon' => ['required', 'string', 'max:255', Rule::in(config('categories.allowed_icons', []))],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $undoToken = $this->categoryUndoManager->storeUpdatedCategory($request->session(), $category);

        $category->update($validated);
        $this->forgetCategoriesIndexCache();

        return back()->with('toast', [
            'type' => 'success',
            'title' => 'Categoría actualizada',
            'description' => 'Puedes deshacer esta acción.',
            'undoToken' => $undoToken,
        ]);
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $undoToken = $this->categoryUndoManager->storeDeletedCategory($request->session(), $category);

        $category->delete();
        $this->forgetCategoriesIndexCache();

        return back()->with('toast', [
            'type' => 'warning',
            'title' => 'Categoría eliminada',
            'description' => 'Puedes deshacer esta acción.',
            'undoToken' => $undoToken,
        ]);
    }

    public function undoDestroy(CategoryUndoDeletionRequest $request): RedirectResponse
    {
        $undoData = $this->categoryUndoManager->consumeUndoPayload(
            $request->session(),
            $request->string('undo_token')->toString(),
        );

        if (! is_array($undoData)) {
            return back()->with('toast', [
                'type' => 'error',
                'title' => 'No se pudo deshacer',
                'description' => 'La acción de deshacer ya expiró o no es válida.',
            ]);
        }

        $operation = $undoData['operation'] ?? null;

        if ($operation === 'delete' && is_array($undoData['category'] ?? null)) {
            Category::query()->create($undoData['category']);
            $this->forgetCategoriesIndexCache();

            return back()->with('toast', [
                'type' => 'success',
                'title' => 'Categoría restaurada',
                'description' => 'La categoría fue restaurada correctamente.',
            ]);
        }

        if ($operation === 'create') {
            $categoryId = $undoData['category_id'] ?? null;

            if (is_int($categoryId)) {
                Category::query()->whereKey($categoryId)->delete();
                $this->forgetCategoriesIndexCache();

                return back()->with('toast', [
                    'type' => 'success',
                    'title' => 'Creación deshecha',
                    'description' => 'La categoría creada se eliminó correctamente.',
                ]);
            }
        }

        if ($operation === 'update' && is_array($undoData['category'] ?? null)) {
            $categoryId = $undoData['category_id'] ?? null;

            if (is_int($categoryId)) {
                Category::query()->whereKey($categoryId)->update($undoData['category']);
                $this->forgetCategoriesIndexCache();

                return back()->with('toast', [
                    'type' => 'success',
                    'title' => 'Edición deshecha',
                    'description' => 'Se restauraron los datos anteriores de la categoría.',
                ]);
            }
        }

        return back()->with('toast', [
            'type' => 'error',
            'title' => 'No se pudo deshacer',
            'description' => 'La acción de deshacer ya expiró o no es válida.',
        ]);
    }

    private function forgetCategoriesIndexCache(): void
    {
        Cache::forget(self::INDEX_CACHE_KEY);
    }
}
