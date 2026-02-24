<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Contracts\Session\Session;

class CategoryUndoManager
{
    private const SESSION_KEY = 'categories.deleted';

    public function storeCreatedCategory(Session $session, Category $category): string
    {
        $undoToken = (string) str()->uuid();

        $session->put(self::SESSION_KEY, [
            'token' => $undoToken,
            'operation' => 'create',
            'category_id' => $category->id,
        ]);

        return $undoToken;
    }

    public function storeUpdatedCategory(Session $session, Category $category): string
    {
        $undoToken = (string) str()->uuid();

        $session->put(self::SESSION_KEY, [
            'token' => $undoToken,
            'operation' => 'update',
            'category_id' => $category->id,
            'category' => [
                'name' => $category->name,
                'icon' => $category->icon,
                'sort_order' => $category->sort_order,
            ],
        ]);

        return $undoToken;
    }

    public function storeDeletedCategory(Session $session, Category $category): string
    {
        $undoToken = (string) str()->uuid();

        $session->put(self::SESSION_KEY, [
            'token' => $undoToken,
            'operation' => 'delete',
            'deleted_at' => now()->toIso8601String(),
            'category' => [
                'name' => $category->name,
                'icon' => $category->icon,
                'sort_order' => $category->sort_order,
            ],
        ]);

        return $undoToken;
    }

    public function consumeUndoPayload(Session $session, string $undoToken): ?array
    {
        $deletedCategory = $session->get(self::SESSION_KEY);

        if (! is_array($deletedCategory)) {
            return null;
        }

        if (($deletedCategory['token'] ?? null) !== $undoToken) {
            return null;
        }

        $session->forget(self::SESSION_KEY);

        return is_array($deletedCategory)
            ? $deletedCategory
            : null;
    }
}
