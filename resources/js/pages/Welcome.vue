<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import WelcomeBenefitsSection from '@/components/welcome/WelcomeBenefitsSection.vue';
import WelcomeHeroSection from '@/components/welcome/WelcomeHeroSection.vue';
import WelcomeProductsSection from '@/components/welcome/WelcomeProductsSection.vue';
import WelcomeSubscribeSection from '@/components/welcome/WelcomeSubscribeSection.vue';
import { useAppearance } from '@/composables/useAppearance';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import type { AppPageProps, Product } from '@/types';
import type { CatalogProduct } from '@/types/catalog';

const { resolvedAppearance, updateAppearance } = useAppearance();

const setAppearance = (value: 'light' | 'dark') => {
    updateAppearance(value);
};

const props = withDefaults(
    defineProps<{
        canRegister: boolean;
        canResetPassword: boolean;
        status?: string;
        page?: AppPageProps;
        products: CatalogProduct[];
        allProducts: Product[];
    }>(),
    {
        canRegister: true,
        canResetPassword: false,
    },
);
const allproducts: Product[] = props.allProducts as Product[];
</script>

<template>
    <Head title="Plune Cosmetics | Organic Hair Care">
        
    </Head>

    <div
        v-if="status"
        class="mb-4 text-center text-sm font-medium text-muted-foreground dark:text-primary"
    >
        {{ status }}
    </div>

    <WelcomeLayout
        :can-reset-password="canResetPassword"
        :resolved-appearance="resolvedAppearance"
        :products="allproducts"
        @set-appearance="setAppearance"
    >
        <WelcomeHeroSection />
        <WelcomeBenefitsSection />
        <WelcomeProductsSection :products="products" />
        <WelcomeSubscribeSection />
    </WelcomeLayout>
</template>

