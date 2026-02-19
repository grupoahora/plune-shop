<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import CatalogMainContent from '@/components/catalog/CatalogMainContent.vue';
import CatalogSidebar from '@/components/catalog/CatalogSidebar.vue';
import { useAppearance } from '@/composables/useAppearance';
import WelcomeLayout from '@/layouts/welcome/WelcomeLayout.vue';
import type { CatalogCategory, CatalogProduct } from '@/types/catalog';

const categories: CatalogCategory[] = [
    { id: 1, name: 'Champús', icon: 'spa', active: true },
    { id: 2, name: 'Acondicionadores', icon: 'water_drop' },
    { id: 3, name: 'Cremas de Peinar', icon: 'brush' },
    { id: 4, name: 'Tratamientos', icon: 'eco' },
];

const products: CatalogProduct[] = [
    {
        id: 1,
        name: 'Champoo Jamaica',
        tag: 'Natural & Orgánico',
        category: 'Revitalizante',
        rating: 4,
        reviews: 42,
        price: '$22.00',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuBnNpk4eULBLe91tTUIvGy_fg-pvtY4ix5ERq5_NwkqpS73WQaSHQSbbP-xrRWhacBBogULv6P7W0J7ZQzvvqOl61OZfDAXdLrR9sqwzq9uSfKvoTQ9-47SRUcyRzcvcDXyI4IgUTxp1vwstKImDXGbhdDQaXemP8CfyN5D-sds1EfDezk3mnfeiN0NM7wrMI5Ew4uSDkpJWBr_y5euzhnm66CyH5S5H-wY75b_mv03ns1oAeFjSc0eBNAmeW3JQef00VZ6vzc4sbfl',
    },
    {
        id: 2,
        name: 'Acondicionador Almendras',
        tag: 'Natural & Orgánico',
        category: 'Hidratación Profunda',
        rating: 5,
        reviews: 128,
        price: '$18.50',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuD_rcDuguU9GxMUJ6rm6xBZJNPLHInk469iwFDn5miayYz0lKL8IRYLA_hQgPFcmep2do9aAuMvXUeziGepAUv2Id90yH9pSaqq7O6fuT_TDLft9Hcl0NRlPefO7wL2bvzMJLCBiG5Fg6nWNxaj-a5Ud80wkAc1j6WNhpebrgbMWB8UJqO3YjQa9tz5vkNcPEDFi0mJnwsGIRcWcOAQKnoT5pgV81c7xJWAJJPUd9-gRdX2kP6nMKysvvUzTJExl1ct0sp4-N-DNLWA',
    },
    {
        id: 3,
        name: 'Mascarilla de Argán',
        tag: 'Natural & Orgánico',
        category: 'Nutrición Intensiva',
        rating: 5,
        reviews: 89,
        price: '$25.00',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuADAtFn4G7Qp4xA6jYB3hfRyWLh4i0yVxJoR8w0JEEJ_lcbmCLD58lTQ4uqlv7fWw1YTRvLBHNrPBpcNcJ2Kn7sqQxCn1tXxJg3DBfS9d8TiVcNXyxw8rVxQJ5shpQ2Q0Ldc6dr9q15S9J3I5z1iS6V1Rfl6j-ZGMz_2-4M89hZLhGhCtdESVZzI7Y4_wFYYkbb9vI0RcONgrYOCikYnq0kA27yqA7cxp16asEy2xmErd_8fQjfrp2SLk2f-D_zaSIC1p3xRjg',
    },
    {
        id: 4,
        name: 'Serum Reparador de Puntas',
        tag: 'Natural & Orgánico',
        category: 'Reparación',
        rating: 4,
        reviews: 56,
        price: '$19.90',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuCe5vqWgmj1T3TQ4h5GQp9SZx3tkxQF2TRHf-2uB1biDd5iYg4W1g53JX7N0u0sTV5Dxq4A8Yxv5q6Sx6U8rPrxqit9hM9r0Dx9aQvR6vB6R9n6owfYDErLwTBqW2S3D3nWVNcRVDJ6I1N_tMk8uQdLrMD0h-KfQ8k0xzBq4A4vQnqD3i8hYw3hT6U0p6QeQq3a2a0yxVf8yQ',
    },
    {
        id: 5,
        name: 'Tónico Capilar Anticaída',
        tag: 'Natural & Orgánico',
        category: 'Fortalecimiento',
        rating: 5,
        reviews: 214,
        price: '$15.00',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuAt8HTrVRoqgfv35OwT7gBrS0TfWUqm_rd0lrXg_BwWug55bmD2DE06H4JvNNNVUcsNkCe2CtliyluvgDi8hOaE587XH8YLHz_VeM8bbIs0WrJ2YTgvZcIne8xYke-qGn4Ou5VViwTRFg0MuAfP1D1ilf4tzz5wROOPSmu0T_zRJ0-TW6aTmkumckWqXiAcKS1QJB7i3UIMyvKLOJ9NqQdQ7RDa7MjJsuowxqea6Cz-MJUQsYkk2JJU7ZvrmIykLv9BBkcxvRMPxjLi',
    },
    {
        id: 6,
        name: 'Crema de Peinar Coco & Karité',
        tag: 'Natural & Orgánico',
        category: 'Definición y Suavidad',
        rating: 4,
        reviews: 73,
        price: '$17.40',
        image: 'https://lh3.googleusercontent.com/aida-public/AB6AXuA9TqzP2v6dh7aNnY2vS9r7pX8xW7q9k8J1L6S6rK7YxE4R6z6Y9mJ9D5V6c2N4B0H8S6T8Y3wJ9P6mS5jL4wQ2a3V8rN6tQ7yF2D3kL7xM9rD2V5jQ8tN6gH7cL1pR4bT9dF0jK2mQ4x',
    },
];

const { resolvedAppearance, updateAppearance } = useAppearance();

const setAppearance = (value: 'light' | 'dark') => {
    updateAppearance(value);
};

withDefaults(
    defineProps<{
        canResetPassword: boolean;
    }>(),
    {
        canResetPassword: false,
    },
);
</script>

<template>
    <Head title="Catálogo de Productos | Plune">
        <link
            href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap"
            rel="stylesheet"
        />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet"
        />
    </Head>

    <WelcomeLayout
        :can-reset-password="canResetPassword"
        :resolved-appearance="resolvedAppearance"
        @set-appearance="setAppearance"
    >
        <main class="flex-1 px-6 py-8 md:px-20 lg:px-40">
            <nav
                class="mb-8 flex items-center gap-2 text-sm font-medium text-[#61896f] dark:text-primary/60"
            >
                <a class="transition-colors hover:text-primary" href="#"
                    >Inicio</a
                >
                <span class="material-symbols-outlined text-xs"
                    >chevron_right</span
                >
                <span class="text-[#111813] dark:text-white"
                    >Catálogo de Cuidado Capilar</span
                >
            </nav>
            <div class="flex flex-col gap-12 lg:flex-row">
                <CatalogSidebar :categories="categories" />
                <CatalogMainContent :products="products" />
            </div>
        </main>
    </WelcomeLayout>
</template>

<style scoped>
:global(body) {
    font-family: 'Manrope', sans-serif;
}

.material-symbols-outlined {
    font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24;
}

.filled-icon {
    font-variation-settings:
        'FILL' 1,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24;
}
</style>
