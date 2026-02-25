import { computed, ref, toValue, watch, type MaybeRefOrGetter } from 'vue';

interface UseIncrementalPaginationOptions {
    initialCount?: number;
    incrementCount?: number;
}

export function useIncrementalPagination<T>(
    items: MaybeRefOrGetter<T[]>,
    options: UseIncrementalPaginationOptions = {},
) {
    const initialCount = options.initialCount ?? 10;
    const incrementCount = options.incrementCount ?? 5;

    const visibleCount = ref(initialCount);

    const allItems = computed(() => toValue(items) ?? []);
    const visibleItems = computed(() =>
        allItems.value.slice(0, visibleCount.value),
    );
    const canLoadMore = computed(
        () => visibleCount.value < allItems.value.length,
    );

    const loadMore = () => {
        visibleCount.value = Math.min(
            visibleCount.value + incrementCount,
            allItems.value.length,
        );
    };

    const reset = () => {
        visibleCount.value = initialCount;
    };

    watch(allItems, reset);

    return {
        allItems,
        visibleItems,
        canLoadMore,
        loadMore,
        reset,
    };
}
