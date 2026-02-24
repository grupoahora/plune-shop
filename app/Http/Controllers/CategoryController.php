<?php

namespace App\Http\Controllers;

use App\Actions\Categories\CategoryDeletionUndoManager;
use App\Http\Requests\CategoryUndoDeletionRequest;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(private CategoryDeletionUndoManager $categoryDeletionUndoManager) {}

    public function index(): Response
    {
        return Inertia::render('categories/Index', [
            'categories' => Category::query()->orderBy('sort_order')->get(['id', 'name', 'icon', 'sort_order']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'icon' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        Category::create($validated);

        return back();
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name,'.$category->id],
            'icon' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $category->update($validated);

        return back();
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        $undoToken = $this->categoryDeletionUndoManager->storeDeletedCategory($request->session(), $category);

        $category->delete();

        return back()->with('toast', [
            'type' => 'warning',
            'title' => 'Categoría eliminada',
            'description' => 'Puedes deshacer esta acción.',
            'undoToken' => $undoToken,
        ]);
    }

    public function undoDestroy(CategoryUndoDeletionRequest $request): RedirectResponse
    {
        $deletedCategory = $this->categoryDeletionUndoManager->consumeDeletedCategory(
            $request->session(),
            $request->string('undo_token')->toString(),
        );

        if (! is_array($deletedCategory)) {
            return back()->with('toast', [
                'type' => 'error',
                'title' => 'No se pudo deshacer',
                'description' => 'La acción de deshacer ya expiró o no es válida.',
            ]);
        }

        Category::query()->create($deletedCategory);

        return back()->with('toast', [
            'type' => 'success',
            'title' => 'Categoría restaurada',
            'description' => 'La categoría fue restaurada correctamente.',
        ]);
    }
}
