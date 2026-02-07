import { useRoute } from 'vue-router';
import type { ComputedRef, DeepReadonly } from 'vue';
import { computed, readonly } from 'vue';

export type UseCurrentUrlReturn = {
    currentUrl: DeepReadonly<ComputedRef<string>>;
    isCurrentUrl: (urlToCheck: string, currentUrl?: string) => boolean;
    whenCurrentUrl: <T, F = null>(
        urlToCheck: string,
        ifTrue: T,
        ifFalse?: F,
    ) => T | F;
};

export function useCurrentUrl(): UseCurrentUrlReturn {
    const route = useRoute();
    const currentUrlReactive = computed(() => route.path);

    function isCurrentUrl(urlToCheck: string, currentUrl?: string) {
        const urlToCompare = currentUrl ?? currentUrlReactive.value;

        if (!urlToCheck.startsWith('http')) {
            return urlToCheck === urlToCompare;
        }

        try {
            const absoluteUrl = new URL(urlToCheck);
            return absoluteUrl.pathname === urlToCompare;
        } catch {
            return false;
        }
    }

    function whenCurrentUrl(
        urlToCheck: string,
        ifTrue: any,
        ifFalse: any = null,
    ) {
        return isCurrentUrl(urlToCheck) ? ifTrue : ifFalse;
    }

    return {
        currentUrl: readonly(currentUrlReactive),
        isCurrentUrl,
        whenCurrentUrl,
    };
}
