<?php

namespace App\Http\Controllers;

use App\Actions\Categories\CategoryUndoManager;
use App\Actions\Categories\GetCategoryCursorPage;
use App\Http\Requests\CategoryUndoDeletionRequest;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CategoryController extends Controller
{
    public function __construct(
        private CategoryUndoManager $categoryUndoManager,
        private GetCategoryCursorPage $getCategoryCursorPage,
    ) {}

    public function index(): Response
    {
        $categoryPage = $this->getCategoryCursorPage->execute(null);

        return Inertia::render('categories/Index', $categoryPage);
    }

    public function cursor(Request $request): JsonResponse
    {
        $categoryPage = $this->getCategoryCursorPage->execute(
            $request->string('cursor')->toString() ?: null,
        );

        return response()->json($categoryPage);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'icon' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $category = Category::query()->create($validated);

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
            'icon' => ['required', 'string', 'max:255'],
            'sort_order' => ['required', 'integer', 'min:0'],
        ]);

        $undoToken = $this->categoryUndoManager->storeUpdatedCategory($request->session(), $category);

        $category->update($validated);

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
}
