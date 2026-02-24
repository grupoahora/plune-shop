<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Contracts\Session\Session;

class CategoryDeletionUndoManager
{
    private const SESSION_KEY = 'categories.deleted';

    public function storeDeletedCategory(Session $session, Category $category): string
    {
        $undoToken = (string) str()->uuid();

        $session->put(self::SESSION_KEY, [
            'token' => $undoToken,
            'deleted_at' => now()->toIso8601String(),
            'category' => [
                'name' => $category->name,
                'icon' => $category->icon,
                'sort_order' => $category->sort_order,
            ],
        ]);

        return $undoToken;
    }

    public function consumeDeletedCategory(Session $session, string $undoToken): ?array
    {
        $deletedCategory = $session->get(self::SESSION_KEY);

        if (! is_array($deletedCategory)) {
            return null;
        }

        if (($deletedCategory['token'] ?? null) !== $undoToken) {
            return null;
        }

        $session->forget(self::SESSION_KEY);

        return is_array($deletedCategory['category'] ?? null)
            ? $deletedCategory['category']
            : null;
    }
}
