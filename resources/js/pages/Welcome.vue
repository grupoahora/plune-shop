<script setup lang="ts">
import { Form, Head, Link } from '@inertiajs/vue3';
import { ChevronsRight, ClipboardPlus, Moon, Search, ShoppingCart, Sun, User } from 'lucide-vue-next';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Sheet, SheetClose, SheetContent, SheetDescription, SheetFooter, SheetHeader, SheetTitle, SheetTrigger } from '@/components/ui/sheet';
import { Spinner } from '@/components/ui/spinner';
import { useAppearance } from '@/composables/useAppearance';
import { dashboard } from '@/routes';
import { store } from '@/routes/login';
import { request } from '@/routes/password';
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
        page?: AppPageProps
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
        <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@200..800&display=swap" rel="stylesheet" />
        <link
            href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap"
            rel="stylesheet" />
    </Head>
    <div v-if="status" class="mb-4 text-center text-sm font-medium text-green-600">
        {{ status }}
    </div>
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
                        <a class="text-sm font-semibold transition-colors hover:text-[#13ec5b]" href="#">Tienda</a>
                        <a class="text-sm font-semibold transition-colors hover:text-[#13ec5b]" href="#">Nosotros</a>
                        <a class="text-sm font-semibold transition-colors hover:text-[#13ec5b]" href="#">Contacto</a>
                    </nav>
                </div>
                <div class="flex flex-1 items-center justify-end gap-6">

                    <div
                        class="hidden w-full max-w-xs items-center rounded-xl border border-[#dbe6df] bg-white px-4 py-2 sm:flex dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                        <Search class="size-4 text-[#61896f]" />
                        <input class="w-full border-none bg-transparent text-sm placeholder:text-[#61896f] focus:ring-0"
                            placeholder="Buscar Champoo...." type="text" />
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
                            <ShoppingCart class="size-5 text-[#111813] dark:text-white" />
                        </button>
                        <Sheet v-if="!$page.props.auth.user">
                            <SheetTrigger as-child>

                                <Button
                                    class="flex size-10 items-center justify-center rounded-xl border border-[#dbe6df] bg-white hover:bg-white transition-all hover:border-[#13ec5b] dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                                    <User class="size-5 text-[#111813] dark:text-white" />
                                </Button>
                            </SheetTrigger>
                            <SheetContent
                                class="border-[#dbe6df] bg-[#f6f8f6] text-[#111813] sm:max-w-md dark:border-[#2a3a2e] dark:bg-[#102216] dark:text-white">
                                <SheetHeader
                                    class="space-y-2 border-b border-[#dbe6df] px-6 pb-4 dark:border-[#2a3a2e]">
                                    <SheetTitle class="text-2xl font-extrabold tracking-tight">Iniciar sesión
                                    </SheetTitle>
                                    <SheetDescription class="text-sm text-[#61896f] dark:text-[#a1b8a9]">
                                        Ingresa tus credenciales para acceder a tu cuenta.
                                    </SheetDescription>
                                </SheetHeader>
                                <Form class="grid flex-1 auto-rows-min gap-6 px-6 py-6" v-bind="store.form()"
                                    :reset-on-success="['password']" v-slot="{ errors, processing }">
                                    <div class="grid gap-3">
                                        <Label class="text-sm font-semibold" for="email">Correo electrónico</Label>
                                        <Input id="email" type="email" name="email" required autofocus :tabindex="1"
                                            autocomplete="email" placeholder="email@example.com"
                                            class="rounded-xl border-[#dbe6df] bg-white focus-visible:border-[#13ec5b] focus-visible:ring-[#13ec5b]/30 dark:border-[#2a3a2e] dark:bg-[#1a2e20]" />
                                        <InputError :message="errors.email" />

                                    </div>
                                    <div class="grid gap-3">
                                        <div class="flex items-center justify-between">
                                            <Label class="text-sm font-semibold" for="password">Contraseña</Label>
                                            <TextLink v-if="canResetPassword" :href="request()" class="text-sm"
                                                :tabindex="5">
                                                Olvidaste tu contraseña?
                                            </TextLink>
                                        </div>

                                        <Input id="password" type="password" name="password" required :tabindex="2"
                                            autocomplete="current-password" placeholder="Password"
                                            class="rounded-xl border-[#dbe6df] bg-white focus-visible:border-[#13ec5b] focus-visible:ring-[#13ec5b]/30 dark:border-[#2a3a2e] dark:bg-[#1a2e20]" />

                                        <InputError :message="errors.password" />

                                    </div>
                                    <div class="flex items-center justify-between">
                                        <Label for="remember" class="flex items-center space-x-3">
                                            <Checkbox id="remember" name="remember" :tabindex="3" />
                                            <span>Recordarme</span>
                                        </Label>
                                    </div>
                                    <SheetFooter class="gap-3 border-t border-[#dbe6df] pt-6 dark:border-[#2a3a2e]">
                                        <Button type="submit" :tabindex="4" :disabled="processing"
                                            data-test="login-button"
                                            class="rounded-xl bg-[#13ec5b] font-bold text-[#111813] transition-all hover:-translate-y-0.5 hover:bg-[#13ec5b]/90">
                                            <Spinner v-if="processing" />
                                            Continuar
                                        </Button>
                                        <SheetClose as-child>
                                            <Button variant="outline"
                                                class="rounded-xl border-[#dbe6df] bg-white font-semibold hover:border-[#13ec5b] dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                                                Cancelar
                                            </Button>
                                        </SheetClose>
                                    </SheetFooter>
                                </Form>
                            </SheetContent>
                        </Sheet>
                    </div>
                    <nav class="hidden items-center gap-3 lg:flex">
                        <Link v-if="$page.props.auth.user && $page?.props.auth.user.roles[0]?.name == 'Administrador'"
                            :href="dashboard()"
                            class="rounded-xl border border-[#dbe6df] px-4 py-2 text-sm font-semibold transition-colors hover:border-[#13ec5b] dark:border-[#2a3a2e]">
                            Dashboard
                        </Link>
                        <Link v-if="$page.props.auth.user && $page?.props.auth.user.roles[0]?.name == 'Cliente'"
                            :href="dashboard()"
                            class="rounded-xl border border-[#dbe6df] px-4 py-2 text-sm font-semibold transition-colors hover:border-[#13ec5b] dark:border-[#2a3a2e]">
                            Mi Cuenta
                        </Link>
                    </nav>
                </div>
            </header>

            <main class="flex-1">
                <section class="p-4 md:p-10">
                    <div class="relative flex min-h-[520px] flex-col items-start justify-center overflow-hidden rounded-xl bg-cover px-8 md:px-20"
                        style="
                        background-position-y: 86%;
                        background-image:
                            linear-gradient(
                                rgba(0, 0, 0, 0.45) 0%,
                                rgba(0, 0, 0, 0.30) 100%
                            ),
                            url('/images/bannerHome4.png');
                    ">

                        <div class="max-w-2xl space-y-6">
                            <span
                                class="inline-block rounded-full border border-[#13ec5b]/30 bg-[#13ec5b]/20 px-4 py-1.5 text-xs font-bold tracking-widest text-[#13ec5b] uppercase">
                                Champú de Romero
                            </span>

                            <h1 class="text-5xl leading-tight font-extrabold tracking-tight text-white md:text-6xl">
                                Crecimiento Natural <br />
                                y Cabello Más Fuerte
                            </h1>

                            <p class="max-w-lg text-lg leading-relaxed font-medium text-gray-200 md:text-xl">
                                Estimula el crecimiento del cabello, fortalece la raíz y ayuda a prevenir la caída.
                                Elaborado con romero natural para una limpieza profunda sin resecar.
                            </p>

                            <div class="flex flex-wrap gap-4 pt-4">
                                <button
                                    class="rounded-xl bg-[#13ec5b] px-8 py-4 font-bold text-[#111813] shadow-lg shadow-[#13ec5b]/20 transition-all hover:-translate-y-1 hover:bg-[#13ec5b]/90">
                                    Comprar ahora
                                </button>

                                <button
                                    class="rounded-xl border border-white/30 bg-white/10 px-8 py-4 font-bold text-white backdrop-blur-md transition-all hover:bg-white/20">
                                    Conoce sus beneficios
                                </button>
                            </div>
                        </div>
                    </div>
                </section>



                <section class="px-6 py-4 md:px-20">
                    <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                        <div
                            class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div
                                class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]">

                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960"
                                    width="35px" fill="#13ec5b">
                                    <path
                                        d="M332-130q-69-30-120.5-81.5T130-332q-30-69-30-148t30-148q30-69 81.5-120.5T332-830q69-30 148-30v-100l160 160-160 160v-100q-108 0-184 76t-76 184q0 66 30.5 122.5T332-266q16-28 47.5-47.5T452-338q-3-21-8-42t-12-39q-11 9-24 14t-28 5q-33 0-56.5-23.5T300-480v-40q0-17-5.5-32T280-580q50-1 89 9 34 9 62 29.5t29 61.5q0 9-1.5 16.5T453-448q-13-10-26-18t-27-14q17 13 39 40t41 64q20-49 50-96.5t70-87.5q-23 16-44 34t-41 38q-7-11-11-24.5t-4-27.5q0-42 29-71t71-29h40q23 0 38-6t25-14q11-9 17-20 4 67-7 120-9 45-34 82.5T600-440q-15 0-28.5-4T547-455q-7 19-16 50.5T517-337q38 7 67 26t44 45q51-35 81.5-91T740-480h120q0 79-30 148t-81.5 120.5Q697-160 628-130t-148 30q-79 0-148-30Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">100% Orgánico</h3>
                                <p class="text-sm leading-snug text-[#61896f]">
                                    Ingredientes certificados obtenidos
                                    responsablemente de la naturaleza.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div
                                class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960"
                                    width="35px" fill="#13ec5b">
                                    <path
                                        d="M380-80q-75 0-127.5-52.5T200-260q0-35 17-64.5t63-75.5q6-6 11.5-12.5T306-430q-51-78-78.5-163.5T200-760q0-58 21-89t59-31q57 0 102 55t68 101q9 20 16.5 40.5T480-641q6-22 13.5-42.5T511-724q22-46 67-101t102-55q38 0 59 31t21 89q0 81-27.5 166.5T654-430q9 11 14.5 17.5T680-400q46 46 63 75.5t17 64.5q0 75-52.5 127.5T580-80q-45 0-72.5-10L480-100l-27.5 10Q425-80 380-80Zm0-80q23 0 46-5.5t43-16.5q-11-5-20-17t-9-21q0-8 11.5-14t28.5-6q17 0 28.5 6t11.5 14q0 9-9 21t-20 17q20 11 43 16.5t46 5.5q42 0 71-29t29-71q0-18-10-35t-30-34q-14-12-23-21t-29-34q-29-35-48-45.5T480-440q-41 0-60.5 10.5T372-384q-20 25-29 34t-23 21q-20 17-30 34t-10 35q0 42 29 71t71 29Zm40-130q-8 0-14-9t-6-21q0-12 6-21t14-9q8 0 14 9t6 21q0 12-6 21t-14 9Zm120 0q-8 0-14-9t-6-21q0-12 6-21t14-9q8 0 14 9t6 21q0 12-6 21t-14 9ZM363-489q11-8 25-14t31-11q-2-48-14.5-95.5T373-696q-19-40-42-67.5T285-799q-2 6-3.5 15.5T280-760q0 68 21.5 138T363-489Zm234 0q40-63 61.5-133T680-760q0-14-1.5-23.5T675-799q-23 8-46 35.5T587-696q-18 39-30.5 86.5T541-514q15 4 29 10.5t27 14.5Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">Sin Pruebas Animales</h3>
                                <p class="text-sm leading-snug text-[#61896f]">
                                    Nunca pruebas en animales. Amigable con todos los seres vivos.
                                </p>
                            </div>
                        </div>

                        <div
                            class="flex items-center gap-5 rounded-2xl border border-[#dbe6df] bg-white p-6 transition-all hover:shadow-xl hover:shadow-[#13ec5b]/5 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
                            <div
                                class="flex size-14 items-center justify-center rounded-xl bg-[#13ec5b]/10 text-[#13ec5b]">
                                <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960"
                                    width="35px" fill="#13ec5b">
                                    <path
                                        d="m720-600-32 28q-14 13-33 13t-33-11q-14-11-19-28t1-36l16-50-34-20q-16-9-22.5-26t-1.5-34q5-17 20-26.5t34-9.5h40l12-38q6-19 20.5-30.5T720-880q17 0 31.5 11.5T772-838l12 38h40q19 0 33.5 9.5T878-764q7 18 0 35t-22 25l-36 20 16 50q6 19 1 36.5T818-570q-15 11-33.5 11T752-572l-32-28Zm28.5-91.5Q760-703 760-720t-11.5-28.5Q737-760 720-760t-28.5 11.5Q680-737 680-720t11.5 28.5Q703-680 720-680t28.5-11.5ZM552-244q23 60-15 112T430-80q-33 0-62.5-17T324-142q-83 12-137.5-42.5T142-324q-30-17-46-46.5T80-438q0-61 55.5-98.5T244-552l62 26q20-31 53-50.5t71-21.5v-82h60v90q37 11 61 34.5t41 65.5h88v60h-82q-2 38-20.5 71T528-306l24 62Zm-248 24q0-27 4.5-52.5T322-322q-23 11-49.5 15.5T220-304q0 39 22.5 61.5T304-220Zm-74-164q32 0 56.5-8t63.5-32l-120-50q-29-12-49.5.5T160-434q0 26 17 38t53 12Zm200 224q25 0 40.5-17.5T478-214l-54-136q-19 32-29.5 64T384-228q0 33 11.5 50.5T430-160Zm66-222q10-10 16-26.5t6-34.5q0-32-21-54t-52-22q-18 0-34 6t-27 17l78 36 34 78Zm-174 60Z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold">
                                    Libre de sintéticos

                                </h3>
                                <p class="text-sm leading-snug text-[#61896f]">
                                    Cero sulfatos agresivos, parabenos ni tintes artificiales.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>

                <section class="px-6 py-16 md:px-20">
                    <div class="mb-12 flex items-end justify-between">
                        <div class="space-y-2">
                            <h2 class="text-4xl font-extrabold tracking-tight">
                                Nuestros Productos
                            </h2>
                            <p class="text-lg font-medium text-[#61896f] dark:text-[#a1b8a9]">
                                Cuidadosamente elaborados para cada tipo de cabello.
                            </p>
                        </div>
                        <a class="flex items-center gap-2 font-bold text-[#13ec5b] hover:underline" href="#">
                            Ver todos
                            <ChevronsRight class="size-8" />
                        </a>
                    </div>

                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
                        <div v-for="product in products" :key="product.id"
                            class="group justify-between flex flex-col gap-5 rounded-2xl border border-[#dbe6df] bg-white p-2 transition-all hover:-translate-y-2 dark:border-[#2a3a2e] dark:bg-[#1a2e20]">
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
                            <div class="px-4  ">
                                <div class="mb-2 flex items-start justify-between">
                                    <h3 class="text-xl font-bold transition-colors group-hover:text-[#13ec5b]">
                                        {{ product.name }}
                                    </h3>
                                    <p class="text-lg font-extrabold text-[#111813] dark:text-white">
                                        ${{ product.price_sale }}
                                    </p>
                                </div>
                                <p class="mb-0 text-sm text-[#61896f] dark:text-[#a1b8a9]">
                                    {{ product.description }}
                                </p>
                            </div>
                            <div class="pb-4 px-4">

                                <Button
                                    class="flex w-full  items-center justify-center gap-2 rounded-xl bg-[#f0f4f2] py-3 font-bold text-[#111813] transition-all hover:bg-[#13ec5b] hover:text-[#111813] dark:bg-[#2a3a2e] dark:text-white">
                                    <ClipboardPlus class="size-4" />
                                    Agregar al Carrito
                                </Button>
                            </div>
                        </div>

                        <!--  <div
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
                        </div> -->
                    </div>
                </section>

                <section class="px-4 pt-10 pb-20">
                    <div
                        class="relative mx-auto max-w-4xl overflow-hidden rounded-3xl bg-[#102216] p-10 text-center md:p-16 dark:bg-[#1a2e20]">
                        
                        <div class="relative z-10 space-y-8">
                            <h2 class="text-3xl font-black tracking-tight text-white md:text-5xl">
                                Únete a la comunidad Plune
                            </h2>
                            <p class="mx-auto max-w-lg text-lg text-gray-400">
                                En Plune creemos que la cosmética no es solo belleza,
                                es una forma consciente de cuidar tu cabello, tu piel
                                y el planeta. Recibe contenido exclusivo, consejos
                                naturales y beneficios especiales por ser parte
                                de nuestra comunidad.
                            </p>
                            <form class="mx-auto flex max-w-md flex-col gap-4 sm:flex-row">
                                <input
                                    class="flex-1 rounded-xl border-white/20 bg-white/10 px-6 text-white placeholder:text-gray-500 focus:border-[#13ec5b] focus:ring-[#13ec5b]"
                                    placeholder="Tu correo electrónico" type="email" />
                                <button
                                    class="rounded-xl bg-[#13ec5b] px-8 py-4 font-bold whitespace-nowrap text-[#111813] transition-all hover:bg-[#13ec5b]/90">
                                    Quiero ser parte
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
                            Cosmética sólida inspirada en la naturaleza.
                            Hecha a mano, responsable con el planeta
                            y pensada para el bienestar de tu cabello y tu piel.
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
                        <h4 class="mb-6 font-bold">Tienda</h4>
                        <ul class="space-y-4 text-sm text-[#61896f]">
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Champús en barra</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Acondicionadores</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Kits y regalos</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Nuevos productos</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-6 font-bold">Ayuda</h4>
                        <ul class="space-y-4 text-sm text-[#61896f]">
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Política de envíos</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Cambios y devoluciones</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Preguntas frecuentes</a>
                            </li>
                            <li>
                                <a class="transition-colors hover:text-[#13ec5b]" href="#">Rastrear pedido</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="mb-6 font-bold">Contacto</h4>
                        <ul class="space-y-4 text-sm text-[#61896f]">
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">mail</span>
                                hola@plune.com
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="material-symbols-outlined text-sm">call</span>
                                +57 300 123 4567
                            </li>
                            <li class="flex items-start gap-2">
                                <span class="material-symbols-outlined text-sm">location_on</span>
                                <span>Colombia</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div
                    class="mt-16 flex flex-col items-center justify-between gap-4 border-t border-[#dbe6df] pt-8 md:flex-row dark:border-[#2a3a2e]">
                    <p class="text-xs text-[#61896f]">
                        © 2026 Plune. Todos los derechos reservados.
                    </p>
                    <div class="flex gap-8 text-xs text-[#61896f]">
                        <a class="hover:text-[#13ec5b]" href="#">Política de privacidad</a>
                        <a class="hover:text-[#13ec5b]" href="#">Términos y condiciones</a>
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
