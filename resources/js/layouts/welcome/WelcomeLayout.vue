<script setup lang="ts">
import WelcomeFooter from '@/components/welcome/WelcomeFooter.vue';
import WelcomeHeader from '@/components/welcome/WelcomeHeader.vue';
import { withDefaults } from 'vue';
import type { Product } from '@/types';

withDefaults(
    defineProps<{
        canResetPassword: boolean;
        resolvedAppearance: string;
        products?: Product[];
    }>(),
    {
        products: () => [],
    },
);

const emit = defineEmits<{
    setAppearance: [value: 'light' | 'dark'];
}>();
</script>

<template>
    <div
        class="min-h-screen overflow-x-hidden bg-[#F8F3FB] text-[#2B1338] transition-colors duration-300 dark:bg-[#2A1535] dark:text-white"
    >
        <div class="flex min-h-screen w-full flex-col">
            <WelcomeHeader
                :can-reset-password="canResetPassword"
                :resolved-appearance="resolvedAppearance"
                :products="products"
                @set-appearance="emit('setAppearance', $event)"
            />
            <main class="flex-1">
                <slot />
            </main>
            <WelcomeFooter />
        </div>
    </div>
</template>
