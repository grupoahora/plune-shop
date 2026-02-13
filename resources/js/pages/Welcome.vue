<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { Moon, Sun } from 'lucide-vue-next';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Sheet, SheetClose, SheetContent, SheetDescription, SheetFooter, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { useAppearance } from '@/composables/useAppearance';
import { dashboard, login, register } from '@/routes';

const { resolvedAppearance, updateAppearance } = useAppearance();

const setAppearance = (value: 'light' | 'dark') => {
    updateAppearance(value);
};

withDefaults(
    defineProps<{
        canRegister: boolean;
    }>(),
    {
        canRegister: true,
    },
);
</script>

<template>

    <Head title="Plune Cosmetics | Organic Hair Care">
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    </Head>

    <div
        class="min-h-screen overflow-x-hidden bg-[#f6f8f6] text-[#111813] transition-colors duration-300 dark:bg-[#102216] dark:text-white">
        <div class="flex min-h-screen w-full flex-col">
            <header
                class="sticky top-0 z-50 flex items-center justify-between border-b border-solid border-[#dbe6df] bg-[#f6f8f6] px-6 py-4 whitespace-nowrap lg:px-20 dark:border-[#2a3a2e] dark:bg-[#102216]">
                <div class="flex items-center gap-12">
                    <div class="flex items-center gap-3">
                        <div class="size-8 text-[#13ec5b]">
                            <svg fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-extrabold tracking-tight">
                            Plune
                        </h2>
                    </div>
                    <nav class="hidden items-center gap-10 md:flex">
                        <a class="text-sm font-semibold transition-colors hover:text-[#13ec5b]" href="#">Shop</a>
                        <a class="text-sm font-semibold transition-colors hover:text-[#13ec5b]" href="#">About Us</a>
                        <a class="text-sm font-semibold transition-colors hover:text-[#13ec5b]" href="#">Contact</a>
                    </nav>
                </div>
                <div class="flex flex-1 items-center justify-end gap-6">
                    <nav class="hidden items-center gap-3 lg:flex">
                        <Link v-if="$page.props.auth.user" :href="dashboard()"
                            class="rounded-xl border border-[#dbe6df] px-4 py-2 text-sm font-semibold transition-colors hover:border-[#13ec5b] dark:border-[#2a3a2e]">
                            Dashboard
                        </Link>
                        <template v-else>
                            <Link :href="login()"
                                class="rounded-xl border border-[#dbe6df] px-4 py-2 text-sm font-semibold transition-colors hover:border-[#13ec5b] dark:border-[#2a3a2e]">
                                Log in
                            </Link>
                            <Link v-if="canRegister" :href="register()"
                                class="rounded-xl border border-[#dbe6df] px-4 py-2 text-sm font-semibold transition-colors hover:border-[#13ec5b] dark:border-[#2a3a2e]">
                                Register
                            </Link>
                        </template>
                    </nav>
                    <div
                        class="hidden w-full max-w-xs items-center rounded-xl border border-[#dbe6df] bg-white px-4 py-2 sm:flex dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                        <span class="material-symbols-outlined mr-2 text-[#61896f]">search</span>
                        <input class="w-full border-none bg-transparent text-sm placeholder:text-[#61896f] focus:ring-0"
                            placeholder="Search botanical care..." type="text" />
                    </div>
                    <div class="flex gap-3">
                        <div
                            class="inline-flex items-center gap-1 rounded-xl border border-[#dbe6df] bg-white p-1 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <button type="button" aria-label="Cambiar a modo claro" @click="setAppearance('light')"
                                :class="[
                                    'flex size-8 items-center justify-center rounded-lg transition-all',
                                    resolvedAppearance === 'light'
                                        ? 'bg-[#f0f4f2] text-[#111813] dark:bg-[#2a3a2e] dark:text-white'
                                        : 'text-[#61896f] hover:bg-[#f0f4f2] dark:text-[#a1b8a9] dark:hover:bg-[#2a3a2e]',
                                ]">
                                <Sun class="size-4" />
                            </button>
                            <button type="button" aria-label="Cambiar a modo oscuro" @click="setAppearance('dark')"
                                :class="[
                                    'flex size-8 items-center justify-center rounded-lg transition-all',
                                    resolvedAppearance === 'dark'
                                        ? 'bg-[#f0f4f2] text-[#111813] dark:bg-[#2a3a2e] dark:text-white'
                                        : 'text-[#61896f] hover:bg-[#f0f4f2] dark:text-[#a1b8a9] dark:hover:bg-[#2a3a2e]',
                                ]">
                                <Moon class="size-4" />
                            </button>
                        </div>
                        <button
                            class="flex size-10 items-center justify-center rounded-xl border border-[#dbe6df] bg-white transition-all hover:border-[#13ec5b] dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <span class="material-symbols-outlined text-lg">shopping_cart</span>
                        </button>
                        <Sheet>
                            <SheetTrigger as-child>

                                <Button
                                    class="flex size-10 items-center justify-center rounded-xl border border-[#dbe6df] bg-white transition-all hover:border-[#13ec5b] dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                                    <span class="material-symbols-outlined text-lg">person</span>
                                </Button>
                            </SheetTrigger>
                            <SheetContent>
                                <SheetHeader>
                                    <SheetTitle>Iniciar sesión</SheetTitle>
                                    <SheetDescription>
                                        Ingresa tus credenciales para acceder a tu cuenta.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form class="grid flex-1 auto-rows-min gap-6 px-4" :action="login()" method="get">
                                    <div class="grid gap-3">
                                        <Label for="sheet-login-email">Correo electrónico</Label>
                                        <Input id="sheet-login-email" name="email" type="email"
                                            placeholder="tucorreo@ejemplo.com" autocomplete="email" required />
                                    </div>
                                    <div class="grid gap-3">
                                        <Label for="sheet-login-password">Contraseña</Label>
                                        <Input id="sheet-login-password" name="password" type="password"
                                            placeholder="Ingresa tu contraseña" autocomplete="current-password" required />
                                    </div>
                                    <SheetFooter>
                                        <Button type="submit">
                                            Continuar
                                        </Button>
                                        <SheetClose as-child>
                                            <Button variant="outline">
                                                Cancelar
                                            </Button>
                                        </SheetClose>
                                    </SheetFooter>
                                </Form>
                            </SheetContent>
                        </Sheet>
                    </div>
                </div>
            </header>

            <main class="flex-1">
                <section class="p-4 md:p-10">
                    <div class="relative flex min-h-[520px] flex-col items-start justify-center overflow-hidden rounded-xl bg-cover bg-center px-8 md:px-20"
                        style="
                            background-image:
                                linear-gradient(
                                    rgba(0, 0, 0, 0.4) 0%,
                                    rgba(0, 0, 0, 0.6) 100%
                                ),
                                url('https://lh3.googleusercontent.com/aida-public/AB6AXuAp6m-DKqzXiZwHm8BkSp1Wkg6foXlgZt7r5iOkhs-zpHuIOCN5Z_Mq6GES2FYZcyarjwIhsZngPYw51an0EILIlA2QXWWr7fJkNz1QTRyrXeTMHBQg_pj3rLRewuKEOYMqiu7r2Dd6Oe94jqp-zj5IqbOExPAZ1uV0CxrYildt7YcHyWppVe107OVMe1uzP3WxaPpMK53O9X1fdfjOxVwDlOfX4_eNCPZalgtcPiv8Dozx6Xggkcb6JRk4DkUD5-iSKitfGLv85_Sf');
                        ">
                        <div class="max-w-2xl space-y-6">
                            <span
                                class="inline-block rounded-full border border-[#13ec5b]/30 bg-[#13ec5b]/20 px-4 py-1.5 text-xs font-bold tracking-widest text-[#13ec5b] uppercase">
                                New Collection
                            </span>
                            <h1 class="text-5xl leading-tight font-extrabold tracking-tight text-white md:text-7xl">
                                Pure Nature for <br />
                                Your Hair
                            </h1>
                            <p class="max-w-lg text-lg leading-relaxed font-medium text-gray-200 md:text-xl">
                                Infused with organic rosemary and tea tree for a
                                revitalizing experience. Clean, eco-friendly,
                                and 100% vegan hair care.
                            </p>
                            <div class="flex flex-wrap gap-4 pt-4">
                                <button
                                    class="rounded-xl bg-[#13ec5b] px-8 py-4 font-bold text-[#111813] shadow-lg shadow-[#13ec5b]/20 transition-all hover:-translate-y-1 hover:bg-[#13ec5b]/90">
                                    Shop Collection
                                </button>
                                <button
                                    class="rounded-xl border border-white/30 bg-white/10 px-8 py-4 font-bold text-white backdrop-blur-md transition-all hover:bg-white/20">
                                    Our Story
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="px-6 py-12 md:px-20">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div
                            class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div
                                class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]">
                                <span class="material-symbols-outlined text-3xl">eco</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">100% Organic</h3>
                                <p class="text-sm leading-snug text-[#61896f]">
                                    Certified ingredients sourced responsibly
                                    from nature.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div
                                class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]">
                                <span class="material-symbols-outlined text-3xl">favorite</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">Cruelty-Free</h3>
                                <p class="text-sm leading-snug text-[#61896f]">
                                    No animal testing, ever. Friendly to all
                                    living beings.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div
                                class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]">
                                <span class="material-symbols-outlined text-3xl">psychology_alt</span>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">
                                    Synthetic Free
                                </h3>
                                <p class="text-sm leading-snug text-[#61896f]">
                                    Zero harsh sulfates, parabens, or artificial
                                    dyes.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="px-6 py-16 md:px-20">
                    <div class="mb-12 flex items-end justify-between">
                        <div class="space-y-2">
                            <h2 class="text-4xl font-extrabold tracking-tight">
                                Featured Products
                            </h2>
                            <p class="text-lg font-medium text-[#61896f] dark:text-[#a1b8a9]">
                                Carefully crafted for every hair type.
                            </p>
                        </div>
                        <a class="flex items-center gap-2 font-bold text-[#13ec5b] hover:underline" href="#">
                            View all
                            <span class="material-symbols-outlined">arrow_forward</span>
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div
                            class="group flex flex-col gap-5 rounded-2xl border border-[#dbe6df] bg-white p-2 transition-all hover:-translate-y-2 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-[#f6f8f6]">
                                <img alt="Bottle of tea tree shampoo"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuB6RDUPCNEGgC5kleedp9hsrURYKBD-hKDvM9BUOKTLKT2SLu13UvLo4nWo3qRfJvkCa5SlsWhD-KPh33aZwGQwjCO2V0-9rmtyoa_sB7Aj7QSRS3jmhdemsumJLyTkuWw5rcGZfztDZIoJrPtPfsesQlVBsYc5QNaB-gBI8F3JLa0QczC1wDkg07JY0hRAJ2O44ntzfGuMVFIRZ_iAD9omUZX5XOQq2saS8HJXPGM44XVTNt208U85KQyyJGfwi-Y6ECVNV1AYVz_T" />
                                <div class="absolute top-4 right-4">
                                    <button
                                        class="flex size-10 items-center justify-center rounded-full bg-white/80 text-[#111813] backdrop-blur transition-colors hover:bg-white">
                                        <span class="material-symbols-outlined">favorite</span>
                                    </button>
                                </div>
                            </div>
                            <div class="px-4 pb-4">
                                <div class="mb-2 flex items-start justify-between">
                                    <h3 class="text-xl font-bold transition-colors group-hover:text-[#13ec5b]">
                                        Champoo Árbol de Té
                                    </h3>
                                    <p class="text-lg font-extrabold text-[#111813] dark:text-white">
                                        $25.000
                                    </p>
                                </div>
                                <p class="mb-6 text-sm text-[#61896f] dark:text-[#a1b8a9]">
                                    Deep scalp purification and refreshment for
                                    oily hair types.
                                </p>
                                <button
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#f0f4f2] py-3 font-bold text-[#111813] transition-all hover:bg-[#13ec5b] hover:text-[#111813] dark:bg-[#2a3a2e] dark:text-white">
                                    <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>

                        <div
                            class="group flex flex-col gap-5 rounded-2xl border border-[#dbe6df] bg-white p-2 transition-all hover:-translate-y-2 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-[#f6f8f6]">
                                <img alt="Rosemary shampoo bottle"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuBWIoRRfXR1iGH8nwWOOCetbipXnhkdbj1j_WKIQrVpElFdKFiPNPPlyZPkqfbfCaVUf4BGg_IZt8F22xVTswpb2PQpZa7KvzarSwgy-VdBnNxiXb8S-yHg_mk1ruUNrwo9kUEJ-edWfKZ8gFNk98lU6lzdinOTFkKaMSV72aJX5J7OW2PdHsQ6xn1l4yEv3YuDrk05_WUVlh-u0hj1ZBxoe8LP-_tIPtnyTLpoMWFtwZvlDke_DYVrxP0iTX0J6_kYH_mIhYhAbL0G" />
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="rounded-full bg-[#13ec5b] px-2 py-1 text-[10px] font-black tracking-widest text-[#111813] uppercase">
                                        Bestseller
                                    </span>
                                </div>
                            </div>
                            <div class="px-4 pb-4">
                                <div class="mb-2 flex items-start justify-between">
                                    <h3 class="text-xl font-bold transition-colors group-hover:text-[#13ec5b]">
                                        Champoo Romero
                                    </h3>
                                    <p class="text-lg font-extrabold text-[#111813] dark:text-white">
                                        $25.000
                                    </p>
                                </div>
                                <p class="mb-6 text-sm text-[#61896f] dark:text-[#a1b8a9]">
                                    Enhanced hair strength and stimulated growth
                                    with rosemary extracts.
                                </p>
                                <button
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#f0f4f2] py-3 font-bold text-[#111813] transition-all hover:bg-[#13ec5b] hover:text-[#111813] dark:bg-[#2a3a2e] dark:text-white">
                                    <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>

                        <div
                            class="group flex flex-col gap-5 rounded-2xl border border-[#dbe6df] bg-white p-2 transition-all hover:-translate-y-2 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div class="relative aspect-[4/5] w-full overflow-hidden rounded-xl bg-[#f6f8f6]">
                                <img alt="Solid styling cream bar"
                                    class="h-full w-full object-cover transition-transform duration-500 group-hover:scale-105"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuB1zJllKZcd3WN8nJsBtv_dAJ9BQacGvT76hHlTr3Xz4YDESaLLVuL21orabTUEtS1hIheQPCBPXpkH3afJJZSHSKRAdN0skkJzyxTKy94If1_CBVn25HtKXYxa6SfLMjyFn7rCrEdI9bw7QolSTpDZn3AYYE6TgAvt1bQyC3vPdZkInObIA5MUisNgxORNpgx5hxkquox2Ct9RHTGpTy2J7kTVyJBmIPI0AfFZcpqJu-GGBSQX91oIxqui7EwVHZ5DzC42g4BvVlve" />
                                <div class="absolute top-4 right-4">
                                    <span
                                        class="rounded-full bg-[#111813] px-2 py-1 text-[10px] font-black tracking-widest text-white uppercase">
                                        Eco-Choice
                                    </span>
                                </div>
                            </div>
                            <div class="px-4 pb-4">
                                <div class="mb-2 flex items-start justify-between">
                                    <h3 class="text-xl font-bold transition-colors group-hover:text-[#13ec5b]">
                                        Crema de Peinar Sólida
                                    </h3>
                                    <p class="text-lg font-extrabold text-[#111813] dark:text-white">
                                        $22.000
                                    </p>
                                </div>
                                <p class="mb-6 text-sm text-[#61896f] dark:text-[#a1b8a9]">
                                    Eco-friendly hydration bar for effortless
                                    styling and definition.
                                </p>
                                <button
                                    class="flex w-full items-center justify-center gap-2 rounded-xl bg-[#f0f4f2] py-3 font-bold text-[#111813] transition-all hover:bg-[#13ec5b] hover:text-[#111813] dark:bg-[#2a3a2e] dark:text-white">
                                    <span class="material-symbols-outlined text-sm">add_shopping_cart</span>
                                    Add to Cart
                                </button>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="px-4 pt-10 pb-20">
                    <div
                        class="relative mx-auto max-w-4xl overflow-hidden rounded-3xl bg-[#102216] p-10 text-center md:p-16 dark:bg-[#1a2e20]">
                        <div class="absolute top-0 right-0 p-8 text-[#13ec5b]/10">
                            <span class="material-symbols-outlined text-9xl">energy_savings_leaf</span>
                        </div>
                        <div class="relative z-10 space-y-8">
                            <h2 class="text-3xl font-black tracking-tight text-white md:text-5xl">
                                Join the Green Movement
                            </h2>
                            <p class="mx-auto max-w-lg text-lg text-gray-400">
                                Get 15% off your first order and stay updated
                                with our latest organic hair care rituals.
                            </p>
                            <form class="mx-auto flex max-w-md flex-col gap-4 sm:flex-row">
                                <input
                                    class="flex-1 rounded-xl border-white/20 bg-white/10 px-6 text-white placeholder:text-gray-500 focus:border-[#13ec5b] focus:ring-[#13ec5b]"
                                    placeholder="Your email address" type="email" />
                                <button
                                    class="rounded-xl bg-[#13ec5b] px-8 py-4 font-bold whitespace-nowrap text-[#111813] transition-all hover:bg-[#13ec5b]/90">
                                    Subscribe
                                </button>
                            </form>
                        </div>
                    </div>
                </section>
            </main>

            <footer
                class="border-t border-[#dbe6df] bg-white px-6 py-16 md:px-20 dark:border-[#2a3a2e] dark:bg-[#0c1a11]">
                <div class="grid grid-cols-1 gap-12 md:grid-cols-4">
                    <div class="space-y-6">
                        <div class="flex items-center gap-3">
                            <div class="size-6 text-[#13ec5b]">
                                <svg fill="currentColor" viewBox="0 0 48 48" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M36.7273 44C33.9891 44 31.6043 39.8386 30.3636 33.69C29.123 39.8386 26.7382 44 24 44C21.2618 44 18.877 39.8386 17.6364 33.69C16.3957 39.8386 14.0109 44 11.2727 44C7.25611 44 4 35.0457 4 24C4 12.9543 7.25611 4 11.2727 4C14.0109 4 16.3957 8.16144 17.6364 14.31C18.877 8.16144 21.2618 4 24 4C26.7382 4 29.123 8.16144 30.3636 14.31C31.6043 8.16144 33.9891 4 36.7273 4C40.7439 4 44 12.9543 44 24C44 35.0457 40.7439 44 36.7273 44Z" />
                                </svg>
                            </div>
                            <h2 class="text-xl font-bold tracking-tight">
                                Plune
                            </h2>
                        </div>
                        <p class="text-sm leading-relaxed text-[#61896f]">
                            Botanical hair care rooted in science and nature.
                            100% vegan, eco-friendly, and handmade.
                        </p>
                        <div class="flex gap-4">
                            <a class="flex size-10 items-center justify-center rounded-full border border-[#dbe6df] transition-all hover:bg-[#13ec5b] hover:text-[#111813] dark:border-[#2a3a2e]"
                                href="#">
                                <span class="material-symbols-outlined text-lg">share</span>
                            </a>
                            <a class="flex size-10 items-center justify-center rounded-full border border-[#dbe6df] transition-all hover:bg-[#13ec5b] hover:text-[#111813] dark:border-[#2a3a2e]"
                                href="#">
                                <span class="material-symbols-outlined text-lg">camera_alt</span>
                            </a>
                        </div>
                    </div>

                    <div>
                        <h4 class="mb-6 font-bold">Shop</h4>
                        <ul class="space-y-4 text-sm text-[#61896f]">
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Hair Shampoo</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Solid Care</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Gift Sets</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">New Arrivals</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-6 font-bold">Support</h4>
                        <ul class="space-y-4 text-sm text-[#61896f]">
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Shipping Policy</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Returns & Refunds</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">FAQ</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Track Order</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-6 font-bold">Contact</h4>
                        <ul class="space-y-4 text-sm text-[#61896f]">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">mail</span>
                                hello@plune.com
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">call</span>
                                +57 (300) 123-4567
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-sm">location_on</span>
                                <span>Calle 100 #15-30, Bogotá</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="mt-16 flex flex-col items-center justify-between gap-4 border-t border-[#dbe6df] pt-8 md:flex-row dark:border-[#2a3a2e]">
                    <p class="text-xs text-[#61896f]">
                        © 2024 Plune Cosmetics. All rights reserved.
                    </p>
                    <div class="flex gap-8 text-xs text-[#61896f]">
                        <a class="hover:text-[#13ec5b]" href="#">Privacy Policy</a>
                        <a class="hover:text-[#13ec5b]" href="#">Terms of Service</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>
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
</style>
