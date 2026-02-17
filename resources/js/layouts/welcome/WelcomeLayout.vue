<script setup lang="ts">
import WelcomeFooter from '@/components/welcome/WelcomeFooter.vue';
import WelcomeHeader from '@/components/welcome/WelcomeHeader.vue';

defineProps<{
    canResetPassword: boolean;
    resolvedAppearance: string;
}>();

const emit = defineEmits<{
    setAppearance: [value: 'light' | 'dark'];
}>();
</script>

<template>
    <div
        class="min-h-screen overflow-x-hidden bg-[#f6f8f6] text-[#111813] transition-colors duration-300 dark:bg-[#102216] dark:text-white"
    >
        <div class="flex min-h-screen w-full flex-col">
            <WelcomeHeader
                :can-reset-password="canResetPassword"
                :resolved-appearance="resolvedAppearance"
                @set-appearance="emit('setAppearance', $event)"
            />
            <main class="flex-1">
                <slot />
            </main>
            <WelcomeFooter />
        </div>
    </div>
</template>
