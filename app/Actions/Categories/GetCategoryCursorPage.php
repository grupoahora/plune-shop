<?php

namespace App\Actions\Categories;

use App\Models\Category;
use Illuminate\Pagination\CursorPaginator;

class GetCategoryCursorPage
{
    private const INITIAL_BATCH_SIZE = 10;

    private const NEXT_BATCH_SIZE = 5;

    /**
     * @return array{categories: array<int, array{id: int, name: string, icon: string, sort_order: int}>, categoriesTotal: int, nextCursor: ?string}
     */
    public function execute(?string $cursor): array
    {
        $categoryCursorPage = $this->buildCursorPaginator($cursor);

        return [
            'categories' => $categoryCursorPage->items(),
            'categoriesTotal' => Category::query()->count(),
            'nextCursor' => $categoryCursorPage->nextCursor()?->encode(),
        ];
    }

    private function buildCursorPaginator(?string $cursor): CursorPaginator
    {
        $batchSize = $cursor ? self::NEXT_BATCH_SIZE : self::INITIAL_BATCH_SIZE;

        return Category::query()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->cursorPaginate(
                perPage: $batchSize,
                columns: ['id', 'name', 'icon', 'sort_order'],
                cursorName: 'cursor',
                cursor: $cursor,
            );
    }
}
