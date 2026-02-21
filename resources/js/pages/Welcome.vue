<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import WelcomeBenefitsSection from '@/components/welcome/WelcomeBenefitsSection.vue';
import WelcomeHeroSection from '@/components/welcome/WelcomeHeroSection.vue';
import WelcomeProductsSection from '@/components/welcome/WelcomeProductsSection.vue';
import WelcomeSubscribeSection from '@/components/welcome/WelcomeSubscribeSection.vue';
import { useAppearance } from '@/composables/useAppearance';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import type { AppPageProps, Product } from '@/types';

const { resolvedAppearance, updateAppearance } = useAppearance();

const setAppearance = (value: 'light' | 'dark') => {
    updateAppearance(value);
};

withDefaults(
    defineProps<{
        canRegister: boolean;
        canResetPassword: boolean;
        status?: string;
        page?: AppPageProps;
        products: Product[];
    }>(),
    {
        canRegister: true,
        canResetPassword: false,
    },
);
</script>

<template>
    <Head title="Plune Cosmetics | Organic Hair Care">
        
    </Head>

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-green-600"
    >
        {{ status }}
    </div>

    <WelcomeLayout
        :can-reset-password="canResetPassword"
        :resolved-appearance="resolvedAppearance"
        @set-appearance="setAppearance"
    >
        <WelcomeHeroSection />
        <WelcomeBenefitsSection />
        <WelcomeProductsSection :products="products" />
        <WelcomeSubscribeSection />
    </WelcomeLayout>
</template>

<style scoped>
:global(body) {
    font-family: 'Manrope', sans-serif;
}
</style>
